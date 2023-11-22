<?php

namespace IM\CI\Controllers;

use \IM\CI\Controllers\GlobalController;

class Account extends GlobalController
{
	protected $module  = 'account';

	private function _getDetail($id)
	{
		$mUserDetail = new \IM\CI\Models\App\M_userDetail();
		return $mUserDetail->baris($id, ['select' => 'a.user_id, fullname, address, phone, concentration, purpose, complete_reg, email, username, avatar']);
	}

	public function index()
	{
		try {
			$data = $this->_getDetail(user()->id);
		} catch (\Throwable $th) {
			$this->errorPage();
		}

		helper(['form', 'text']);
		$validation = null;
		$i          = 0;

		$formPersonal['forms'] = $this->_formPersonal($data, $validation);
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

		$formAccount['forms'] = $this->_formAccount($data, $validation);
		$this->data['formAccount'] = view('IM\CI\Views\vAFormBuilder', $formAccount);

		$this->data['avatar'] = ($data['avatar'] == DEFAULT_AVATAR) ? $data['avatar'] : 'uploads/' . $data['username'] . '/' . $data['avatar'];
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

		$formPassword['forms'] = $this->_formPassword($data, $validation);
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

		$this->data['js'] = ['assets/js/account.min.js'];

		if (has_permission('management')) {
			$mMenu   = new \IM\CI\Models\Menu\M_menus();
			$sideBar = $mMenu->getMenu('Admin Sidebar');

			$this->data['pageTitle']  = ($this->data['pageTitle']) ?? 'Dashboard';
			$this->data['title']      = ($this->data['title']) ?? 'Dashboard';
			$this->data['subTitle']   = ($this->data['subTitle']) ?? '';
			$this->data['sidebar']    = $this->menuBuilder->adminSidebarBuilder($sideBar);
			$this->data['breadCrumb'] = ($this->data['breadCrumb']) ?? ['Dashboard' => 'support'];

			$this->data['messages']		= ($this->data['messages']) ?? $this->im_message->get();

			$this->render('\IM\CI\Views\support\account');
		} else {
			$mMenu   = new \IM\CI\Models\Menu\M_menus();
			$sideBar = $mMenu->getMenu('Client Sidebar');

			$this->data['sidebar'] = $this->menuBuilder->clientSidebarBuilder($sideBar);

			$this->render('\IM\CI\Views\user\account');
		}
	}

	public function _formPersonal(array $user, $validation = null)
	{
		$i     = 0;
		$forms = [];

		$forms['id'] = [
			'type' => 'hidden',
			'name' => 'id',
			'field' => [
				'id' => (isset($user['user_id'])) ? encryptUrl($user['user_id']) : ''
			]
		];
		$forms['fullname'] = [
			'type'     => 'input',
			'required' => 'required',
			'label'    => 'Nama Lengkap',
			'name'     => 'fullname',
			'field'    => [
				'class'       => (isset($validation)) ? ($validation->hasError('fullname') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'        => 'fullname',
				'id'          => 'fullname',
				'placeholder' => 'Ex. Method 1',
				'value'       => set_value('fullname', ($user['fullname']) ?? ''),
				'maxlength'   => '100',
				'tabindex'    => ++$i,
			]
		];
		$forms['address'] = [
			'type'     => 'textarea',
			'required' => 'required',
			'label'    => 'Alamat',
			'name'     => 'address',
			'field'    => [
				'class'       => (isset($validation)) ? ($validation->hasError('address') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'        => 'address',
				'id'          => 'address',
				'placeholder' => 'Ex. Jalan Kebaikan Gang Kebenaran',
				'value'       => set_value('address', ($user['address']) ?? ''),
				'tabindex'    => ++$i,
				'rows'        => '2'
			]
		];
		$forms['phone'] = [
			'type'     => 'input',
			'required' => 'required',
			'label'    => 'No. HP',
			'name'     => 'phone',
			'field'    => [
				'class'       => (isset($validation)) ? ($validation->hasError('phone') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'        => 'phone',
				'id'          => 'phone',
				'placeholder' => 'Ex. 080989999',
				'value'       => set_value('phone', ($user['phone']) ?? ''),
				'maxlength'   => '15',
				'tabindex'    => ++$i,
			]
		];
		if (has_permission('manage') || in_groups('IM')) {
			$forms['concentration'] = [
				'type'     => 'input',
				'name'     => 'concentration',
				'field'    => [
					'type'  => 'hidden',
					'class' => 'form-control',
					'name'  => 'concentration',
					'id'    => 'concentration',
					'value' => '-',
				]
			];
			$forms['purpose'] = [
				'type'     => 'input',
				'name'     => 'purpose',
				'field'    => [
					'type'  => 'hidden',
					'class' => 'form-control',
					'name'  => 'purpose',
					'id'    => 'purpose',
					'value' => '-',
				]
			];
		} else {
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
					'selected' => $user['concentration']
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
					'value'       => set_value('purpose', ($user['purpose']) ?? ''),
					'tabindex'    => ++$i,
					'rows'        => '2'
				]
			];
		}

		return $forms;
	}

	public function _formAccount(array $user, $validation = null)
	{
		$i     = 0;
		$forms = [];

		$forms['id'] = [
			'type' => 'hidden',
			'name' => 'id',
			'field' => [
				'id' => (isset($user['user_id'])) ? encryptUrl($user['user_id']) : ''
			]
		];
		$forms['username'] = [
			'type'     => 'input',
			'required' => 'required',
			'label'    => 'Username',
			'name'     => 'username',
			'field'    => [
				'class'     => (isset($validation)) ? ($validation->hasError('username') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'      => 'username',
				'id'        => 'username',
				'value'     => set_value('username', ($user['username']) ?? ''),
				'maxlength' => '100',
				'tabindex'  => ++$i,
			]
		];
		$forms['email'] = [
			'type'     => 'input',
			'required' => 'required',
			'label'    => 'Email',
			'name'     => 'email',
			'field'    => [
				'class'     => (isset($validation)) ? ($validation->hasError('email') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'      => 'email',
				'id'        => 'email',
				'value'     => set_value('email', ($user['email']) ?? ''),
				'maxlength' => '255',
				'tabindex'  => ++$i,
				'readonly'  => 'readonly'
			]
		];

		return $forms;
	}

	public function _formPassword(array $user, $validation = null)
	{
		$i     = 0;
		$forms = [];

		$forms['id'] = [
			'type'  => 'hidden',
			'name'  => 'id',
			'field' => [
				'id' => (isset($user['user_id'])) ? encryptUrl($user['user_id']) : ''
			]
		];
		$forms['email'] = [
			'type'  => 'hidden',
			'name'  => 'email',
			'field' => [
				'email' => (isset($user['email'])) ? $user['email'] : ''
			]
		];
		$forms['password'] = [
			'type'     => 'password',
			'required' => 'required',
			'label'    => 'Password Saat Ini',
			'name'     => 'password',
			'field'    => [
				'class'     => (isset($validation)) ? ($validation->hasError('password') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'      => 'password',
				'id'        => 'password',
				'maxlength' => '32',
				'tabindex'  => ++$i,
			]
		];
		$forms['npassword'] = [
			'type'     => 'password',
			'required' => 'required',
			'label'    => 'Password Baru',
			'name'     => 'npassword',
			'field'    => [
				'class'     => (isset($validation)) ? ($validation->hasError('npassword') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'      => 'npassword',
				'id'        => 'npassword',
				'maxlength' => '32',
				'tabindex'  => ++$i,
			]
		];
		$forms['cpassword'] = [
			'type'     => 'password',
			'required' => 'required',
			'label'    => 'Konfirmasi Password Baru',
			'name'     => 'cpassword',
			'field'    => [
				'class'     => (isset($validation)) ? ($validation->hasError('cpassword') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
				'name'      => 'cpassword',
				'id'        => 'cpassword',
				'maxlength' => '32',
				'tabindex'  => ++$i,
			]
		];

		return $forms;
	}

	public function personal()
	{
		$this->isAjaxReq('post');

		if (!$this->validate([
			'id'            => 'required',
			'fullname'      => 'required',
			'address'       => 'required',
			'phone'         => 'required',
			'concentration' => 'required',
			'purpose'       => 'required',
		])) {
			$this->ajaxResponse(FALSE, $this->validator->getErrors());
		}

		$postData = $this->request->getPost();

		$mUserDetail = new \IM\CI\Models\App\M_userDetail();
		$user = $mUserDetail->baris(decryptUrl($postData['id']), ['select' => 'a.user_id, fullname, address, phone, concentration, purpose, complete_reg, email, username, avatar']);

		if (is_null($user))
			$this->ajaxResponse(FALSE, 'Account tidak ditemukan');

		$this->newData = ['complete_reg' => '1'];
		$fields  = [
			'id'            => 'user_id',
			'fullname'      => 'fullname',
			'address'       => 'address',
			'phone'         => 'phone',
			'concentration' => 'concentration',
			'purpose'       => 'purpose',
		];

		$this->checkEdit($fields, $user);

		$message = 'Tidak ada perubahan data';

		if ($this->before && $mUserDetail->ubah($user['user_id'], $this->newData)) {
			$this->im_logger->action('update')->module('users_details')->moduleId($user['user_id'])->user($user['user_id'])->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('1')->log();
			$message = 'Data berhasil diperbarui';
		}

		$this->ajaxResponse(TRUE, $message, $this->newData);
	}

	public function account()
	{
		$this->isAjaxReq('post');

		if (!$this->validate([
			'id' => 'required',
			'username' => 'required',
		])) {
			$this->ajaxResponse(FALSE, $this->validator->getErrors());
		}

		$postData = $this->request->getPost();

		$users = model('UserModel');
		$user = $users->where('id', decryptUrl($postData['id']))->get()->getRowArray();

		if (is_null($user))
			$this->ajaxResponse(FALSE, 'Account tidak ditemukan');

		$fields  = [
			'id'       => 'id',
			'username' => 'username',
		];

		$this->checkEdit($fields, $user);

		$message = 'Tidak ada perubahan data';

		$user['username'] = $postData['username'];

		$avatar  = $this->request->getFile('avatar');
		$userDir = 'uploads/' . $user['username'] . '/';
		if ($avatar != '') {
			if (!$this->validate([
				'avatar' => 'uploaded[avatar]|mime_in[avatar,image/jpg,image/jpeg]|max_size[avatar,1024]'
			]))
				$this->ajaxResponse(FALSE, 'Ukuran gambar maksimal 1MB');

			$oldFile  = ($user['avatar'] == DEFAULT_AVATAR) ? NULL : $user['avatar'];
			$doUpload = $this->doUpload($userDir, $avatar, $avatar->getRandomName(), $oldFile);
			if ($doUpload) {
				$user['avatar'] = $doUpload->getName();
				$this->before['avatar'] = $user['avatar'];
				$this->after['avatar'] = $doUpload->getName();
			}
		}

		$avatar64 = $this->request->getPost('avatar64');
		if ($avatar64) {
			$oldFile = ($user['avatar'] == DEFAULT_AVATAR) ? NULL : $user['avatar'];
			if ($oldFile)
				unlink($userDir . $oldFile);

			helper('text');
			$dataImg = explode(',', $avatar64);
			$fileType = substr(explode(';', $dataImg[0])[0], strpos($dataImg[0], '/') + 1);
			$fileName = time() . '_' . random_string('alnum', 20) . '.' . $fileType;

			file_put_contents($userDir . $fileName, base64_decode($dataImg[1]));

			$user['avatar'] = $fileName;
			$this->before['avatar'] = $user['avatar'];
			$this->after['avatar'] = $fileName;
		}

		if ($this->before && $users->save($user)) {
			if (isset($this->before['username']))
				changeUserDirName($this->before['username'], $postData['username']);

			$this->im_logger->action('update')->module('users')->moduleId($user['id'])->user($user['id'])->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('1')->log();
			$message = 'Data berhasil diperbarui';
		}

		$avatar = ($user['avatar'] == DEFAULT_AVATAR) ? $user['avatar'] : $userDir . $user['avatar'];
		$this->ajaxResponse(TRUE, $message, $this->newData, ['avatar' => site_url($avatar)]);
	}

	public function password()
	{
		$this->isAjaxReq('post');

		if (!$this->validate([
			'id'        => 'required',
			'email'     => 'required|valid_email',
			'password'  => 'required|min_length[8]',
			'npassword' => 'required',
			'cpassword' => 'required|matches[npassword]',
		])) {
			$this->ajaxResponse(FALSE, $this->validator->getErrors());
		}

		$postData = $this->request->getPost();

		$users = model('UserModel');
		$user  = $users->where('email', $postData['email'])->first();

		$auth = service('authentication');

		if (!$auth->validate(['email' => $postData['email'], 'password' => $postData['password']], FALSE)) {
			$this->ajaxResponse(FALSE, $auth->error());
		}


		$this->before['password'] = $postData['password'];
		$this->after['password'] = $postData['npassword'];

		$message = 'Tidak ada perubahan data';

		$user->password = $postData['npassword'];

		if ($this->before && $users->save($user)) {
			$this->im_logger->action('update')->module('users')->moduleId(decryptUrl($postData['id']))->user($user->id)->note(json_encode(['b' => $this->before, 'a' => $this->after]))->status('1')->log();
			$message = 'Data berhasil diperbarui';
		}

		$this->ajaxResponse(TRUE, $message, $this->newData);
	}
}
