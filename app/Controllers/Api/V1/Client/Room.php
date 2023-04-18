<?php

namespace App\Controllers\Api\V1\Client;

use \IM\CI\Controllers\ApiController;

class Room extends ApiController
{
	protected $module    = 'class';
	protected $modelName = 'App\Models\M_classes_users';

	public function show($id = NULL)
	{
		try {
			$id = decryptUrl($id);
			
			if($id == NULL)
			    return $this->render(FALSE, 'User tidak ditemukan');
			
			$params = [
				'select' => ['a.class_id', 'b.name', 'b.description', '(SELECT COUNT(id) FROM users_tests WHERE user_id = "' . $id . '" AND status <> "Done") tests'],
				'join' => [
					['users_tests c', 'c.id = a.class_id', 'LEFT']
				],
				'where' => [
					['a.user_id', $id, 'AND']
				]
			];
			$data = $this->model->efektif($params);
			foreach ($data['rows'] as $key => $value) {
				$data['rows'][$key]['class_id'] = encryptUrl($data['rows'][$key]['class_id']);
			}
			return $this->render(($data) ? TRUE : FALSE, ($data) ? 'Data berhasil ditemukan' : 'Data tidak ditemukan', $data);
		} catch (\Exception $e) {
			return $this->render(FALSE, $e->getMessage());
		}
	}
}
