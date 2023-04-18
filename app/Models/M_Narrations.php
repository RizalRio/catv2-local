<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_Narrations extends Modelku
{
    protected $DBGroup    = 'default';
    protected $table      = 'narrations';
    protected $primaryKey = 'id';

    protected $kolom       = 'a.id, a.id no, b.name method, a.name, a.description, a.active';
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
        ['name', 'asc']
    ];

    protected $theFields = ['method_id','name', 'description', 'active'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
