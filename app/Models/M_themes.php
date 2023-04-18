<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_themes extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'themes';
  protected $primaryKey = 'id';

  protected $kolom       = 'id, id no, dimension_id, name, item, active';
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

  protected $theFields = ['dimension_id', 'name', 'item', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
