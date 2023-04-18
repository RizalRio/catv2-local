<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_questions extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'questions';
  protected $primaryKey = 'id';

  protected $kolom       = 'a.id, a.id no, b.name method, question, a.active';
  protected $gabung      = [
    ['methods b', 'b.id = method_id', '']
  ];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['method_id', 'asc'],
    ['a.id', 'asc']
  ];

  protected $theFields = ['method_id', 'question', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
