<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_methods extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'methods';
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

  protected $theFields = ['name', 'description', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
