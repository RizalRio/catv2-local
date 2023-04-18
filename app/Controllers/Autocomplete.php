<?php

namespace App\Controllers;

use \IM\CI\Controllers\PublicController;

class Autocomplete extends PublicController
{

	public function index()
	{
		$uri = $this->request->uri->getSegment(2);
		$this->{$uri}();
	}

	private function invoice()
	{
		try {
			$mOrders = new \App\Models\M_orders();
			$orders = $mOrders->efektif(['select' => ['a.invoice', 'c.active upload']])['rows'];

			if ($this->request->getGet('type') == 'raw') {
				$invoices = [];
				foreach ($orders as $order) {
					if ($order['upload'] == null)
						$invoices[] = $order['invoice'];
				}
				echo json_encode($invoices);
				die;
			}

			$this->ajaxResponse(TRUE, 'Data ditemukan', $orders);
		} catch (\Exception $e) {
			$this->ajaxResponse(FALSE, $e->getMessage());
		}
	}
}
