<?php

namespace App\Models;

use IM\CI\Models\Modelku;

class M_type_method extends Modelku
{
    protected $DBGroup    = 'default';
    protected $table      = 'test_type_method';
    protected $primaryKey = 'id';

    protected $kolom       = 'a.id, a.id no, b.name, b.description, b.active';
    protected $gabung      = [
        ['methods b', 'b.id = a.method_id', ''],
        ['test_type c', 'c.id = a.type_id', '']
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

    protected $theFields = ['type_id', 'method_id'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
