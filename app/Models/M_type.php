<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_type extends Modelku
{
    protected $DBGroup    = 'default';
    protected $table      = 'test_type';
    protected $primaryKey = 'id';

    protected $kolom       = 'a.id, a.id no, name, description, a.active';
    protected $gabung      = [];
    protected $sama        = [];
    protected $grupSama    = [];
    protected $seperti     = [];
    protected $grupSeperti = [];
    protected $group       = [];
    protected $punya       = [];
    protected $urut        = [
        ['name', 'asc']
    ];

    protected $theFields = ['name', 'description', 'active'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
