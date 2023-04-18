<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_tests extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'tests';
  protected $primaryKey = 'id';

  protected $kolom       = 'a.id, a.id no, name, description, a.active';
  protected $gabung      = [];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['name', 'asc']
  ];

  protected $theFields = ['name', 'type_id','description', 'level', 'question', 'open', 'close', 'time', 'free', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  public function getClientTests($userID, $classID)
  {
    $query = $this->db->query("SELECT a.id, a.name, a.description, IF(a.open = '0000-00-00', CAST(NOW() AS Date), a.open) 'open', IF(a.close = '0000-00-00', CAST(NOW() AS Date), a.close) 'close', a.time, b.status, free FROM tests a
    LEFT JOIN users_tests b ON b.test_id = a.id AND user_id = '{$userID}' AND class_id = '{$classID}' 
    WHERE free = 1
    UNION
    SELECT a.id, a.name, a.description, IF(a.open = '0000-00-00', CAST(NOW() AS Date), a.open) 'open', IF(a.close = '0000-00-00', CAST(NOW() AS Date), a.close) 'close', a.time, b.status, free FROM tests a
    LEFT JOIN users_tests b ON b.test_id = a.id AND user_id = '{$userID}' AND class_id = '{$classID}' 
    WHERE free = 0");

    return $query->getResultArray();
  }
  
  public function clientTestsList($userID, $classID)
  {
    $query = $this->db->query("SELECT a.id, a.name, a.description, IF(a.open = '0000-00-00', CAST(NOW() AS Date), a.open) 'open', IF(a.close = '0000-00-00', CAST(NOW() AS Date), a.close) 'close', a.time, b.status, free FROM tests a
    LEFT JOIN users_tests b ON b.test_id = a.id AND user_id = '{$userID}' AND class_id = '{$classID}' 
    WHERE free = 1
    UNION
    SELECT a.id, a.name, a.description, IF(a.open = '0000-00-00', CAST(NOW() AS Date), a.open) 'open', IF(a.close = '0000-00-00', CAST(NOW() AS Date), a.close) 'close', a.time, b.status, free FROM tests a
    LEFT JOIN users_tests b ON b.test_id = a.id AND user_id = '{$userID}' AND class_id = '{$classID}' 
    WHERE free = 0");

    return $query->getResultArray();
  }
}
