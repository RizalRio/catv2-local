<?php

namespace App\Controllers\Support;

use \IM\CI\Controllers\AdminController;

class Dashboard extends AdminController
{
	protected $module = 'dashboard';

	public function getOrderPerMonth()
	{
		$month = [];
		$total = [];

		$mOrders = new \App\Models\M_orders();

		$params = [
			'select' => ['DATE_FORMAT(a.created_at, "%Y-%m") as month', 'count(a.id) as total'],
			'group' => ['month'],
			'order' => [['month', 'asc']]
		];

		$data = $mOrders->efektif($params);

		foreach ($data['rows'] as $index => $row) {
			array_push($total, $row['total']);
			array_push($month, $row['month']);
		}

		$return = [
			'month' => $month,
			'total' => array_map('intval', $total)
		];

		return $this->response->setJSON($return);
	}

	public function getUnconfirmedOrder()
	{
		$mOrders = new \App\Models\M_orders();

		$data = $mOrders->eksis(['where' => [['a.active', 0, 'AND']], 'order' => [['a.created_at', 'asc']]]);

		foreach ($data['rows'] as $index => $row) {
			$data['rows'][$index]['id'] = encryptUrl($row['id']);
		}

		return $this->response->setJSON($data);
	}

	public function getAllUserTest($params = null)
	{
		$status = [];
		$total = [];
		$all = 0;
		$mUsersTests = new \App\Models\M_users_tests();

		$params = [
			'select' => ['a.status', 'count(a.status) jumlah'],
			'group' => ['a.status'],
		];

		$data = $mUsersTests->efektif($params);

		foreach ($data['rows'] as $index => $row) {
			array_push($total, $row['jumlah']);
			array_push($status, $row['status']);
			$all += $row['jumlah'];
		}

		$return = [
			'status' => $status,
			'total' => array_map('intval', $total),
			'all' => intval($all)
		];

		return $this->response->setJSON($return);
	}

	public function index()
	{
		$mLogins = new \IM\CI\Models\App\M_authLogins();
		$this->data['logins'] = $mLogins->semua(['like' => [['date', date('Y-m-d'), 'after']]])['rows'];

		$this->data['js'] = [
			'assets/js/' . $this->module . '/dashboard.min.js',
		];
		$this->render('support/dashboard');
	}
}
