<?php

namespace App\Controllers\Support;

use \IM\CI\Controllers\AdminController;

class Questions extends AdminController
{
	protected $module = 'questions';

	public function __construct()
	{
		if (!in_groups(['IM', 'SA']) && !has_permission($this->module))
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		$this->model  = new \App\Models\M_questions();
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
				'class'   => 'form-control filter-input',
				'name'    => 'method',
				'id'      => 'method',
				'options' => $optMethods
			]
		];

		$forms['question'] = [
			'type'     => 'textarea',
			'label'    => 'Question',
			'name'     => 'question',
			'field'    => [
				'class' => 'form-control filter-input',
				'name'  => 'question',
				'rows'  => '3'
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
		$this->data['pageTitle']               = 'Questions Bank';
		$this->data['title']                   = 'Data Questions';
		$this->data['subTitle']                = '';
		$this->data['breadCrumb']              = ['Dashboard' => 'support', 'Questions' => ''];
		$this->data['module']                  = $this->module;
		$this->data['button']['add']['import'] = true;
		$this->data['table']                   = 'table_' . $this->module;
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
				'method'    => 'method_id',
				'question'  => 'question',
				'active'    => 'active'
			];
			$filters = json_decode($query['multiple'], true);
			foreach ($filters as $key => $filter) {
				$where[] = [$fields[$key], $filter, 'AND'];
			}
			$params['where'] = $where;
		}

		if (isset($query['keyword'])) {
			$params['groupLike'] = [
				['b.name', $query['keyword'], 'AND'],
				['question', $query['keyword'], 'OR']
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
				'class'       => (isset($validation)) ? ($validation->hasError('method') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'      => 'method',
				'id'        => 'method',
				'tabindex'  => ++$i,
				'autofocus' => 'true',
				'options'   => $optMethods,
				'selected' => set_value('method', ($params['method']) ?? ''),
			]
		];

		$forms['question'] = [
			'type'     => 'textarea',
			'required' => 'required',
			'label'    => 'Question',
			'name'     => 'question',
			'field'    => [
				'class'       => (isset($validation)) ? ($validation->hasError('question') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'        => 'question',
				'id'          => 'question',
				'placeholder' => 'Ex. Question 1',
				'value'       => set_value('question', ($params['question']) ?? ''),
				'tabindex'    => ++$i,
				'rows'        => '3'
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

		$mDimensions = new \App\Models\M_dimensions();
		$optDimensions = ['' => 'Select Method First'];
		$m = set_value('method', ($params['method']) ?? '');
		if ($m != '') {
			$dimensions = $mDimensions->efektif(['where' => [['method_id', $m, 'AND']]])['rows'];
			$optDimensions = ['' => 'Select Dimension'];
			foreach ($dimensions as $key => $value) {
				$optDimensions[$value['id']] = $value['name'];
			}
		}

		return $forms;
	}

	public function create()
	{
		if ($this->validate([
			'method'                => 'required',
			'question'              => 'required',
			'opsijawab.0.dimension' => 'required'
		])) {

			$fields = [
				'method'   => 'method_id',
				'question' => 'question',
				'active'   => 'active'
			];

			$postData = $this->request->getPost();
			if (!array_key_exists('active', $postData))
				$postData['active'] = '0';

			foreach ($fields as $key => $value) {
				$newData[$value] = $postData[$key];
			}

			if ($this->request->getMethod() == 'post' && $newID = $this->model->tambah($newData)) {
				$this->im_message->add('success', "Data soal berhasil disimpan");
				$this->im_logger->action('create')->module($this->module)->moduleId($newID)->status('1')->log();

				$mAnswers = new \App\Models\M_answers();
				foreach ($postData['opsijawab'] as $opsijawab) {
					$answer = [
						'question_id'  => $newID,
						'dimension_id' => $opsijawab['dimension'],
						'answer'       => $opsijawab['answer'],
						'feedback'     => $opsijawab['feedback'],
						'point'		   => $opsijawab['point']
					];
					if ($answerID = $mAnswers->tambah($answer))
						$this->im_logger->action('create')->module('answers')->moduleId($answerID)->status('1')->log();
					else {
						$this->im_logger->action('create')->module('answers')->moduleId($answerID)->status('0')->log();
						$this->im_message->add('danger', "Opsi '" . $opsijawab['answer'] . "' gagal disimpan");
					}
				}

				return redirect()->to('/support/' . $this->module);
			} else {
				$this->im_logger->action('create')->module($this->module)->moduleId($newID)->status('0')->log();
				$this->im_message->add('danger', "Terjadi kesalahan saat menyimpan data soal");
			}
		} else {
			if ($this->request->getMethod() == 'post')
				$validation = \Config\Services::validation();
			else
				$validation = null;
		}

		$opsijawab = [];

		if ($this->request->getPost('opsijawab')) {
			foreach ($this->request->getPost('opsijawab') as $key => $value) {
				$opsijawab[] = [
					'id'        => $value['id'],
					'dimension' => $value['dimension'],
					'answer'    => $value['answer'],
					'feedback'  => $value['feedback'],
					'point'		=> $value['point']
				];
			}
		} else {
			$opsijawab = [
				[
					'id'        => '',
					'dimension' => '',
					'answer'    => '',
					'feedback'  => '',
					'point'		=> ''
				]
			];
		}

		$mDimensions = new \App\Models\M_dimensions();
		$optDimensions = ['' => 'Select Method First'];
		$m = $this->request->getPost('method');
		if ($m) {
			$dimensions = $mDimensions->efektif(['where' => [['method_id', $m, 'AND']]])['rows'];
			$optDimensions = ['' => 'Select Dimension'];
			foreach ($dimensions as $key => $value) {
				$optDimensions[$value['id']] = $value['name'];
			}
		}

		$this->data['pageTitle']  = 'Questions Bank';
		$this->data['title']      = 'Create Question';
		$this->data['breadCrumb'] = ['Dashboard' => 'support', 'Questions' => $this->module, 'Create' => 'create'];


		$this->data['forms']         = $this->_form([], $validation);
		$this->data['opsijawabs']    = $opsijawab;
		$this->data['optDimensions'] = $optDimensions;
		$this->data['js']            = ['assets/js/' . $this->module . '/form.min.js'];
		$this->render('support/questions-form');
	}

	private function _getDetail($id)
	{
		return $this->model->baris($id, ['select' => 'a.id, method_id method, question, a.active']);
	}

	public function edit($id)
	{
		$id = decryptUrl($id);
		$data = $this->_getDetail($id);

		$mAnswers = new \App\Models\M_answers();
		$answers  = $mAnswers->efektif(['where' => [['question_id', $data['id'], 'AND']]])['rows'];

		if (is_null($data)) {
			$this->im_message->add('danger', "Data tidak ditemukan");
			return redirect()->to('/support/' . $this->module);
		}

		$validation = null;

		if ($this->validate([
			'method'                => 'required',
			'question'              => 'required',
			'opsijawab.0.dimension' => 'required'
		])) {

			$fields = [
				'id'       => 'id',
				'method'   => 'method',
				'question' => 'question',
				'active'   => 'active'
			];

			if ($this->checkEdit($fields, $data) === FALSE) {
				$this->im_message->add('info', "ID tidak sesuai");
				return redirect()->to('/support/' . $this->module);
			}

			$isNotChanged = true;

			if ($this->before) {
				if ($this->request->getMethod() == 'post' && $this->model->ubah($id, $this->newData)) {
					$this->im_message->add('success', "Data question berhasil diperbarui");
					$this->im_logger->action('update')->module($this->module)->moduleId($id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('1')->log();
					$isNotChanged = false;
				} else {
					$this->im_logger->action('update')->module($this->module)->moduleId($id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('0')->log();
					$this->im_message->add('danger', "Terjadi kesalahan saat menyimpan data question");
				}
			}

			$totalAnswers = count($answers) - 1;
			$opsiAnswers = $this->request->getPost('opsijawab');

			foreach ($opsiAnswers as $index => $value) {
				$this->newData = $this->before = $this->after = [];

				if ($index <= $totalAnswers) {
					// edit
					$fields = [
						'id'        => 'id',
						'dimension' => 'dimension_id',
						'answer'    => 'answer',
						'feedback'  => 'feedback',
						'point'		=> 'point'
					];

					if (!array_key_exists('active', $value))
						$value['active'] = '0';

					foreach ($fields as $key => $field) {
						if ($value[$key] != $answers[$index][$field]) {
							if ($key == 'id') {
								$this->im_message->add('info', "Opsi '" . $field['answer'] . "' tidak sesuai");
							} else {
								$this->newData = [$field => $value[$key]];
								$this->before  = [$field => $answers[$index][$field]];
								$this->after   = [$field => $value[$key]];
							}
						}
					}

					if ($this->before) {
						if ($this->request->getMethod() == 'post' && $mAnswers->ubah($value['id'], $this->newData)) {
							$this->im_message->add('success', "Data answers berhasil diperbarui");
							$this->im_logger->action('update')->module($this->module)->moduleId($id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('1')->log();
							$isNotChanged = false;
						} else {
							$this->im_logger->action('update')->module($this->module)->moduleId($id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('0')->log();
							$this->im_message->add('danger', "Terjadi kesalahan saat menyimpan data answers");
						}
					}
				} else {
					// baru
					$answer = [
						'question_id'  => $id,
						'dimension_id' => $value['dimension'],
						'answer'       => $value['answer'],
						'feedback'     => $value['feedback'],
					];
					if ($answerID = $mAnswers->tambah($answer))
						$this->im_logger->action('create')->module('answers')->moduleId($answerID)->status('1')->log();
					else {
						$this->im_logger->action('create')->module('answers')->moduleId($answerID)->status('0')->log();
						$this->im_message->add('danger', "Opsi '" . $value['answer'] . "' gagal disimpan");
					}
				}
			}

			if ($isNotChanged == true)
				$this->im_message->add('info', "Tidak ada perubahan data");

			return redirect()->to('/support/' . $this->module);
		}

		if ($this->request->getMethod() == 'post')
			$validation = \Config\Services::validation();

		$opsijawab = [];

		if ($this->request->getPost('opsijawab')) {
			foreach ($this->request->getPost('opsijawab') as $key => $value) {
				$opsijawab[] = [
					'id'        => $value['id'],
					'dimension' => $value['dimension'],
					'answer'    => $value['answer'],
					'feedback'  => $value['feedback'],
					'point'		=> $value['point']
				];
			}
		} else {
			foreach ($answers as $answer) {
				$opsijawab[] =
					[
						'id'        => $answer['id'],
						'dimension' => $answer['dimension_id'],
						'answer'    => $answer['answer'],
						'feedback'  => $answer['feedback'],
						'point'		=> $answer['point']
					];
			}
		}

		$mDimensions = new \App\Models\M_dimensions();
		$optDimensions = ['' => 'Select Method First'];
		$m = $data['method'];
		if ($m) {
			$dimensions = $mDimensions->efektif(['where' => [['method_id', $m, 'AND']]])['rows'];
			$optDimensions = ['' => 'Select Dimension'];
			foreach ($dimensions as $key => $value) {
				$optDimensions[$value['id']] = $value['name'];
			}
		}

		$this->data['pageTitle']  = 'Questions Bank';
		$this->data['title']      = 'Edit Question';
		$this->data['breadCrumb'] = ['Dashboard' => 'support', 'Questions' => $this->module, 'Edit' => 'edit'];

		$this->data['forms']         = $this->_form($data, $validation);
		$this->data['opsijawabs']    = $opsijawab;
		$this->data['optDimensions'] = $optDimensions;
		$this->data['js']            = ['assets/js/' . $this->module . '/form.min.js'];
		$this->render('support/questions-form');
	}

	public function detail($id)
	{
		$id       = decryptUrl($id);
		$question = $this->_getDetail($id);
		$mAnswers = new \App\Models\M_answers();
		$options  = $mAnswers->efektif(['where' => [['question_id', $id, 'AND']]])['rows'];
		$data     = [
			'question' => $question,
			'options'  => $options
		];

		$this->data = [
			'status'  => ($data) ? TRUE : FALSE,
			'message' => ($data) ? 'Data ditemukan' : 'Data tidak ditemukan',
			'data'    => ($data) ? encryptUrl($question['id']) : '',
			'detail'  => ($data) ? view('support/questions-detail', $data) : ''
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

	public function lists()
	{
		if ($this->request->isAJAX()) {
			$questions = $this->model->efektif(['where' => [['method_id', $this->request->getPost('method'), 'AND']]])['rows'];

			$li = $option = '';
			foreach ($questions as $index => $question) {
				$li .= '<li class="dual-listbox__item" data-id="' . $question['id'] . '">' . $question['question'] . '</li>';
				$option .= '<option value="' . $question['id'] . '">' . $question['question'] . '</option>';
			}

			$this->data = [
				'status' => TRUE,
				'data'   => ['li' => $li, 'option' => $option]
			];
			$this->render();
		}
	}

	public function feedback()
	{
		if ($this->request->getMethod() == 'post' && $this->request->isAJAX()) {
			$mAnswers = new \App\Models\M_answers();
			$answer   = $mAnswers->baris($this->request->getPost('answer'));

			$this->data = [
				'status' => ($answer) ? TRUE : FALSE,
				'data'   => ($answer) ? 'Feedback:<br>' . $answer['feedback'] : 'Feedback:<br>-'
			];
			$this->render();
		}
	}

	public function import()
	{
		helper('form');
		$mQuestionsTmp = new \App\Models\M_questions_tmp();
		if (isMethod('get')) {

			// $dataTmp = $mQuestionsTmp->semua()['rows'];
			// $table = '';
			// if (count($dataTmp) > 0) {
			// 	$table .= '<table class="table table-striped">
			// 		<thead class="thead-dark">
			// 			<tr>
			// 				<th>
			// 				<div class="checkbox-inline">
			// 					<label class="checkbox checkbox-outline m-0 text-muted">
			// 					<input type="checkbox" name="check-all" id="check-all">
			// 					<span></span>
			// 				</div>
			// 				</th>
			// 				<th>No.</th>
			// 				<th>Method</th>
			// 				<th>Question</th>
			// 				<th>Status</th>
			// 				<th>Action</th>
			// 			</tr>
			// 		</thead>
			// 	<tbody>';
			// 	$no = 0;
			// 	foreach ($dataTmp as $data) {
			// 		$table .= '<tr>
			// 		<td>
			// 			<div class="checkbox-inline">
			// 				<label class="checkbox checkbox-outline m-0 text-muted">
			// 				<input type="checkbox" name="check-item[]" class="check-item" value="' . $data['id'] . '">
			// 				<span></span>
			// 			</div>
			// 		</td>
			// 		<td>' . ++$no . '</td>
			// 		<td>' . $data['method'] . '</td>
			// 		<td>' . $data['question'] . '</td>
			// 		<td>' . $data['active'] . '</td>
			// 		<td>
			// 			<div class="btn-group" role="group" aria-label="Action Button">
			// 				<button type="button" class="btn btn-success" value="' . $data['id'] . '">Save</button>
			// 				<button type="button" class="btn btn-danger" value="' . $data['id'] . '">Delete</button>
			// 			</div>
			// 		</td>
			// 		</tr>';
			// 	}
			// 	$table .= '</tbody></table>';
			// }

			$this->data['module']  = $this->module;
			$this->data['js']      = ['assets/js/questions/data-tmp.min.js'];
			$this->render('support/questions-import');
		}

		if (isMethod('post')) {
			$items = $this->request->getPost('check-item');
			$mQuestion = new \App\Models\M_questions();

			foreach ($items as $item) {
				$question = $mQuestionsTmp->baris($item, ['select' => 'method_id, question, a.active']);

				if ($questionID = $mQuestion->tambah($question)) {
					$this->im_logger->action('create')->module($this->module)->moduleId($questionID)->status('1')->log();
					$mQuestionsTmp->hapusPermanen($item);
				} else {
					$this->im_logger->action('create')->module($this->module)->moduleId($questionID)->status('0')->log();
				}
			}

			return redirect()->to(current_url());
		}
	}

	public function tmp()
	{
		$this->isAjaxReq('post');

		$mQuestionsTmp = new \App\Models\M_questions_tmp();

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
				'method'    => 'method_id',
				'question'  => 'question',
				'active'    => 'active'
			];
			$filters = json_decode($query['multiple'], true);
			foreach ($filters as $key => $filter) {
				$where[] = [$fields[$key], $filter, 'AND'];
			}
			$params['where'] = $where;
		}

		if (isset($query['keyword'])) {
			$params['groupLike'] = [
				['b.name', $query['keyword'], 'AND'],
				['question', $query['keyword'], 'OR']
			];
		}

		$data  = $mQuestionsTmp->eksis($params);
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

	public function answertmp()
	{
		$this->isAjaxReq('post');

		$mAnswersTmp = new \App\Models\M_answers_tmp();

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
				'method'    => 'method_id',
				'question'  => 'question',
				'active'    => 'active'
			];
			$filters = json_decode($query['multiple'], true);
			foreach ($filters as $key => $filter) {
				$where[] = [$fields[$key], $filter, 'AND'];
			}
			$params['where'] = $where;
		}

		if (isset($query['keyword'])) {
			$params['groupLike'] = [
				['b.name', $query['keyword'], 'AND'],
				['question', $query['keyword'], 'OR']
			];
		}

		$data  = $mAnswersTmp->eksis($params);
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

	public function saveImport()
	{
		$mQuestionsTmp = new \App\Models\M_questions_tmp();
		$mQuestions    = new \App\Models\M_questions();
		$mAnswersTmp   = new \App\Models\M_answers_tmp();
		$mAnswers      = new \App\Models\M_answers();

		$questions = $mQuestionsTmp->semua(['select' => 'a.id, a.method_id, question, a.active', 'order' => [['a.id', 'asc']], 'group' => ['a.id']]);
		foreach ($questions['rows'] as $question) {
			$answers   = $mAnswersTmp->semua(['where' => [['a.question_id', $question['id'], 'AND']]]);
			if ($questionId = $mQuestions->tambah($question)) {
				$mQuestionsTmp->hapusPermanen($question['id']);
				foreach ($answers['rows'] as $answer) {
					$answer['question_id'] = $question['id'];
					if ($mAnswers->tambah($answer))
						$mAnswersTmp->hapusPermanen($answer['id']);
				}
			}
		}

		return redirect()->to(site_url('support/questions/import'));
	}
}
