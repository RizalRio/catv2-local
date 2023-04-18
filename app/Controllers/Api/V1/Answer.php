<?php

namespace App\Controllers\Api\V1;

use \IM\CI\Controllers\ApiController;

class Answer extends ApiController
{
	protected $module    = 'answers';
	protected $modelName = 'App\Models\M_answers';

	public function show($id = NULL)
	{
		if (is_null($id))
			$this->render(FALSE, 'ID tidak ditemukan');

		try {
			$id = decryptUrl($id);
		} catch (\Exception $e) {
			$this->render(FALSE, 'Terjadi kesalahan');
		}

		$data = $this->model->efektif(['select' => ['a.id', 'answer'], 'where' => [['question_id', $id, 'AND']]]);
		
		if ($data == NULL)
			return $this->render(FALSE, 'Soal tidak ditemukan');
		
		foreach ($data['rows'] as $key => $value) {
			$data['rows'][$key]['id'] = encryptUrl($value['id']);
		}

		return $this->render(TRUE, ($data) ? 'Data berhasil ditemukan' : 'Data tidak ditemukan', $data);
	}
}
