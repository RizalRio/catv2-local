<?php

namespace App\Controllers;

use \IM\CI\Controllers\PublicController;

class Dashboard extends PublicController
{

	public function __construct()
	{
		if (has_permission('management'))
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	}

	public function index()
	{
		$mUsersTests = new \App\Models\M_users_tests();

		$params = [
			'select' => ['a.id', 'b.name', 'b.description', 'a.status', 'a.start', 'a.end', 'time', 'open', 'close'],
			'where' => [
				['a.user_id', user()->id, 'AND']
			],
			'order' => [['open', 'desc']]
		];
		$data = $mUsersTests->efektif($params);
		foreach ($data['rows'] as $key => $value) {
			$data['rows'][$key]['id'] = encryptUrl($data['rows'][$key]['id']);
		}

		$this->data['tests']   = $data['rows'];
		$this->data['message'] = $this->im_message->get();

		$this->render('client/dashboard');
	}
}