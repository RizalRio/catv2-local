<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		helper('auth');
		if (logged_in()) {
			if (in_groups('DF'))
				return redirect()->to('dashboard');
			else
				return redirect()->to('support/dashboard');
		} else
			return redirect()->route('login');
	}

	//--------------------------------------------------------------------

}
