<?php

namespace App\Controllers\Api\V2;

use \IM\CI\Controllers\ApiController;
use stdClass;
use DateTime;

class Test extends ApiController
{
  protected $module    = 'tests';
  protected $modelName = 'App\Models\M_users_tests';

  public function __construct()
  {
    helper('auth');
  }

  public function instruction()
  {
    try {
      $this->data['instruction'] = getConfig('generalInstruction');
      return $this->render(TRUE, 'Data Berhasil Ditarik', $this->data);
    } catch (\Exception $e) {
      return $this->render(FALSE, $e->getMessage());
    }
  }

  public function do($userTestID)
  {
    try {
      $userTestID = decryptUrl($userTestID);

      $userTest    = $this->model->baris($userTestID);

      if (is_null($userTest))
        return $this->render(FALSE, 'Tes tidak ditemukan');

      if ($userTest['status'] == 'Done')
        return $this->render(FALSE, 'Tes sudah selesai');

      $min         = $sec = 0;
      $questions   = [];

      if ($userTest['start'] == $userTest['end']) {
        $mTests = new \App\Models\M_tests();
        $test   = $mTests->baris($userTest['test_id'], ['select' => ['a.id', 'name', 'description', 'level', 'question', 'open', 'close', 'time']]);

        $minute = $test['time'] / 60;
        $startTime = date('Y-m-d H:i:s');
        $endTime   = date('Y-m-d H:i:s', strtotime('+' . $minute . ' minutes', strtotime($startTime)));

        $questions = explode(',', $test['question']);
        $answers = new stdClass();
        foreach ($questions as $key => $value) {
          $answers->{$value} = '';
        }
        $last = $questions[0];

        $data = [
          'start'   => $startTime,
          'end'     => $endTime,
          'answers' => json_encode($answers),
          'status'  => 'Ongoing',
        ];
        $this->model->ubah($userTestID, $data);

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
          $diff = $endTime->diff(new DateTime());
          $min  = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
          $sec  = $diff->s;
          $this->model->ubah($userTestID, ['status' => 'Ongoing']);
        } else {
          $this->model->ubah($userTestID, ['status' => 'Done']);
        }
      }

      foreach ($questions as $key => $value) {
        $questions[$key] = encryptUrl($value);
      }

      $this->data['id']        = encryptUrl($userTest['id']);
      $this->data['user_test'] = encryptUrl($userTest['id']);
      $this->data['timer']     = sprintf('%02d:%02d:%02d', ($min / 60), ($min % 60), $sec);
      $this->data['questions'] = $questions;
      $this->data['answers']   = $answers;

      return $this->render(TRUE, 'Berhasil', $this->data);
    } catch (\Exception $e) {
      return $this->render(FALSE, $e->getMessage());
    }
  }

  public function answer()
  {
    $postData = $this->request->getPost();
    try {
      $id = decryptUrl($postData['t']);
      $q  = decryptUrl($postData['q']);
      $a  = decryptUrl($postData['a']);
      $f  = $postData['f'];

      $userTest    = $this->model->baris($id);

      if ($userTest == NULL)
        return $this->render(FALSE, 'Tes tidak ditemukan');

      if ($userTest['status'] == 'Done')
        return $this->render(FALSE, 'Jawaban tidak tersimpan. Tes sudah selesai');

      if ($userTest['status'] == 'Active' || $userTest['status'] == 'Ready')
        return $this->render(FALSE, 'Jawaban tidak tersimpan. Tes belum dimulai');

      if ($userTest['status'] == 'Ongoing') {
        $answers = json_decode($userTest['answers']);

        $answers->{$q} = $a;

        $data = ['answers' => json_encode($answers), 'user_id' => $userTest['user_id']];

        if ($f == "1")
          $data['status'] = 'Done';
          
        $this->model->ubah($id, $data);

        return $this->render(TRUE, 'Jawaban nomor ' . $postData['n'] . ' tersimpan');
      }
    } catch (\Exception $e) {
      return $this->render(FALSE, 'Jawaban nomor ' . $postData['n'] . ' tidak tersimpan');
    }
  }
}
