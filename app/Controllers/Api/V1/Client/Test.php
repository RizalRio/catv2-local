<?php

namespace App\Controllers\Api\V1\Client;

use \IM\CI\Controllers\ApiController;

class Test extends ApiController
{
	protected $module    = 'class';
	protected $modelName = 'App\Models\M_tests';

	public function __construct()
	{
		$this->mUsersTests = new \App\Models\M_users_tests();
	}

	public function show($id = NULL)
	{
		try {
			$id = decryptUrl($id);

			$data = $this->model->baris($id, ['select' => 'a.id, name, description, level, question, open, close, time', 'where' => [['a.active', '1', 'AND'], ['a.deleted', '0', 'AND']]]);

			$data['id']       = encryptUrl($data['id']);
			$data['question'] = explode(',', $data['question']);

			return $this->render(($data) ? TRUE : FALSE, ($data) ? 'Data berhasil ditemukan' : 'Data tidak ditemukan', $data);
		} catch (\Exception $e) {
			return $this->render(FALSE, $e->getMessage());
		}
	}

	public function list()
	{
		$getData = $this->request->getGet();

		if (empty($getData['user']))
			return $this->render(FALSE, 'User ID required');
		if (empty($getData['class']))
			return $this->render(FALSE, 'Class ID required');

		try {
			$userID  = decryptUrl($getData['user']);
			$classID = decryptUrl($getData['class']);

			$tests = $this->model->getClientTests($userID, $classID);

			foreach ($tests as $key => $value) {
				$tests[$key]['id'] = encryptUrl($value['id']);
			}

			$data['total'] = count($tests);
			$data['rows']  = $tests;

			return $this->render(($data) ? TRUE : FALSE, ($data) ? count($data) . ' Data berhasil ditemukan' : 'Data tidak ditemukan', $data);
		} catch (\Exception $e) {
			return $this->render(FALSE, $e->getMessage());
		}
	}

	public function do()
	{
		$getData = $this->request->getGet();

		if (empty($getData['user']))
			return $this->render(FALSE, 'User ID required');
		if (empty($getData['class']))
			return $this->render(FALSE, 'Class ID required');
		if (empty($getData['test']))
			return $this->render(FALSE, 'Test ID required');

		try {
			$userID  = decryptUrl($getData['user']);
			$classID = decryptUrl($getData['class']);
			$testID  = decryptUrl($getData['test']);

			$mUsersTests = new \App\Models\M_users_tests();
			$userTest    = $mUsersTests->baris([['class_id', $classID], ['a.user_id', $userID], ['test_id', $testID]]);
			$min         = $sec = 0;
			$questions   = [];

			if ($userTest['start'] == $userTest['end']) {
				$mTests = new \App\Models\M_tests();
				$test   = $mTests->baris($testID, ['select' => ['a.id', 'name', 'description', 'level', 'question', 'open', 'close', 'time']]);

				$startTime = date('Y-m-d H:i:s');
				$endTime   = date('Y-m-d H:i:s', strtotime('+' . $test['time'] . ' minutes', strtotime($startTime)));

				$questions = explode(',', $test['question']);
				$answers   = new \stdClass();
				foreach ($questions as $key => $value) {
					$answers->{$value} = '';
				}

				$data = [
					'start'   => $startTime,
					'end'     => $endTime,
					'answers' => json_encode($answers),
					'status'  => 'Ongoing',
					'user_id' => $userID
				];
				$mUsersTests->ubah($userTest['id'], $data);

				$min = round($test['time']);
				$sec = 0;
			} else {
				$endTime   = new \DateTime($userTest['end']);
				$now       = new \DateTime();
				$questions = explode(',', $userTest['question']);
				$answers   = json_decode($userTest['answers']);
				if ($now <= $endTime) {
					$diff      = $endTime->diff(new \DateTime());
					$min       = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
					$sec       = $diff->s;
				} else {
					$mUsersTests->ubah($userTest['id'], ['status' => 'Done', 'user_id' => $userID]);
				}
			}

			foreach ($questions as $key => $value) {
				$questions[$key] = encryptUrl($value);
			}

			$this->data['id']        = encryptUrl($userTest['id']);
			$this->data['timer']     = sprintf('%02d:%02d:%02d', ($min / 60), ($min % 60), $sec);
			$this->data['questions'] = $questions;
			$this->data['answers']   = $answers;

			return $this->render(TRUE, 'Berhasil', $this->data);
		} catch (\Exception $e) {
			return $this->render(FALSE, $e->getMessage());
		}
	}
}
