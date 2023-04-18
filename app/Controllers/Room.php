<?php

namespace App\Controllers;

use \IM\CI\Controllers\PublicController;

class Room extends PublicController
{

	public function __construct()
	{
		helper('auth');
		if (has_permission('management'))
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	}

	public function index($classID)
	{
		try {
			$classID = decryptUrl($classID);
			$mTests  = new \App\Models\M_tests();

			$params = [
				'select'=>["b.id", "a.name", "a.description", "IF(a.open = '0000-00-00', CAST(NOW() AS Date), a.open) 'open'", "IF(a.close = '0000-00-00', CAST(NOW() AS Date), a.close) 'close'", "a.time", "b.status"],
				'join' => [
					['users_tests b', 'test_id = a.id', 'LEFT']
				],
				'where' => [
					['b.class_id', $classID, 'AND']
				]
			];
			// $tests   = $mTests->getClientTests(user()->id, $classID);
			$tests = $mTests->eksis($params)['rows'];

			foreach ($tests as $key => $value) {
				$tests[$key]['id'] = encryptUrl($value['id']);
			}

			// dd($tests);

			$this->data['tests']  = $tests;

			$this->render('client/room');
		} catch (\Exception $e) {
			// d($e->getMessage());
		}
	}
}
