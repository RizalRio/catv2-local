<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_scales extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'scales';
  protected $primaryKey = 'id';

  protected $kolom       = 'id, id no, method_id, group_id, name, description, active';
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

  protected $theFields = ['method_id', 'name', 'description', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}