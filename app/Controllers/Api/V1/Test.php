<?php

namespace App\Controllers\Api\V1;

use \IM\CI\Controllers\ApiController;

class Test extends ApiController
{
	protected $module    = 'tests';
	protected $modelName = 'App\Models\M_tests';

	public function __construct()
	{
		helper('auth');
	}

	public function show($id = NULL)
	{
		if (is_null($id))
			$this->render(FALSE, 'ID tidak ditemukan');

		$data = $this->model->baris($id, ['select' => 'a.id, name, description, level, question, open, close, time', 'where' => [['a.active', '1', 'AND'], ['a.deleted', '0', 'AND']]]);

		$data['id']       = encryptUrl($data['id']);
		$data['question'] = count(explode(',', $data['question']));

		return $this->render(($data) ? TRUE : FALSE, ($data) ? 'Data berhasil ditemukan' : 'Data tidak ditemukan', $data);
	}

	public function listByClient()
	{
		$id = $this->request->getGet('id');

		if (is_null($id))
			$this->render(FALSE, 'ID tidak ditemukan');

		$id   = decryptUrl($id);
		$data = $this->model->getClientTests($id);

		foreach ($data as $key => $value) {
			$data[$key]['uid'] = encryptUrl($value['id']);
		}

		return $this->render(($data) ? TRUE : FALSE, ($data) ? count($data) . ' Data berhasil ditemukan' : 'Data tidak ditemukan', $data);
	}

	public function do($id)
	{
		try {
			$id     = decryptUrl($id);
		} catch (\Exception $e) {
			return $this->render(FALSE, 'Data tidak ditemukan');
		}

		$userID = $this->request->getGet('u');

		$mUsersTests = new \App\Models\M_users_tests();
		$userTest    = $mUsersTests->baris([['user_id', $userID], ['test_id', $id]]);
		$min         = $sec = 0;
		$questions   = [];

		if ($userTest == NULL) {
			$mTests = new \App\Models\M_tests();
			$test   = $mTests->baris($id, ['select' => ['a.id', 'name', 'description', 'level', 'question', 'open', 'close', 'time']]);

			$startTime = date('Y-m-d H:i:s');
			$endTime   = date('Y-m-d H:i:s', strtotime('+' . $test['time'] . ' minutes', strtotime($startTime)));

			$questions = explode(',', $test['question']);
			$answers   = new \stdClass();
			foreach ($questions as $key => $value) {
				$answers->{$value} = '';
			}

			$data = [
				'user_id' => $userID,
				'test_id' => $id,
				'start'   => $startTime,
				'end'     => $endTime,
				'answers' => json_encode($answers),
				'status'  => 'Ongoing',
				'active'  => '1'
			];
			$testID = $mUsersTests->tambah($data);

			$min = round($test['time']);
			$sec = 0;
		} else {
			$endTime   = new \DateTime($userTest['end']);
			$now       = new \DateTime();
			$testID    = $userTest['id'];
			$questions = explode(',', $userTest['question']);
			$answers   = json_decode($userTest['answers']);
			if ($now <= $endTime) {
				$diff      = $endTime->diff(new \DateTime());
				$min       = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
				$sec       = $diff->s;
			} else {
				$mUsersTests->ubah($testID, ['status' => 'Done']);
			}
		}

		$this->data['timer']     = sprintf('%02d:%02d:%02d', ($min / 60), ($min % 60), $sec);
		$this->data['questions'] = $questions;
		$this->data['answers']   = $answers;

		return $this->render(TRUE, 'Berhasil', $this->data);
	}

	public function answer()
	{
		$postData = $this->request->getPost();
		try {
			$id = decryptUrl($postData['t']);
			$q  = decryptUrl($postData['q']);
			$a  = decryptUrl($postData['a']);
			$f  = (empty($postData['f'])) ? '0' : $postData['f'];

			$mUsersTests = new \App\Models\M_users_tests();
			$userTest    = $mUsersTests->baris($id);

			if ($userTest == NULL)
				return $this->render(FALSE, 'Tes tidak ditemukan '.$id);

			if ($userTest['status'] == 'Active' || $userTest['status'] == 'Ready') {
				return $this->render(FALSE, 'Jawaban tidak tersimpan. Tes belum dimulai');
			} else if ($userTest['status'] == 'Ongoing') {
				$answers = json_decode($userTest['answers']);

				$answers->{$q} = $a;

				if ($f == 1)
					$mUsersTests->ubah($id, ['answers' => json_encode($answers), 'user_id' => $userTest['user_id'], 'status' == 'Done']);
				else
					$mUsersTests->ubah($id, ['answers' => json_encode($answers), 'user_id' => $userTest['user_id']]);

				return $this->render(TRUE, 'Jawaban nomor ' . $postData['n'] . ' tersimpan');
			} else if ($userTest['status'] == 'Done') {
				return $this->render(FALSE, 'Jawaban tidak tersimpan. Tes sudah selesai');
			}
		} catch (\Exception $e) {
			return $this->render(FALSE, $e->getMessage());
			// return $this->render(FALSE, 'Jawaban nomor ' . $postData['n'] . ' tidak tersimpan');
		}
	}
}
