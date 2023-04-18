<?php

namespace App\Controllers\Support;

use \IM\CI\Controllers\AdminController;

class Dimensions extends AdminController
{
	protected $module = 'dimensions';

	public function __construct()
	{
		if (!in_groups(['IM', 'SA']) && !has_permission($this->module))
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		$this->model  = new \App\Models\M_dimensions();
	}

	public function index()
	{
		helper(['form']);

		$mMethods = new \App\Models\M_methods();
		$methods = $mMethods->efektif()['rows'];
		$optMethods = ['' => 'Select Method'];
		foreach ($methods as $key => $value) {
			$optMethods[$value['id']] = $value['name'];
		}

		$forms['method'] = [
			'type'     => 'dropdown',
			'required' => 'required',
			'label'    => 'Method',
			'name'     => 'method',
			'field'    => [
				'class'     => 'form-control filter-input',
				'name'      => 'method',
				'autofocus' => 'true',
				'options'   => $optMethods
			]
		];

		$forms['name'] = [
			'type'     => 'input',
			'label'    => 'Name',
			'name'     => 'name',
			'field'    => [
				'class' => 'form-control filter-input',
				'name'  => 'name',
			]
		];
		$forms['description'] = [
			'type'     => 'input',
			'label'    => 'Description',
			'name'     => 'description',
			'field'    => [
				'class' => 'form-control filter-input',
				'name'  => 'description',
			]
		];
		$forms['active'] = [
			'type'     => 'dropdown',
			'label'    => 'Status',
			'name'     => 'active',
			'field'    => [
				'class'   => 'form-control filter-input',
				'name'    => 'active',
				'options' => [
					''  => 'All',
					'0' => 'Tidak Aktif',
					'1' => 'Aktif'
				],
			]
		];

		$this->data['forms']      = $forms;
		$this->data['js']         = [
			'assets/js/' . $this->module . '/data.min.js'
		];
		$this->data['pageTitle']  = 'Dimensions';
		$this->data['title']      = 'Data Dimensions';
		$this->data['subTitle']   = 'Metode tes yang digunakan';
		$this->data['breadCrumb'] = ['Dashboard' => 'support', 'Dimensions' => ''];
		$this->data['module']     = $this->module;
		$this->data['table']      = 'table_' . $this->module;
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
			['b.deleted', '0', 'AND']
		];
		if (isset($query['multiple'])) {
			$fields = [
				'method'      => 'method_id',
				'name'        => 'a.name',
				'description' => 'a.description',
				'active'      => 'a.active'
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

		$mMethods = new \App\Models\M_methods();
		$methods = $mMethods->efektif()['rows'];
		$optMethods = ['' => 'Select Method'];
		foreach ($methods as $key => $value) {
			$optMethods[$value['id']] = $value['name'];
		}

		$forms['method'] = [
			'type'     => 'dropdown',
			'required' => 'required',
			'label'    => 'Method',
			'name'     => 'method',
			'field'    => [
				'class'     => 'form-control',
				'name'      => 'method',
				'tabindex'  => ++$i,
				'autofocus' => 'true',
				'options'   => $optMethods,
				'selected'  => set_value('method_id', ($params['method_id']) ?? ''),
			]
		];
		$forms['name'] = [
			'type'     => 'input',
			'required' => 'required',
			'label'    => 'Name',
			'name'     => 'name',
			'field'    => [
				'class'       => (isset($validation)) ? ($validation->hasError('name') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'        => 'name',
				'id'          => 'name',
				'placeholder' => 'Ex. Method 1',
				'value'       => set_value('name', ($params['name']) ?? ''),
				'maxlength'   => '100',
				'tabindex'    => ++$i,
			]
		];
		$forms['description'] = [
			'type'     => 'textarea',
			'required' => 'required',
			'label'    => 'Description',
			'name'     => 'description',
			'field'    => [
				'class'       => (isset($validation)) ? ($validation->hasError('description') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'        => 'description',
				'id'          => 'description',
				'placeholder' => 'Ex. Description Method 1',
				'value'       => set_value('description', ($params['description']) ?? ''),
				'tabindex'    => ++$i,
				'rows'        => '2'
			]
		];
		$forms['active'] = [
			'type'  => 'switch',
			'label' => 'Active',
			'name'  => 'active',
			'style' => 'primary',
			'fields' => [[
				'name'     => 'active',
				'id'       => 'active',
				'value'    => '1',
				'tabindex' => ++$i,
			]]
		];

		if ((isset($params['active']) && $params['active'] == 1) || empty($params))
			$forms['active']['fields'][0]['checked'] = 'checked';

		$this->data['form_open'] = ['class' => 'form', 'id' => 'kt_form'];
		$this->data['btnSubmit'] = [
			'type'     => 'submit',
			'class'    => 'btn btn-primary font-weight-bolder',
			'content'  => '<i class="ki ki-check icon-sm"></i>Save Form</button>',
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
			'method'      => 'required',
			'name'        => 'required',
			'description' => 'required',
		])) {

			$fields = [
				'method'      => 'method_id',
				'name'        => 'name',
				'description' => 'description',
				'active'      => 'active'
			];
			$postData = $this->request->getPost();
			if (!array_key_exists('active', $postData))
				$postData['active'] = '0';
			foreach ($fields as $key => $value) {
				$newData[$value] = $postData[$key];
			}

			if ($this->request->getMethod() == 'post' && $newID = $this->model->tambah($newData)) {
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

		$this->data['pageTitle']  = 'Dimensions';
		$this->data['title']      = 'Create Dimensions';
		$this->data['breadCrumb'] = ['Dashboard' => 'support', 'Dimensions' => $this->module, 'Create' => 'create'];

		$this->data['forms'] = $this->_form([], $validation);
		$this->data['js']    = ['assets/js/' . $this->module . '/form.min.js'];
		$this->render('IM\CI\Views\vAForm');
	}

	private function _getDetail($id)
	{
		return $this->model->baris($id, ['select' => 'method_id, a.id, a.name, a.description, a.active']);
	}

	public function edit($id)
	{
		$id = decryptUrl($id);
		$data = $this->_getDetail($id);

		if (is_null($data)) {
			$this->im_message->add('danger', "Data tidak ditemukan");
			return redirect()->to('/support/' . $this->module);
		}

		if ($this->validate([
			'method'      => 'required',
			'name'        => 'required',
			'description' => 'required',
		])) {
			$before = $after = [];
			$fields = [
				'id'          => 'id',
				'method'      => 'method_id',
				'name'        => 'name',
				'description' => 'description',
				'active'      => 'active'
			];
			$postData = $this->request->getPost();
			if (!array_key_exists('active', $postData))
				$postData['active'] = '0';
			foreach ($fields as $key => $value) {
				if ($key == 'id')
					$postData[$key] = decryptUrl($postData[$key]);
				if ($postData[$key] != $data[$value]) {
					if ($key == 'id') {
						$this->im_message->add('info', "ID tidak sesuai");
						return redirect()->to('/support/' . $this->module);
					} else {
						$newData[$value] = $postData[$key];
						$before[$value] = $data[$value];
						$after[$value] = $postData[$key];
					}
				}
			}
			if ($before) {
				if ($this->request->getMethod() == 'post' && $this->model->ubah($id, $newData)) {
					$this->im_message->add('success', "Data berhasil diperbarui");
					$this->im_logger->action('update')->module($this->module)->moduleId($id)->note(json_encode(['b' => $before, 'a' => $after]))->status('1')->log();
					return redirect()->to('/support/' . $this->module);
				} else {
					$this->im_logger->action('update')->module($this->module)->moduleId($id)->note(json_encode(['b' => $before, 'a' => $after]))->status('0')->log();
					$this->im_message->add('danger', "Terjadi kesalahan saat menyimpan data");
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

		$this->data['pageTitle']  = 'Dimensions';
		$this->data['title']      = 'Edit Dimensions';
		$this->data['breadCrumb'] = ['Dashboard' => 'support', 'Dimensions' => $this->module, 'Edit' => 'edit'];

		$this->data['forms'] = $this->_form($data, $validation);
		$this->data['js']    = ['assets/js/' . $this->module . '/form.min.js'];
		$this->render('IM\CI\Views\vAForm');
	}

	public function detail($id)
	{
		$id   = decryptUrl($id);
		$data = $this->_getDetail($id);

		$this->data = [
			'status'  => ($data) ? TRUE : FALSE,
			'message' => ($data) ? 'Data ditemukan' : 'Data tidak ditemukan',
			'data'    => ($data) ? encryptUrl($data['id']) : '',
			'detail'  => ($data) ? view('IM\CI\Views\vAModalDetail', ['data' => $data]) : ''
		];
		if ($this->request->isAJAX()) {
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

				$this->data = [
					'status'  => ($delete) ? TRUE : FALSE,
					'message' => ($delete) ? 'Data berhasil dihapus' : 'Data gagal dihapus',
					'data'    => $data
				];
			} else {
				$this->data = [
					'status'  => FALSE,
					'message' => 'Data tidak ditemukan',
					'data'    => NULL
				];
			}
			$this->render();
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

				$this->data = [
					'status'  => ($restore) ? TRUE : FALSE,
					'message' => ($restore) ? 'Data berhasil dipulihkan' : 'Data gagal dipulihkan',
					'data'    => $data
				];
			} else {
				$this->data = [
					'status'  => FALSE,
					'message' => 'Data tidak ditemukan',
					'data'    => NULL
				];
			}
			$this->render();
		}
	}

	public function options()
	{
		if ($this->request->isAJAX()) {
			$dimensions = $this->model->efektif(['where' => [['method_id', $this->request->getPost('method'), 'AND']]])['rows'];
			$data = "<option value=''>Select Dimension</option>";
			foreach ($dimensions as $key => $value) {
				$data .= "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
			}
			$this->data = [
				'status' => TRUE,
				'data'   => $data
			];
			$this->render();
		}
	}
}
