<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_answers extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'answers';
  protected $primaryKey = 'id';

  protected $kolom       = 'a.id, a.id no, b.name dimension, dimension_id, answer, feedback';
  protected $gabung      = [
    ['dimensions b', 'b.id = dimension_id', '']
  ];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['dimension_id', 'asc'],
    ['a.id', 'asc']
  ];

  protected $theFields = ['question_id', 'dimension_id', 'answer', 'feedback'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
