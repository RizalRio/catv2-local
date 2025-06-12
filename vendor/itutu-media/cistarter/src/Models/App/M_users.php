<?php

namespace IM\CI\Models\App;

use IM\CI\Models\Modelku;

class M_users extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'users';
  protected $primaryKey = 'id';

  protected $kolom       = 'b.id id, b.id no, email, username, password_hash, avatar, active';
  protected $gabung      = [
    ['users_details b', 'b.user_id = a.id', '']
  ];
  protected $sama        = [
    // ['b.id >', '1', 'AND'],
    // ['group_id <>', '1', 'AND'],
    // ['manage', '1', 'AND']
  ];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = ['b.user_id'];
  protected $punya       = [];
  protected $urut        = [
    ['a.id', 'asc']
  ];

  protected $theFields = ['id', 'email', 'username', 'password_hash', 'avatar', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
