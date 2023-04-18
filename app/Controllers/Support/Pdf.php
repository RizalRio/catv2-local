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
      $this->writeHTML(view('pdf/header', ['page' => $this->getAliasNumPage()]), true, false, true, false, '');
    }
  }

  public function Footer()
  {
    if ($this->page == 1) {
      $this->SetY(-45);
      $this->SetFont('helvetica', 'I', 8);
      $this->writeHTML(view('pdf/footer'), true, false, true, false, '');
    }
  }
}
