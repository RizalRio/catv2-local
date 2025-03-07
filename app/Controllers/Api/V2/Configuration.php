<?php

namespace App\Controllers\Api\V2;

use \IM\CI\Controllers\ApiController;

class Configuration extends ApiController
{
    public function __construct()
    {
        helper('auth');
    }

    public function getConfiguration()
    {
        try {
            $this->data['companyName'] = getConfig('companyName');
            $this->data['companyAddress'] = getConfig('companyAddress');
            $this->data['companyEmail'] = getConfig('companyEmail');
            $this->data['companyPhone'] = getConfig('companyPhone');
            $this->data['generalInstruction'] = getConfig('generalInstruction');
            $this->data['userGuide'] = getConfig('petunjukPenggunaan');
            $this->data['termsConditions'] = getConfig('termsConditions');
            return $this->render(TRUE, 'Data Berhasil Ditarik', $this->data);
        } catch (\Exception $e) {
            return $this->render(FALSE, $e->getMessage());
        }
    }
}
