<?php

namespace App\Controllers;

use \IM\CI\Controllers\PublicController;

class ClassController extends PublicController
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
			$mClassUsers = new \App\Models\M_classes_users();

			$classes = $mClassUsers->efektif(['where' => [['user_id', user()->id, 'AND']]])['rows'];

			foreach ($classes as $key => $value) {
				$classes[$key]['class_id'] = encryptUrl($value['class_id']);
			}

			$this->data['classes'] = $classes;
			$this->render('client/class');
		} catch (\Exception $e) {
			$this->render('client/error');
		}
	}

	public function detail($classID)
	{
		try {
			$classID = decryptUrl($classID);
			$mClassTests = new \App\Models\M_classes_tests();

			$params = [
				'select' => ["c.id", "c.name", "c.description", "IF(c.open = '0000-00-00', CAST(NOW() AS Date), c.open) 'open'", "IF(c.close = '0000-00-00', CAST(NOW() AS Date), c.close) 'close'", "c.time", "d.status"],
				'join' => [
					['users_tests d', 'd.test_id = a.test_id AND d.class_id = a.class_id', 'LEFT'],
					['classes_users e', 'e.class_id = a.class_id', 'LEFT']
				],
				'where' => [
					['a.class_id', $classID, 'AND'],
					['e.user_id', user()->id, 'AND'],
				],
				'order' => [
					['open', 'desc']
				]
			];
			$tests = $mClassTests->eksis($params)['rows'];

			foreach ($tests as $key => $value) {
				$tests[$key]['id']       = encryptUrl($value['id']);
				$tests[$key]['class_id'] = encryptUrl($classID);
			}

			$this->data['tests'] = $tests;
			$this->render('client/class-tests');
		} catch (\Exception $e) {
			$this->render('client/error');
		}
	}

	public function details($classID)
	{
		try {
			$classID = decryptUrl($classID);
			$mTests  = new \App\Models\M_tests();

			$params = [
				'select' => ["b.id", "a.name", "a.description", "IF(a.open = '0000-00-00', CAST(NOW() AS Date), a.open) 'open'", "IF(a.close = '0000-00-00', CAST(NOW() AS Date), a.close) 'close'", "a.time", "b.status"],
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
