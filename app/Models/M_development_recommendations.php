<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_development_recommendations extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'development_recommendations';
  protected $primaryKey = 'code';

  protected $kolom       = 'code, development';
  protected $gabung      = [];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['code', 'asc']
  ];

  protected $theFields = ['code', 'development'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
