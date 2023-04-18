<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_classes_users extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'classes_users';
  protected $primaryKey = 'id';

  protected $kolom       = 'a.id, a.id no, a.class_id, b.name, b.description, a.active';
  protected $gabung      = [
    ['classes b', 'b.id = a.class_id', '']
  ];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['a.class_id', 'asc']
  ];

  protected $theFields = ['class_id', 'user_id', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
