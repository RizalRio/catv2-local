<?php

namespace App\Controllers\Support;

use \IM\CI\Controllers\AdminController;

class Import extends AdminController
{
  protected $spreadsheet;

  public function index()
  {
    $file      = $this->request->getFile('file');
    $extension = $file->getClientExtension();
    if ($extension == 'xls') {
      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    } else {
      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }
    $this->spreadsheet = $reader->load($file);
    return $this->{'_' . $this->request->uri->getSegment(3)}();
  }

  private function _questions()
  {
    $dataReferences = $this->spreadsheet->setActiveSheetIndex(0)->toArray(null, true, true, true);
    $dataQuestions  = $this->spreadsheet->setActiveSheetIndex(1)->toArray(null, true, true, true);
    $dataAnswers    = $this->spreadsheet->setActiveSheetIndex(2)->toArray(null, true, true, true);

    $arrayCount       = count($dataQuestions);
    $arrayCountAnswer = count($dataAnswers);
    $flag             = 0;

    $createArray = array('No', 'Method', 'Question', 'Active');
    $makeArray   = array('No' => 'no', 'Method' => 'method', 'Question' => 'question', 'Active' => 'active');

    $SheetDataKey = array();
    foreach ($dataQuestions as $dataInSheet) {
      foreach ($dataInSheet as $key => $value) {
        if (in_array(trim($value), $createArray)) {
          $value = preg_replace('/\s+/', '', $value);
          $SheetDataKey[trim($value)] = $key;
        }
      }
    }

    $dataDiff = array_diff_key($makeArray, $SheetDataKey);
    if (empty($dataDiff)) {
      $flag = 1;
    }

    if ($flag == 1) {
      $no         = $noAnswer = $jml = 0;
      $errors     = '';
      $mQuestions = new \App\Models\M_questions_tmp();
      $mAnswers   = new \App\Models\M_answers_tmp();

      for ($i = 3; $i <= $arrayCount; $i++) {
        $proses = FALSE;

        $noSoal   = filter_var(trim($dataQuestions[$i][$SheetDataKey['No']]), FILTER_SANITIZE_STRING);
        $method   = filter_var(trim($dataQuestions[$i][$SheetDataKey['Method']]), FILTER_SANITIZE_STRING);
        $question = filter_var(trim($dataQuestions[$i][$SheetDataKey['Question']]), FILTER_SANITIZE_STRING);
        $active   = filter_var(trim($dataQuestions[$i][$SheetDataKey['Active']]), FILTER_SANITIZE_STRING);

        if ($mQuestions->baris([['question', $question]])) {
          $errors .= 'No. ' . ++$no . ' Soal sudah ada.<br>';
        } else {
          $proses = TRUE;
        }

        if ($proses) {
          $newdata = [
            'method_id' => $method,
            'question'  => $question,
            'active'    => $active,
          ];
          $questionID = $mQuestions->tambah($newdata);
          if (isset($questionID) && $questionID == TRUE) {
            $jml++;
            $this->im_logger->action('create')->module('question')->moduleId($questionID)->status('1')->log();

            for ($j = 3; $j <= $arrayCountAnswer; $j++) {
              if (filter_var(trim($dataAnswers[$j]['B']), FILTER_SANITIZE_STRING) == $noSoal) {
                $dimension = filter_var(trim($dataAnswers[$j]['C']), FILTER_SANITIZE_STRING);
                $answer    = filter_var(trim($dataAnswers[$j]['D']), FILTER_SANITIZE_STRING);
                $feedback  = filter_var(trim($dataAnswers[$j]['E']), FILTER_SANITIZE_STRING);
                $point     = filter_var(trim($dataAnswers[$j]['F']), FILTER_SANITIZE_STRING);
                $active    = filter_var(trim($dataAnswers[$j]['G']), FILTER_SANITIZE_STRING);
                $newdata = [
                  'question_id'  => $questionID,
                  'dimension_id' => $dimension,
                  'answer'       => $answer,
                  'feedback'     => $feedback,
                  'point'        => $point,
                  'active'       => $active,
                ];
                $answerID = $mAnswers->tambah($newdata);
                if (isset($answerID) && $answerID == TRUE) {
                  $this->im_logger->action('create')->module('answers')->moduleId($questionID)->status('1')->log();
                } else {
                  $this->postal->add('No. Jawaban ' . ++$noAnswer . ' tidak dapat disimpan', 'error');
                }
              }
            }
          } else {
            $this->postal->add('No. Soal ' . $no . ' tidak dapat disimpan', 'error');
          }
        }
      }

      if ($errors != '')
        $this->im_message->add('success', $errors);

      $this->im_message->add('success', $jml . ' ' . 'data berhasil dimport');
    } else {
      $this->im_message->add('danger', 'File tidak sesuai. Silakan download template terlebih dahulu.');
    }
    return redirect()->to(site_url('support/questions/import'));
  }
}
