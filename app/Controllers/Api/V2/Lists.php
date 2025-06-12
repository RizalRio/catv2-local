<?php

namespace App\Controllers\Api\V2;

use \IM\CI\Controllers\ApiController;

class Lists extends ApiController
{
  protected $module    = 'tests';
  protected $modelName = 'App\Models\M_users_tests';

  public function __construct()
  {
    helper('auth');
  }

  public function dashboard()
  {
    try {
      $userID = decryptUrl($this->request->getGet('user_id'));

      $params = [
        'select' => ['a.id user_test', 'b.name', 'b.description', 'a.status', 'a.start', 'a.end', 'time', 'open', 'close'],
        'where' => [
          ['a.user_id', $userID, 'AND']
        ],
        'order' => [['open', 'desc']]
      ];
      $tests = $this->model->efektif($params);

      foreach ($tests['rows'] as $key => $value) {
        $tests['rows'][$key]['user_test'] = encryptUrl($tests['rows'][$key]['user_test']);
      }

      return $this->render(TRUE, $tests['total'] . ' data ditemukan', $tests['rows']);
    } catch (\Exception $e) {
      return $this->render(FALSE, $e->getMessage());
    }
  }

  public function class()
  {
    try {
      $userID = decryptUrl($this->request->getGet('user_id'));
      if (!$this->request->getGet('class_id')) {
        $mClassUsers = new \App\Models\M_classes_users();
        $classes     = $mClassUsers->efektif(['where' => [['user_id', $userID, 'AND']]]);

        foreach ($classes['rows'] as $key => $value) {
          $classes['rows'][$key]['class_id'] = encryptUrl($value['class_id']);
        }

        return $this->render(TRUE, $classes['total'] . ' data ditemukan', $classes['rows']);
      } else {
        $classID     = decryptUrl($this->request->getGet('class_id'));
        $mClassTests = new \App\Models\M_classes_tests();

        $params = [
          'select' => ["c.id test_id", "c.name", "c.description", "IF(c.open = '0000-00-00', CAST(NOW() AS Date), c.open) 'open'", "IF(c.close = '0000-00-00', CAST(NOW() AS Date), c.close) 'close'", "c.time", "d.status"],
          'join' => [
            ['users_tests d', 'd.test_id = a.test_id AND d.class_id = a.class_id', 'LEFT'],
            ['classes_users e', 'e.class_id = a.class_id', 'LEFT']
          ],
          'where' => [
            ['a.class_id', $classID, 'AND'],
            ['e.user_id', $userID, 'AND'],
          ],
          'order' => [
            ['open', 'desc']
          ]
        ];
        $tests = $mClassTests->eksis($params);

        foreach ($tests['rows'] as $key => $value) {
          $tests['rows'][$key]['test_id']  = encryptUrl($value['test_id']);
          $tests['rows'][$key]['class_id'] = encryptUrl($classID);
        }

        return $this->render(TRUE, $tests['total'] . ' data ditemukan', $tests['rows']);
      }
    } catch (\Exception $e) {
      return $this->render(FALSE, $e->getMessage());
    }
  }

  public function test()
  {
    try {
      $userID = decryptUrl($this->request->getGet('user_id'));

      $tests = $this->model->efektif([
        'select' => ['a.id user_test', 'b.name', 'b.description', 'a.status', 'a.start', 'a.end', 'time', 'open', 'close'],
        'where' => [['a.user_id', $userID, 'AND']],
        'order' => [['open', 'desc']]
      ]);

      foreach ($tests['rows'] as $key => $value) {
        $tests['rows'][$key]['user_test'] = encryptUrl($value['user_test']);
      }

      return $this->render(TRUE, $tests['total'] . ' data ditemukan', $tests['rows']);
    } catch (\Exception $e) {
      return $this->render(FALSE, $e->getMessage());
    }
  }

  public function search()
  {
    try {
      $post = $this->request->getPost();
      $userID = decryptUrl($post['user_id']);
      $search = $post['search'];
      $params = [
        'select' => ['a.id user_test', 'b.name', 'b.description', 'a.status', 'a.start', 'a.end', 'time', 'open', 'close'],
        'where' => [
          ['a.user_id', $userID, 'AND'],
        ],
        'like' => [
          ['b.name', $search, 'both']
        ],
        'order' => [['open', 'desc']]
      ];
      $tests = $this->model->efektif($params);

      foreach ($tests['rows'] as $key => $value) {
        $tests['rows'][$key]['user_test'] = encryptUrl($tests['rows'][$key]['user_test']);
      }

      return $this->render(TRUE, $tests['total'] . ' data ditemukan', $tests['rows']);
    } catch (\Exception $e) {
      return $this->render(FALSE, $e->getMessage());
    }
  }
}
