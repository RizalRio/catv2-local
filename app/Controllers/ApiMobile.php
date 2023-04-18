<?php

namespace App\Controllers;

use DateTime;
use \IM\CI\Controllers\PublicController;
use stdClass;

class ApiMobile extends PublicController
{



	public function index()
	{
	    $user =  $this->request->getPost('users');
		echo json_encode(array('success' => false,'data' => " ".$user));
	}

	
}
