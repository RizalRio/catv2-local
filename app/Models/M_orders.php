<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_orders extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'orders';
  protected $primaryKey = 'id';

  protected $kolom       = 'a.id, a.id no, a.user_id, b.fullname client, a.invoice, a.active order, IF(ISNULL(c.active), 0, c.active) payment, a.created_at';
  protected $gabung      = [
    ['users_details b', 'a.user_id = b.user_id', ''],
    ['payments c', 'a.invoice = c.invoice', 'LEFT']
  ];
  protected $sama        = [];
  protected $grupSama    = [];
  protected $seperti     = [];
  protected $grupSeperti = [];
  protected $group       = [];
  protected $punya       = [];
  protected $urut        = [
    ['a.id', 'desc']
  ];

  protected $theFields = ['user_id', 'description', 'invoice', 'concentration', 'purpose', 'bill', 'confirm_date', 'created_at', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
