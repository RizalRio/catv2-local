<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_users_tests extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'users_tests';
  protected $primaryKey = 'id';

  protected $kolom       = 'a.id, a.id no, a.user_id, test_id, name, d.username, fullname, description, level, question, open, close, time, start, end, answers, last_question, a.status, a.active';
  protected $gabung      = [
    ['tests b', 'b.id = test_id', ''],
    ['users_details c', 'a.user_id = c.user_id', ''],
    ['users d', 'd.id = c.user_id', '']
  ];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['a.id', 'asc']
  ];

  protected $theFields = ['class_id', 'user_id', 'test_id', 'start', 'end', 'answers', 'last_question', 'status', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
