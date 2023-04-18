<?php

namespace App\Controllers\Api\V1;

use \IM\CI\Controllers\ApiController;

class Question extends ApiController
{
	protected $module    = 'tests';
	protected $modelName = 'App\Models\M_questions';

	public function show($id = NULL)
	{
		if (is_null($id))
			$this->render(FALSE, 'ID tidak ditemukan');

		try {
			$id = decryptUrl($id);
		} catch (\Exception $e) {
			$this->render(FALSE, 'Terjadi kesalahan');
		}

		$question = $this->model->baris($id, ['select' => 'a.id, question', 'where' => [['a.active', '1', 'AND'], ['a.deleted', '0', 'AND']]]);

		if ($question == NULL)
			return $this->render(FALSE, 'Soal tidak ditemukan');

		$mAnswer = new \App\Models\M_answers();
		$answers = $mAnswer->efektif(['select' => 'a.id, answer', 'where' => [['question_id', $id, 'AND']]])['rows'];

		$question['id'] = encryptUrl($question['id']);

		foreach ($answers as $key => $value) {
			$answers[$key]['id'] = encryptUrl($value['id']);
		}

		if ($question)
			$data = array_merge($question, ['answers' => $answers]);

		return $this->render(($data) ? TRUE : FALSE, ($question) ? 'Data berhasil ditemukan' : 'Data tidak ditemukan', $data);
	}
}
