<?php

namespace App\Controllers\Support;

use TCPDF;

class Pdf extends TCPDF
{

  public function Header()
  {
    if ($this->page > 1) {
      $this->SetY(5);
      $this->SetFont('helvetica', '', 8);
      $this->writeHTML(view('result_pdf/header_result', ['page' => $this->getAliasNumPage()]), true, false, true, false, '');
    }
  }

  public function Footer()
  {
    if ($this->page == 1) {
      $this->SetY(-45);
      $this->SetFont('helvetica', 'I', 8);
      $this->writeHTML(view('result_pdf/footer_result'), true, false, true, false, '');
    }
  }
}
