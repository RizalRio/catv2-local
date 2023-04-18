<?php

namespace App\Controllers\Support;

use \IM\CI\Controllers\AdminController;

class Answers extends AdminController
{
	protected $module = 'answers';

	public function __construct()
	{
		if (!in_groups(['IM', 'SA']) && !has_permission($this->module))
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		$this->model = new \App\Models\M_answers();
	}
	
	private function _getDetail($id)
	{
		return $this->model->baris($id, ['select' => 'a.id, d.name method, c.name dimension, question, answer, feedback']);
	}

	public function detail($id)
	{
		$id       = decryptUrl($id);
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
		if ($this->request->getMethod() == 'delete' && $this->request->isAJAX()) {
			$data = $this->model->find($id);

			if ($data) {
				$delete = $this->model->hapus($id);

				if ($delete)
					$this->im_logger->action('delete')->module($this->module)->moduleId($id)->note($data)->status('1')->log();
				else
					$this->im_logger->action('delete')->module($this->module)->moduleId($id)->status('0')->log();

				$this->ajaxResponse(($delete) ? TRUE : FALSE, ($delete) ? 'Data berhasil dihapus' : 'Data gagal dihapus', $data);
			} else {
				$this->ajaxResponse(FALSE, 'Data tidak ditemukan');
			}
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
			} else {
				$this->ajaxResponse(FALSE, 'Data tidak ditemukan');
			}
		}
	}
}
