<?php

namespace App\Controllers\Support;
use IM\CI\Controllers\AdminController;

class Type extends AdminController
{
    protected $module = 'type';

    public function __construct()
    {
        if (!in_groups(['IM', 'SA']) && !has_permission($this->module))
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $this->model = new \App\Models\M_type();
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
            'assets/js/type/data.min.js'
        ];
        $this->data['pageTitle']  = 'Type';
        $this->data['title']      = 'Data Type';
        $this->data['subTitle']   = 'Tipe tes yang digunakan';
        $this->data['breadCrumb'] = ['Dashboard' => 'support', 'Type' => ''];
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
            ['deleted', '0', 'AND']
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
        $forms['name'] = [
            'type'     => 'input',
            'required' => 'required',
            'label'    => 'Name',
            'name'     => 'name',
            'field'    => [
                'class'       => (isset($validation)) ? ($validation->hasError('name') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
                'name'        => 'name',
                'id'          => 'name',
                'placeholder' => 'Ex. Type 1',
                'value'       => set_value('name', ($params['name']) ?? ''),
                'maxlength'   => '100',
                'tabindex'    => ++$i,
                'autofocus'   => 'true'
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
                'placeholder' => 'Ex. Description Type 1',
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

        $this->data['pageTitle']  = 'Type';
        $this->data['title']      = 'Create Type';
        $this->data['breadCrumb'] = ['Dashboard' => 'support', 'Type' => $this->module, 'Create' => 'create'];

        $this->data['forms'] = $this->_form([], $validation);
        $this->data['js']    = ['assets/js/' . $this->module . '/form.min.js'];
        $this->render('IM\CI\Views\vAForm');
    }

    private function _getDetail($id)
    {
        $mUserDetail = new \App\Models\M_type();
        return $mUserDetail->baris($id, ['select' => 'id, name, description, active']);
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
            'name'          => 'required',
            'description'   => 'required',
        ])) {

            $fields = [
                'id'          => 'id',
                'name'        => 'name',
                'description' => 'description',
                'active'      => 'active'
            ];

            if ($this->checkEdit($fields, $data) === FALSE) {
                $this->im_message->add('info', "ID tidak sesuai");
                return redirect()->to('/support/' . $this->module);
            }

            if ($this->before) {

                if ($this->request->getMethod() == 'post' && $this->model->ubah($id, $this->newData)) {
                    $this->im_message->add('success', "Data berhasil diperbarui");
                    $this->im_logger->action('update')->module($this->module)->moduleId($id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('1')->log();
                    return redirect()->to('/support/' . $this->module);
                } else {
                    $this->im_logger->action('update')->module($this->module)->moduleId($id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('0')->log();
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

        $this->data['pageTitle']  = 'Type';
        $this->data['title']      = 'Edit Type';
        $this->data['breadCrumb'] = ['Dashboard' => 'support', 'Type' => $this->module, 'Edit' => 'edit'];

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

    public function method()
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
            'assets/js/'.$this->module.'/method.min.js'
        ];
        $this->data['pageTitle']  = 'Method';
        $this->data['title']      = 'Data Method';
        $this->data['subTitle']   = '';
        $this->data['breadCrumb'] = ['Dashboard' => 'support', 'Type' => 'type', 'Method' => ''];
        $this->data['module']     = $this->module;
        $this->data['table']      = 'table_' . $this->module .'-method';

        $this->data['button']['add'] = '<button type="button" id="add-button" class="btn btn-icon btn-light-success font-weight-bolder mr-2" data-toggle="tooltip" title="" data-original-title="Tambah Method" data-theme="dark">
		<i class="ki ki-solid-plus"></i>
	</button>';
        $this->render('\IM\CI\Views\vAList');
    }

    public function listmethod($userID)
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
            ['a.type_id', $userID, 'AND']
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

        $mTypeMethod = new \App\Models\M_type_method();

        $data  = $mTypeMethod->eksis($params);
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

    public function gettypenot($id)
    {
        if (isAjax('get')) {
            if ($this->request->getGet('type') == 'select') {
                $this->data = [
                    'status' => TRUE,
                    'data'   => '<select class="form-control" id="select-method" name="method" multiple="true"></select>'
                ];
                $this->render();
            }
            if ($this->request->getGet('type') == 'options') {
                try {
                    $id      = decryptUrl($id);
                    $keyword = $this->request->getGet('q');
                    $mTests  = new \App\Models\M_methods();
                    $params  = [
                        'select' => 'id, name',
                        'like' => [
                            ['name', $keyword, 'both']
                        ],
                        'group' => ['id']
                    ];
                    $tests = $mTests->efektif($params)['rows'];

                    $this->data = [];
                    if (count($tests) > 0) {
                        foreach ($tests as $test) {
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
            $methods       = $this->request->getPost('methods');
            $mTypeMethod = new \App\Models\M_type_method();

            foreach ($methods as $method) {
                $mTypeMethod->tambah([
                    'type_id'  => $id,
                    'method_id'  => $method,
                    'active'   => '1'
                ]);
            }
            $this->ajaxResponse(TRUE, count($methods) . ' Data berhasil ditambahkan', $methods);
        } catch (\Exception $e) {
            $this->ajaxResponse(FALSE, $e->getMessage());
        }
    }

    public function deletetest($id)
    {
        try {
            $id          = decryptUrl($id);
            $mTypeMethod = new \App\Models\M_type_method();
            $mTypeMethod->delete($id);
            $this->ajaxResponse(TRUE, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            $this->ajaxResponse(FALSE, $e->getMessage());
        }
    }
}
