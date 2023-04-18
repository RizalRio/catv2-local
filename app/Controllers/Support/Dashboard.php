<?php

namespace App\Controllers\Support;

use \IM\CI\Controllers\AdminController;

class Dashboard extends AdminController
{
	public function index()
	{
		$mMethods    = new \App\Models\M_methods();
		$mDimensions = new \App\Models\M_dimensions();
		$mQuestions  = new \App\Models\M_questions();
		$mTests      = new \App\Models\M_tests();

		$widgets = [
			'methods'    => $mMethods->efektif()['total'],
			'dimensions' => $mDimensions->efektif()['total'],
			'questions'  => $mQuestions->efektif()['total'],
			'tests'      => $mTests->efektif()['total']
		];
		$this->data['widgets'] = $widgets;

		$mLogins = new \IM\CI\Models\App\M_authLogins();
		$this->data['logins'] = $mLogins->semua(['like' => [['date', date('Y-m-d'), 'after']]])['rows'];

		$this->render('support/dashboard');
	}
}
