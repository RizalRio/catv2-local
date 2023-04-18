<?php

namespace App\Controllers;

use DateTime;
use \IM\CI\Controllers\PublicController;
use stdClass;

class Test extends PublicController
{

	public function __construct()
	{
		helper('auth');
		if (has_permission('management'))
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	}

	public function index()
	{
		try {
			$mUsersTests = new \App\Models\M_users_tests();

			$tests = $mUsersTests->efektif(['where' => [['a.user_id', user()->id, 'AND']], 'order' => [['open', 'desc']]])['rows'];

			foreach ($tests as $key => $value) {
				$tests[$key]['id'] = encryptUrl($value['id']);
			}

			$this->data['tests'] = $tests;
			$this->render('client/tests');
		} catch (\Exception $e) {
			$this->render('client/error');
		}
	}

	public function register($classID, $testID)
	{
		try {
			$classID     = decryptUrl($classID);
			$testID      = decryptUrl($testID);
			$mUsersTests = new \App\Models\M_users_tests();
			if ($userTest = $mUsersTests->baris([['class_id', $classID], ['a.user_id', user()->id], ['test_id', $testID]])) {
				$userTestID = $userTest['id'];
			} else {
				$data        = [
					'class_id'      => $classID,
					'user_id'       => user()->id,
					'test_id'       => $testID,
					'start'         => '0000-00-00 00:00',
					'end'           => '0000-00-00 00:00',
					'answers'       => 0,
					'last_question' => '0',
					'status'        => 'Active',
					'active'        => '1'
				];
				$userTestID = $mUsersTests->tambah($data);
			}

			return redirect()->to(site_url('test/instruction/' . encryptUrl($userTestID)));
		} catch (\Exception $e) {
			$this->render('client/error');
		}
	}

	public function instruction($id)
	{
		try {
			$id          = decryptUrl($id);
			$mUsersTests = new \App\Models\M_users_tests();
			$mUsersTests->ubah($id, ['status' => 'Ready']);
			$userTest = $mUsersTests->baris($id);

			$this->data['id']      = $id;
			$this->data['test_id'] = $userTest['test_id'];
			$this->data['content'] = 'pre';
			$this->render('client/pre-post');
		} catch (\Exception $e) {
			$this->render('client/error');
		}
	}

	public function pause($id)
	{
		try {
			$id          = decryptUrl($id);
			$mUsersTests = new \App\Models\M_users_tests();
			$status      = $this->request->getGet('state');
			$mUsersTests->ubah($id, ['status' => $status]);
			$redirect = site_url($this->request->getGet('goto'));
			return redirect()->to($redirect);
		} catch (\Exception $e) {
		}
	}

	public function do($id)
	{
		try {
			$testID = decryptUrl($id);
		} catch (\Exception $e) {
			$this->errorPage();
		}

		$mUsersTests = new \App\Models\M_users_tests();
		$userTest    = $mUsersTests->baris($testID);
		$min         = $sec = 0;
		$questions   = [];

		if (is_null($userTest))
			return redirect()->to(site_url('dashboard'));


		if ($userTest['status'] == 'Done')
			return redirect()->to(site_url('test/finish/' . $id));

		if ($userTest['start'] == $userTest['end']) {
			$mTests = new \App\Models\M_tests();
			$test   = $mTests->baris($userTest['test_id'], ['select' => ['a.id', 'name', 'description', 'level', 'question', 'open', 'close', 'time']]);

			$minute = $test['time'] / 60;
			$startTime = date('Y-m-d H:i:s');
			$endTime   = date('Y-m-d H:i:s', strtotime('+' . $minute. ' minutes', strtotime($startTime)));

			$questions = explode(',', $test['question']);
			$answers = new stdClass();
			foreach ($questions as $key => $value) {
				$answers->{$value} = '';
			}
			$last = $questions[0];

			$data = [
				'start'    => $startTime,
				'end'      => $endTime,
				'answers'  => json_encode($answers),
				'status'   => 'Ongoing',
			];
			$mUsersTests->ubah($testID, $data);

			$userTest['start'] = $startTime;
			$userTest['end']   = $endTime;

			$min = round($test['time'] / 60);
			$sec = 0;
		} else {
			$endTime   = new DateTime($userTest['end']);
			$now       = new DateTime();
			$questions = explode(',', $userTest['question']);
			$answers   = json_decode($userTest['answers']);
			$last      = $userTest['last_question'];
			if ($now <= $endTime) {
				$diff      = $endTime->diff(new DateTime());
				$min       = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
				$sec       = $diff->s;
				$mUsersTests->ubah($testID, ['status' => 'Ongoing']);
			} else {
				$mUsersTests->ubah($testID, ['status' => 'Done']);
			}
		}

		if (date('Y-m-d H:i:s') >= $userTest['end'])
			return redirect()->to(site_url('test/finish/' . $id));

		$this->data['timer']     = sprintf('%02d:%02d:%02d', ($min / 60), ($min % 60), $sec);
		$this->data['questions'] = $questions;
		$this->data['last']      = $last;
		$this->data['id']        = encryptUrl($testID);
		$this->data['answers']   = $answers;

		$this->render('client/test-sheet');
	}

	public function getQuestion()
	{
		$tID = decryptUrl($this->request->getGet('t'));
		$qID = decryptUrl($this->request->getGet('q'));
		$no  = $this->request->getGet('n');

		$mQuestions = new \App\Models\M_questions();
		$question   = $mQuestions->baris($qID, ['select' => 'a.id, question', 'where' => [['a.active', '1', 'AND'], ['a.deleted', '0', 'AND']]]);

		$mAnswer = new \App\Models\M_answers();
		$answers = $mAnswer->efektif(['select' => 'a.id, answer', 'where' => [['question_id', $qID, 'AND']]])['rows'];

		$mUsersTests = new \App\Models\M_users_tests();
		$userTest    = json_decode($mUsersTests->baris($tID, ['select' => 'answers'])['answers']);
		$mUsersTests->ubah($tID, ['last_question' => $qID]);

		$data = NULL;
		if ($question) {
			$data = '
    <div class="row mb-3">
      <div class="col">
				<p><span class="label label-square label-dark label-inline font-weight-bold p-5 font-size-h3">No. Soal:</span><span class="label label-square label-secondary label-inline font-weight-bold p-5 font-size-h3" id="timer">' . $no . '</span></p>
        <p>' . $question['question'] . '</p>
      </div>
    </div>';
			foreach ($answers as $answer) {
				$checked = ($userTest->{$qID} == $answer['id']) ? 'checked="checked"' : '';
				$data .= '<div class="d-flex justify-content-start my-2">
        <label class="radio radio-outline radio-outline-2x radio-success">
          <input type="radio" name="answer" value="' . encryptUrl($answer['id']) . '" ' . $checked . ' />
          <span class="mx-2"></span>
          ' . $answer['answer'] . '
        </label>
      </div>';
			}
		}

		return $this->ajaxResponse(($data) ? TRUE : FALSE, ($data) ? 'Data berhasil ditemukan' : 'Data tidak ditemukan', $data);
	}

	public function confirmFinish()
	{
		return $this->ajaxResponse(TRUE, '', view('client/modal-finish'));
	}

	public function finish($id)
	{
		$id = decryptUrl($id);
		$mUsersTests = new \App\Models\M_users_tests();
		$mUsersTests->ubah($id, ['status' => 'Done']);

		$this->data['content'] = 'post';
		$this->render('client/pre-post');
	}
}
