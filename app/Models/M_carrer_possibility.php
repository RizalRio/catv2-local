<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_carrer_possibility extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'carrer_possibility';
  protected $primaryKey = 'code';

  protected $kolom       = 'code, desc_dominant, desc_support_1, desc_support_2, carrer_possibility';
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

  protected $theFields = ['code', 'desc_dominant', 'desc_support_1', 'desc_support_2', 'carrer_possibility'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
