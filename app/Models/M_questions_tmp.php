<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_questions_tmp extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'questions_tmp';
  protected $primaryKey = 'id';

  protected $kolom       = 'a.id, a.id no, b.name method, question, d.name dimension, answer, point, a.active';
  protected $gabung      = [
    ['methods b', 'b.id = a.method_id', ''],
    ['answers_tmp c', 'c.question_id = a.id', ''],
    ['dimensions d', 'd.id = c.dimension_id', '']
  ];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['a.method_id', 'asc'],
    ['a.id', 'asc']
  ];

  protected $theFields = ['method_id', 'question', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
