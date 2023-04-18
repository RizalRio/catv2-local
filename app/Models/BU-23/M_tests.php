<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_tests extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'tests';
  protected $primaryKey = 'id';

  protected $kolom       = 'id, id no, name, description, active';
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

  protected $theFields = ['name', 'description', 'level', 'question', 'time', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  public function getClientTests($userId)
  {
    $query = $this->db->query("SELECT a.id, a.name, a.description, IF(a.open = '0000-00-00', '-', CONCAT(a.open, ' - ', a.close)) tanggal, a.time, b.status, free FROM tests a
    LEFT JOIN users_tests b ON b.test_id = a.id AND user_id = '{$userId}' 
    WHERE free = 1
    UNION
    SELECT a.id, a.name, a.description, IF(a.open = '0000-00-00', '-', CONCAT(a.open, ' - ', a.close)) tanggal, a.time, b.status, free FROM tests a
    LEFT JOIN users_tests b ON b.test_id = a.id AND user_id = '{$userId}' 
    WHERE free = 0");

    return $query->getResultArray();
  }
}
