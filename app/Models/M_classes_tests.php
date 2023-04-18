<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_classes_tests extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'classes_tests';
  protected $primaryKey = 'id';

  protected $kolom       = 'id, id no, class_id, test_id, active';
  protected $gabung      = [
    ['classes b', 'b.id = a.class_id', ''],
    ['tests c', 'c.id = a.test_id', '']
  ];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['id', 'asc']
  ];

  protected $theFields = ['class_id', 'test_id', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
