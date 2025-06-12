<?php

namespace App\Controllers\Support;

use \IM\CI\Controllers\AdminController;
use Mpdf\Tag\Tr;

class Configuration extends AdminController
{
  protected $module = 'methods';

  public function __construct()
  {
    if (!in_groups(['IM', 'SA']) && !has_permission($this->module))
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    $this->model = new \App\Models\M_methods();
  }

  public function index()
  {
    if (isMethod('get')) {
      helper(['form']);
      $this->data['pageTitle']  = 'Configuration';
      $this->data['title']      = 'Configuration';
      $this->data['breadCrumb'] = ['Dashboard' => 'support', 'Configuration' => ''];
      $this->data['js']         = ['assets/js/configuration.min.js'];
      $this->render('support/configuration');
    }
    if (isMethod('post')) {
      try {
        $postData = $this->request->getPost();

        if ($postData['form'] == 'application') {
          setConfig(11, ['value' => $postData['penggunaan']], TRUE);
          setConfig(13, ['value' => $postData['syarat']], TRUE);
          setConfig(14, ['value' => $postData['ucapan']], TRUE);
        }

        if ($postData['form'] == 'test') {
          setConfig(8, ['value' => $postData['instruction']], TRUE);
          setConfig(12, ['value' => $postData['terms']], TRUE);
        }

        if ($postData['form'] == 'report') {
          setConfig(9, ['value' => $postData['how']], TRUE);
          setConfig(10, ['value' => $postData['desc']], TRUE);
        }

        $this->data = [
          'status'  => TRUE,
          'message' => 'Successfully saved data',
          'data'    => $postData
        ];
      } catch (\Exception $e) {
        $this->data = [
          'status'  => FALSE,
          'message' => $e->getMessage()
        ];
      }
      $this->render();
    }
  }
}
