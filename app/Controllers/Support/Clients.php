<?php

namespace App\Controllers\Support;

use \IM\CI\Controllers\AdminController;

class Clients extends AdminController
{
	protected $module = 'clients';

	public function __construct()
	{
		if (!in_groups(['IM', 'SA']) && !has_permission($this->module))
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		$this->model = new \IM\CI\Models\App\M_userDetail();
	}

	public function index()
	{
		helper(['form']);
		$forms['name'] = [
			'type'  => 'input',
			'label' => 'Name',
			'name'  => 'name',
			'field' => [
				'class' => 'form-control filter-input',
				'name'  => 'name',
			]
		];
		$forms['description'] = [
			'type'  => 'input',
			'label' => 'Description',
			'name'  => 'description',
			'field' => [
				'class' => 'form-control filter-input',
				'name'  => 'description',
			]
		];
		$forms['active'] = [
			'type'  => 'dropdown',
			'label' => 'Status',
			'name'  => 'active',
			'field' => [
				'class'   => 'form-control filter-input',
				'name'    => 'active',
				'options' => [
					''  => 'All',
					'0' => 'Tidak Aktif',
					'1' => 'Aktif'
				],
			]
		];

		$this->data['forms'] = $forms;
		$this->data['js']    = [
			'assets/js/users/data.min.js'
		];
		$this->data['pageTitle']  = 'Clients';
		$this->data['title']      = 'Data Clients';
		$this->data['subTitle']   = 'Metode tes yang digunakan';
		$this->data['breadCrumb'] = ['Dashboard' => 'support', 'Clients' => ''];
		$this->data['module']     = $this->module;
		$this->data['table']      = 'table_users';

		$this->data['button']['add'] = false;
		$this->render('\IM\CI\Views\vAList');
	}

	public function list()
	{
		$this->isAjaxReq('post');

		$pagination = $this->request->getPost('pagination');
		$query      = $this->request->getPost('query');
		$sort       = $this->request->getPost('sort');
		$perpage    = ($pagination['perpage']) ?? 10;
		$page       = ($pagination['page']) ?? 1;
		$field      = ($sort['field']) ?? 'no';
		$sort       = ($sort['sort']) ?? 'asc';
		$offset     = $perpage * ($page - 1);

		$params = [
			'limit' => [
				'perpage' => $perpage,
				'page'    => $offset,
			],
			'order' => [
				[$field, $sort],
			],
		];

		$where = [
			['manage', '0', 'AND']
		];
		if (isset($query['multiple'])) {
			$fields = [
				'name'        => 'name',
				'description' => 'description',
				'active'      => 'active'
			];
			$filters = json_decode($query['multiple'], true);
			foreach ($filters as $key => $filter) {
				$where[] = [$fields[$key], $filter, 'AND'];
			}
		}
		$params['where'] = $where;

		if (isset($query['keyword'])) {
			$params['groupLike'] = [
				['name', $query['keyword'], 'AND'],
				['description', $query['keyword'], 'OR']
			];
		}

		$data  = $this->model->eksis($params);
		$total = $data['total'];

		foreach ($data['rows'] as $index => $row) {
			$data['rows'][$index]['no'] = encryptUrl($row['no']);
		}

		$pages = $total / $perpage;
		$this->data = [
			'meta' => [
				'page'    => $page,
				'pages'   => ceil($pages),
				'perpage' => $perpage,
				'total'   => $total,
				'sort'    => $sort,
				'field'   => $field
			],
			'data' => $data['rows'],
			'query' => $where
		];
		$this->render();
	}

	private function _getDetail($id)
	{
		$mUserDetail = new \IM\CI\Models\App\M_userDetail();
		return $mUserDetail->baris($id, ['select' => 'a.user_id id, fullname, address, phone, concentration, purpose, complete_reg, email, username, avatar']);
	}

	public function edit($id)
	{
		try {
			$id = decryptUrl($id);
			$data = $this->_getDetail($id);
		} catch (\Throwable $th) {
			$this->errorPage();
		}

		if (is_null($data)) {
			$this->im_message->add('danger', "Data tidak ditemukan");
			return redirect()->to('/support/' . $this->module);
		}

		$acc = new \IM\CI\Controllers\Account();

		helper(['form', 'text']);
		$i = 0;

		$formPersonal['forms'] = $acc->_formPersonal($data);
		$this->data['formPersonal'] = view('IM\CI\Views\vAFormBuilder', $formPersonal);

		$this->data['form_personal'] = ['class' => 'form', 'id' => 'kt_form_personal'];
		$this->data['btnSubmitPersonal'] = [
			'type'     => 'submit',
			'id'       => 'kt_form_personal_submit',
			'class'    => 'btn btn-primary font-weight-bolder',
			'content'  => '<i class="ki ki-check icon-sm"></i>Update Info</button>',
			'tabindex' => ++$i,
		];
		$this->data['btnResetPersonal'] = [
			'type'     => 'reset',
			'class'    => 'btn btn-dark font-weight-bolder',
			'content'  => '<i class="ki ki-round icon-sm"></i>Reset Form</button>',
			'tabindex' => ++$i,
		];

		$i = 0;

		$formAccount['forms'] = $acc->_formAccount($data);
		$this->data['formAccount'] = view('IM\CI\Views\vAFormBuilder', $formAccount);

		$this->data['ava'] = ($data['avatar'] == DEFAULT_AVATAR) ? $data['avatar'] : 'uploads/' . $data['username'] . '/' . $data['avatar'];
		$this->data['form_account'] = ['class' => 'form', 'id' => 'kt_form_account'];
		$this->data['btnSubmitAccount'] = [
			'type'     => 'submit',
			'id'       => 'kt_form_account_submit',
			'class'    => 'btn btn-primary font-weight-bolder',
			'content'  => '<i class="ki ki-check icon-sm"></i>Update Account</button>',
			'tabindex' => ++$i,
		];
		$this->data['btnResetAccount'] = [
			'type'     => 'reset',
			'class'    => 'btn btn-dark font-weight-bolder',
			'content'  => '<i class="ki ki-round icon-sm"></i>Reset Form</button>',
			'tabindex' => ++$i,
		];

		$i = 0;

		$formPassword['forms'] = $acc->_formPassword($data);
		$this->data['formPassword'] = view('IM\CI\Views\vAFormBuilder', $formPassword);

		$this->data['form_password'] = ['class' => 'form', 'id' => 'kt_form_password'];
		$this->data['btnSubmitPassword'] = [
			'type'     => 'submit',
			'id'       => 'kt_form_password_submit',
			'class'    => 'btn btn-primary font-weight-bolder',
			'content'  => '<i class="ki ki-check icon-sm"></i>Update Password</button>',
			'tabindex' => ++$i,
		];
		$this->data['btnResetPassword'] = [
			'type'     => 'reset',
			'class'    => 'btn btn-dark font-weight-bolder',
			'content'  => '<i class="ki ki-round icon-sm"></i>Reset Form</button>',
			'tabindex' => ++$i,
		];

		$this->data['pageTitle']  = 'Clients';
		$this->data['title']      = 'Edit Clients';
		$this->data['breadCrumb'] = ['Dashboard' => 'support', 'Clients' => $this->module, 'Edit' => 'edit'];

		$this->data['js'] = ['assets/js/account.min.js'];
		$this->render('support/clients-form');
	}

	public function detail($id)
	{
		if ($this->request->isAJAX()) {
			$id   = decryptUrl($id);
			$data = $this->_getDetail($id);

			$this->data = [
				'status'  => ($data) ? TRUE : FALSE,
				'message' => ($data) ? 'Data ditemukan' : 'Data tidak ditemukan',
				'data'    => ($data) ? encryptUrl($data['id']) : '',
				'detail'  => ($data) ? view('IM\CI\Views\vAModalDetail', ['data' => $data]) : ''
			];
			$this->render();
		}
	}

	public function delete($id)
	{
		if ($this->request->getMethod() == 'get' && $this->request->isAJAX()) {
			$id   = decryptUrl($id);
			$data = $this->_getDetail($id);

			$this->data = [
				'status'  => ($data) ? TRUE : FALSE,
				'message' => ($data) ? 'Data ditemukan' : 'Data tidak ditemukan',
				'data'    => ($data) ? encryptUrl($data['id']) : '',
				'detail'  => ($data) ? view('IM\CI\Views\vAModalDelete', ['data' => $data, 'softDelete' => method_exists($this, 'restore')]) : ''
			];
			$this->render();
		}
		if ($this->request->getMethod() == 'delete' && $this->request->isAJAX()) {
			$id   = decryptUrl($id);
			$data = $this->model->find($id);

			if ($data) {
				$mode = $this->request->getRawInput()['permanent'];

				if ($mode == 'true')
					$delete = $this->model->hapusPermanen($id);
				else
					$delete = $this->model->hapus($id);

				if ($delete)
					$this->im_logger->action('delete')->module($this->module)->moduleId($id)->note($data)->status('1')->log();
				else
					$this->im_logger->action('delete')->module($this->module)->moduleId($id)->status('0')->log();

				$this->ajaxResponse(($delete) ? TRUE : FALSE, ($delete) ? 'Data berhasil dihapus' : 'Data gagal dihapus', $data);
			}
			$this->ajaxResponse(FALSE, 'Data tidak ditemukan');
		}
	}

	public function restore($id)
	{
		if ($this->request->getMethod() == 'patch' && $this->request->isAJAX()) {
			$id   = decryptUrl($id);
			$data = $this->model->find($id);

			if ($data) {

				$restore = $this->model->pulih($id);

				if ($restore)
					$this->im_logger->action('restore')->module($this->module)->moduleId($id)->note($data)->status('1')->log();
				else
					$this->im_logger->action('restore')->module($this->module)->moduleId($id)->status('0')->log();

				$this->ajaxResponse(($restore) ? TRUE : FALSE, ($restore) ? 'Data berhasil dipulihkan' : 'Data gagal dipulihkan', $data);
			}
			$this->ajaxResponse(FALSE, 'Data tidak ditemukan');
		}
	}

	public function tests()
	{
		helper(['form']);
		$forms['name'] = [
			'type'  => 'input',
			'label' => 'Name',
			'name'  => 'name',
			'field' => [
				'class' => 'form-control filter-input',
				'name'  => 'name',
			]
		];
		$forms['description'] = [
			'type'  => 'input',
			'label' => 'Description',
			'name'  => 'description',
			'field' => [
				'class' => 'form-control filter-input',
				'name'  => 'description',
			]
		];
		$forms['active'] = [
			'type'  => 'dropdown',
			'label' => 'Status',
			'name'  => 'active',
			'field' => [
				'class'   => 'form-control filter-input',
				'name'    => 'active',
				'options' => [
					''  => 'All',
					'0' => 'Tidak Aktif',
					'1' => 'Aktif'
				],
			]
		];

		$this->data['forms'] = $forms;
		$this->data['js']    = [
			'assets/js/users/test.min.js'
		];
		$this->data['pageTitle']  = 'Tests';
		$this->data['title']      = 'Data Tests';
		$this->data['subTitle']   = '';
		$this->data['breadCrumb'] = ['Dashboard' => 'support', 'Clients' => 'clients', 'Tests' => ''];
		$this->data['module']     = $this->module;
		$this->data['table']      = 'table_clients-tests';

		$this->data['button']['add'] = '<button type="button" id="add-button" class="btn btn-icon btn-light-success font-weight-bolder mr-2" data-toggle="tooltip" title="" data-original-title="Tambah Test" data-theme="dark">
		<i class="ki ki-solid-plus"></i>
	</button>';
		$this->render('\IM\CI\Views\vAList');
	}

	public function listtests($userID)
	{
		$this->isAjaxReq('post');

		$userID     = decryptUrl($userID);
		$pagination = $this->request->getPost('pagination');
		$query      = $this->request->getPost('query');
		$sort       = $this->request->getPost('sort');
		$perpage    = ($pagination['perpage']) ?? 10;
		$page       = ($pagination['page']) ?? 1;
		$field      = ($sort['field']) ?? 'no';
		$sort       = ($sort['sort']) ?? 'asc';
		$offset     = $perpage * ($page - 1);

		$params = [
			'limit' => [
				'perpage' => $perpage,
				'page'    => $offset,
			],
			'order' => [
				[$field, $sort],
			],
		];

		$where = [
			['a.user_id', $userID, 'AND']
		];

		$params['where'] = $where;
		
		if (isset($query['multiple'])) {
			$fields = [
				'name'        => 'name',
				'description' => 'description',
				'active'      => 'active'
			];
			$filters = json_decode($query['multiple'], true);
			foreach ($filters as $key => $filter) {
				$where[] = [$fields[$key], $filter, 'AND'];
			}
		}

		if (isset($query['keyword'])) {
			$params['groupLike'] = [
				['name', $query['keyword'], 'AND'],
				['description', $query['keyword'], 'OR']
			];
		}

		$mUsersTests = new \App\Models\M_users_tests();

		$data  = $mUsersTests->eksis($params);
		$total = $data['total'];

		foreach ($data['rows'] as $index => $row) {
			$data['rows'][$index]['no'] = encryptUrl($row['no']);
		}

		$pages = $total / $perpage;
		$this->data = [
			'meta' => [
				'page'    => $page,
				'pages'   => ceil($pages),
				'perpage' => $perpage,
				'total'   => $total,
				'sort'    => $sort,
				'field'   => $field
			],
			'data' => $data['rows']
		];
		$this->render();
	}

	// ! SALAH KUDUNE ORA NAME BOTH
	public function gettestnot($id)
	{
		if (isAjax('get')) {
			if ($this->request->getGet('type') == 'select') {
				$this->data = [
					'status' => TRUE,
					'data'   => '<select class="form-control" id="select-tests" name="tests" multiple="true"></select>'
				];
				$this->render();
			}
			if ($this->request->getGet('type') == 'options') {
				try {
					$id      = decryptUrl($id);
					$keyword = $this->request->getGet('q');
					$mTests  = new \App\Models\M_tests();
					$params  = [
						'select' => 'a.id, a.name, IFNULL(b.user_id, 0) AS user_id',
						'join'   => [
							['users_tests b', 'b.test_id = a.id', 'LEFT']
						],
						'like' => [
							['a.name', $keyword, 'both']
						],
						'group' => ['a.id']
					];
					$tests = $mTests->efektif($params)['rows'];

					$this->data = [];
					if (count($tests) > 0) {
						foreach ($tests as $test) {
							if ($test['user_id'] == $id)
								continue;
							$this->data[] = [
								'id'   => $test['id'],
								'text' => $test['name']
							];
						}
					}
				} catch (\Exception $e) {
					$this->data = [['id' => '', 'text' => 'Terjadi kesalahan:' . $e->getMessage()]];
				}
				$this->render();
			}
		}
	}

	public function settests($id)
	{
		try {
			$id          = decryptUrl($id);
			$tests       = $this->request->getPost('tests');
			$mUsersTests = new \App\Models\M_users_tests();

			foreach ($tests as $test) {
				$mUsersTests->tambah([
					'class_id' => 0,
					'user_id'  => $id,
					'test_id'  => $test,
					'active'   => '1'
				]);
			}
			$this->ajaxResponse(TRUE, count($tests) . ' Data berhasil ditambahkan', $tests);
		} catch (\Exception $e) {
			$this->ajaxResponse(FALSE, $e->getMessage());
		}
	}

	public function deletetest($id)
	{
		try {
			$id          = decryptUrl($id);
			$mUsersTests = new \App\Models\M_users_tests();
			$mUsersTests->delete($id);
			$this->ajaxResponse(TRUE, 'Data berhasil dihapus');
		} catch (\Exception $e) {
			$this->ajaxResponse(FALSE, $e->getMessage());
		}
	}
}
