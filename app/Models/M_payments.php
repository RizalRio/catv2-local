<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_payments extends Modelku
{
  protected $DBGroup    = 'default';
  protected $table      = 'payments';
  protected $primaryKey = 'id';

  protected $kolom       = 'a.id, a.id no, a.invoice, a.active';
  protected $gabung      = [
    ['orders b', 'b.invoice = a.invoice', '']
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

  protected $theFields = ['invoice', 'file', 'confirm_date', 'active'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
