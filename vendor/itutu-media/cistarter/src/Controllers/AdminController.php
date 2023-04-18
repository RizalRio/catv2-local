<?php

namespace IM\CI\Controllers;

use IM\CI\Controllers\GlobalController;

class AdminController extends GlobalController
{

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);

		if (getConfig('adminMaintenance') === TRUE) {
			echo view('admin/maintenance');
			exit;
		}

		$this->data['button'] = [
			'filter' => true,
			'export' => [
				'print' => true,
				'copy'  => true,
				'excel' => true,
				'pdf'   => true
			],
			'add' => [
				'create'  => true,
				'import' => false
			]
		];
	}

	protected function render($viewFile = NULL)
	{
		if ($viewFile === NULL || $viewFile === 'json') {
			echo json_encode($this->data);
			die;
		} else {

			$this->data['css'] = ($this->data['css']) ?? '';
			$this->data['js']  = ($this->data['js']) ?? '';

			$mMenu   = new \IM\CI\Models\Menu\M_menus();
			$sideBar = $mMenu->getMenu('Admin Sidebar');

			$this->data['pageTitle']  = ($this->data['pageTitle']) ?? 'Dashboard';
			$this->data['title']      = ($this->data['title']) ?? 'Dashboard';
			$this->data['subTitle']   = ($this->data['subTitle']) ?? '';
			$this->data['sidebar']    = $this->menuBuilder->adminSidebarBuilder($sideBar);
			$this->data['breadCrumb'] = ($this->data['breadCrumb']) ?? ['Dashboard' => 'support'];

			$this->data['messages']		= ($this->data['messages']) ?? $this->im_message->get();

			echo view($viewFile, $this->data);
			die;
		}
	}
}
