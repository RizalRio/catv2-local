<?php

namespace App\Controllers\Support;

use \IM\CI\Controllers\AdminController;

class Orders extends AdminController
{
	protected $module = 'orders';

	public function __construct()
	{
		if (!in_groups(['IM', 'SA']) && !has_permission($this->module))
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		$this->model = new \App\Models\M_orders();
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
			'assets/js/' . $this->module . '/data.min.js'
		];
		$this->data['pageTitle']        = 'Orders';
		$this->data['title']            = 'Data Orders';
		$this->data['subTitle']         = '';
		$this->data['breadCrumb']       = ['Dashboard' => 'support', 'Orders' => ''];
		$this->data['module']           = $this->module;
		$this->data['button']['export'] = false;
		$this->data['button']['create'] = false;
		$this->data['table']            = 'table_' . $this->module;
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

		if (isset($query['multiple'])) {
			$where = [];
			$fields = [
				'client'      => 'fullname',
				'description' => 'description',
				'active'      => 'active'
			];
			$filters = json_decode($query['multiple'], true);
			foreach ($filters as $key => $filter) {
				$where[] = [$fields[$key], $filter, 'AND'];
			}
			$params['where'] = $where;
		}

		if (isset($query['keyword'])) {
			$params['groupLike'] = [
				['a.invoice', $query['keyword'], 'OR'],
				['b.fullname', $query['keyword'], 'OR']
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
			'data' => $data['rows']
		];
		$this->render();
	}

	private function _form($params = [], $validation = null)
	{
		helper(['form', 'text']);
		$i = 0;
		$forms = [];
		$forms['id'] = [
			'type' => 'hidden',
			'name' => 'id',
			'field' => [
				'id' => (isset($params['id'])) ? encryptUrl($params['id']) : ''
			]
		];
		$forms['invoice'] = [
			'type'     => 'input',
			'required' => 'required',
			'label'    => 'Nomor Invoice',
			'name'     => 'invoice',
			'field'    => [
				'class'       => (isset($validation)) ? ($validation->hasError('invoice') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'        => 'invoice',
				'id'          => 'invoice',
				'value'       => set_value('invoice', (isset($params['invoice'])) ? $params['invoice'] : ''),
				'maxlength'   => '12',
				'tabindex'    => ++$i,
				'readonly'    => true
			]
		];
		$forms['fullname'] = [
			'type'     => 'div',
			'label'    => 'Client',
			'name'     => 'fullname',
			'field'    => (isset($params['fullname'])) ? '<a href="#" data-action="detail" data-nya="clients/detail/' . encryptUrl($params['user_id']) . '">' . $params['fullname'] . '</a>' : ''
		];
		$forms['concentration'] = [
			'type'     => 'dropdown',
			'required' => 'required',
			'label'    => 'Tujuan Tes',
			'name'     => 'concentration',
			'field'    => [
				'class'   => 'form-control filter-input',
				'name'    => 'concentration',
				'options' => [
					''           => 'Pilih Tujuan',
					'pekerjaan'  => 'Pekerjaan',
					'pendidikan' => 'Pendidikan',
					'bisnis'     => 'Bisnis'
				],
				'selected' => set_value('concentration', (isset($params['concentration'])) ? $params['concentration'] : '')
			]
		];
		$forms['purpose'] = [
			'type'     => 'textarea',
			'required' => 'required',
			'label'    => 'Detail Tujuan Tes',
			'name'     => 'purpose',
			'field'    => [
				'class'       => (isset($validation)) ? ($validation->hasError('purpose') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'        => 'purpose',
				'id'          => 'purpose',
				'placeholder' => 'Ex. Mengetahui kemampuan dasar',
				'value'       => set_value('purpose', (isset($params['purpose'])) ? $params['purpose'] : ''),
				'tabindex'    => ++$i,
				'rows'        => '2'
			]
		];
		$forms['bill'] = [
			'type'     => 'input',
			'required' => 'required',
			'label'    => 'Biaya',
			'name'     => 'bill',
			'field'    => [
				'class'       => (isset($validation)) ? ($validation->hasError('bill') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'        => 'bill',
				'id'          => 'bill',
				'value'       => set_value('bill', (isset($params['bill'])) ? $params['bill'] : ''),
				'maxlength'   => '12',
				'tabindex'    => ++$i,
			]
		];
		$forms['order'] = [
			'type'  => 'switch',
			'label' => 'Confirm Order',
			'name'  => 'order',
			'style' => 'primary',
			'fields' => [[
				'name'     => 'order',
				'id'       => 'order',
				'value'    => '1',
				'tabindex' => ++$i,
			]]
		];
		if (isset($params['confirm_order'])) {
			$forms['order'] = [
				'type'     => 'div',
				'label'    => 'Confirm Order',
				'name'     => 'file',
				'field'    => $params['confirm_order']
			];
		}
		$forms['file'] = [
			'type'     => 'div',
			'label'    => 'Bukti Transfer',
			'name'     => 'file',
			'field'    => (isset($params['file'])) ? '<a href="#" data-action="detail" data-nya="payments/file/' . $params['username'] . '/' . $params['file'] . '">' . $params['file'] . '</a>' : ''
		];
		$forms['payment'] = [
			'type'  => 'switch',
			'label' => 'Confirm Payment',
			'name'  => 'payment',
			'style' => 'primary',
			'fields' => [[
				'name'     => 'payment',
				'id'       => 'payment',
				'value'    => '1',
				'tabindex' => ++$i,
			]]
		];
		if (isset($params['confirm_payment'])) {
			$forms['payment'] = [
				'type'     => 'div',
				'label'    => 'Confirm Payment',
				'name'     => 'file',
				'field'    => $params['confirm_payment']
			];
		}


		$this->data['form_open'] = ['class' => 'form', 'id' => 'kt_form'];
		$this->data['btnSubmit'] = [
			'type'     => 'submit',
			'class'    => 'btn btn-primary font-weight-bolder',
			'content'  => '<img class="ki ki-check icon-sm"></img>Save Form</button>',
			'tabindex' => ++$i,
		];
		$this->data['btnReset'] = [
			'type'     => 'reset',
			'class'    => 'btn btn-dark font-weight-bolder',
			'content'  => '<i class="ki ki-round icon-sm"></i>Reset Form</button>',
			'tabindex' => ++$i,
		];
		return $forms;
	}

	public function create()
	{
		if ($this->validate([
			'name'        => 'required',
			'description' => 'required',
		])) {
			$data = $this->request->getPost();
			if ($this->request->getMethod() == 'post' && $newID = $this->model->tambah($data)) {
				$this->im_message->add('success', "Data berhasil disimpan");
				$this->im_logger->action('create')->module($this->module)->moduleId($newID)->status('1')->log();
				return redirect()->to('/support/' . $this->module);
			} else {
				$this->im_logger->action('create')->module($this->module)->moduleId($newID)->status('0')->log();
				$this->im_message->add('danger', "Terjadi kesalahan saat menyimpan data");
			}
		} else {
			if ($this->request->getMethod() == 'post')
				$validation = \Config\Services::validation();
			else
				$validation = null;
		}

		$this->data['pageTitle']  = 'Methods';
		$this->data['title']      = 'Create Methods';
		$this->data['breadCrumb'] = ['Dashboard' => 'support', 'Methods' => $this->module, 'Create' => 'create'];

		$this->data['forms'] = $this->_form([], $validation);
		$this->data['js']    = ['assets/js/' . $this->module . '/form.min.js'];
		$this->render('IM\CI\Views\vAForm');
	}

	private function _getDetail($id)
	{
		return $this->model->baris($id, ['select' => ['a.id', 'a.user_id', 'fullname', 'username', 'a.invoice', 'a.concentration', 'a.purpose', 'bill', 'a.confirm_date confirm_order', 'a.active order', 'IF(ISNULL(c.id), 0, c.id) payment_id', 'IF(ISNULL(c.confirm_date), null, c.confirm_date) confirm_payment', 'IF(ISNULL(c.active), 0, c.active) payment', 'IF(ISNULL(c.file), null, c.file) file'], 'join' => [['users d', 'd.id = a.user_id', 'left']]]);
	}

	public function edit($id)
	{
		$id   = decryptUrl($id);
		$data = $this->_getDetail($id);

		if (is_null($data)) {
			$this->im_message->add('danger', "Data tidak ditemukan");
			return redirect()->to('/support/' . $this->module);
		}

		if ($this->validate([
			'invoice'       => 'required',
			'concentration' => 'required',
			'purpose'       => 'required',
			'bill'          => 'required',
		])) {

			$fields = [
				'id'            => 'id',
				'invoice'       => 'invoice',
				'concentration' => 'concentration',
				'purpose'       => 'purpose',
				'bill'          => 'bill'
			];

			if ($this->request->getPost('order'))
				$fields['order'] = 'order';

			if ($this->request->getPost('payment'))
				$fields['payment'] = 'payment';

			if ($this->checkEdit($fields, $data) === FALSE) {
				$this->im_message->add('info', "ID tidak sesuai");
				return redirect()->to('/support/' . $this->module);
			}

			if ($this->before) {
				if ($this->request->getPost('order')) {
					$this->newData['confirm_date'] = date('Y-m-d H:i:s');
					$this->newData['active'] = $this->request->getPost('order');
				}

				if (isset($data['confirm_order']) && $this->request->getPost('payment') && isset($data['file'])) {
					$mPayment = new \App\Models\M_payments();
					$this->newData['confirm_date'] = date('Y-m-d H:i:s');
					$this->newData['active'] = 1;
					if ($this->request->getMethod() == 'post' && $mPayment->ubah($data['payment_id'], $this->newData)) {
						$this->im_message->add('success', "Data berhasil diperbarui");
						$this->im_logger->action('update')->module('payment')->moduleId($id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('1')->log();
						return redirect()->to('/support/' . $this->module);
					} else {
						$this->im_logger->action('update')->module('payment')->moduleId($id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('0')->log();
						$this->im_message->add('danger', "Terjadi kesalahan saat menyimpan data");
					}
				} else {
					if ($this->request->getMethod() == 'post' && $this->model->ubah($id, $this->newData)) {
						$this->im_message->add('success', "Data berhasil diperbarui");
						$this->im_logger->action('update')->module($this->module)->moduleId($id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('1')->log();
						return redirect()->to('/support/' . $this->module);
					} else {
						$this->im_logger->action('update')->module($this->module)->moduleId($id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('0')->log();
						$this->im_message->add('danger', "Terjadi kesalahan saat menyimpan data");
					}
				}
			} else {
				$this->im_message->add('info', "Tidak ada perubahan data");
				return redirect()->to('/support/' . $this->module);
			}
		} else {
			if ($this->request->getMethod() == 'post')
				$validation = \Config\Services::validation();
			else
				$validation = null;
		}

		$this->data['pageTitle']  = 'Methods';
		$this->data['title']      = 'Edit Methods';
		$this->data['breadCrumb'] = ['Dashboard' => 'support', 'Methods' => $this->module, 'Edit' => 'edit'];

		$this->data['forms'] = $this->_form($data, $validation);
		$this->data['js']    = ['assets/js/' . $this->module . '/form.min.js'];
		$this->render('IM\CI\Views\vAForm');
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
}