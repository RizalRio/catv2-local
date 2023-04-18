<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_roomsUsers extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'classes_users';
  protected $primaryKey = 'id';

  protected $kolom       = 'id, id no, class_id, user_id, active';
  protected $gabung      = [];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['id', 'asc']
  ];

  protected $theFields = ['class_id', 'user_id', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
