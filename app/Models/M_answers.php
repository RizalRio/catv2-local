<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_answers extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'answers';
  protected $primaryKey = 'id';

  protected $kolom       = 'a.id, a.id no, c.name dimension, dimension_id, answer, feedback, point';
  protected $gabung      = [
    ['questions b', 'b.id = question_id', ''],
    ['dimensions c', 'c.id = dimension_id', ''],
    ['methods d', 'd.id = c.method_id', '']
  ];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    // ['dimension_id', 'asc'],
    ['a.id', 'asc']
  ];

  protected $theFields = ['question_id', 'dimension_id', 'answer', 'feedback', 'point'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
