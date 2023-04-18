<?php

namespace IM\CI\Models\App;

use IM\CI\Models\Modelku;

class M_authLogins extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'auth_logins';
  protected $primaryKey = 'id';

  protected $kolom       = 'ip_address, DATE_FORMAT(date,"%H:%s") time, username, IF(type = 0, "primary", "danger") color, IF(type = 0, "Login", "Logout") type';
  protected $gabung      = [
    ['users_details b', 'a.user_id = b.user_id', ''],
    ['users c', 'a.user_id = c.id', '']
  ];
  protected $sama        = [
    ['b.user_id >', '1', 'AND']
  ];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['a.id', 'desc']
  ];

  protected $allowedFields = ['ip_address', 'email', 'user_id', 'date', 'success', 'type'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
