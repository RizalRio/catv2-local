<?php

namespace App\Controllers\Support;

use \IM\CI\Controllers\AdminController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Export extends AdminController
{
  public function __construct()
  {
    $this->spreadsheet = new Spreadsheet();
  }

  public function template($module)
  {
    $total = $this->request->getPost('total');
    $this->{'_' . $module}($total);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Data ' . ucfirst($module) . ' - ' . date('d-m-Y H:i:s') . '.xls"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');

    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer = IOFactory::createWriter($this->spreadsheet, 'Xls');
    $writer->save('php://output');
    exit;
  }

  private function _questions($total)
  {
    // Start Sheet Reference
    $sheet = $this->spreadsheet->setActiveSheetIndex(0);
    $sheet->setTitle('References');

    $mMethods = new \App\Models\M_methods();
    $methods  = $mMethods->efektif(['select' => 'id, name', 'order' => [['id', 'asc']]])['rows'];
    $sheet->setCellValue('A1', 'DATA METHODS');
    $sheet->setCellValue('A2', 'ID');
    $sheet->setCellValue('B2', 'Method');
    $sheet->mergeCells('A1:B1');
    foreach ($methods as $key => $value) {
      $sheet->setCellValue('A' . ($key + 3), $value['id']);
      $sheet->setCellValue('B' . ($key + 3), $value['name']);
      $lastMethod = ($key + 3);
      $lastCell   = 'B' . ($key + 3);
    }

    $sheet->getStyle('A1:' . $lastCell)->applyFromArray(
      [
        'borders' => [
          'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
          'inside' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
      ]
    );
    $sheet->getStyle('A1:B2')->applyFromArray(
      [
        'font' => [
          'bold' => true
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
      ]
    );
    $sheet->getStyle('A1:B' . $lastMethod)->applyFromArray(
      [
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
      ]
    );

    foreach (range('A', 'B') as $columnID) {
      $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    

    $mDimensions = new \App\Models\M_dimensions();
    $dimensions  = $mDimensions->efektif(['select' => 'a.id, a.name, b.name as method'])['rows'];
    $sheet->setCellValue('D1', 'DATA DIMENSIONS');
    $sheet->setCellValue('D2', 'ID');
    $sheet->setCellValue('E2', 'Method');
    $sheet->setCellValue('F2', 'Dimension');
    $sheet->mergeCells('D1:F1');
    foreach ($dimensions as $key => $value) {
      $sheet->setCellValue('D' . ($key + 3), $value['id']);
      $sheet->setCellValue('E' . ($key + 3), $value['method']);
      $sheet->setCellValue('F' . ($key + 3), $value['name']);
      $lastDimension = ($key + 3);
      $lastCell      = 'F' . ($key + 3);
    }

    $sheet->getStyle('D1:' . $lastCell)->applyFromArray(
      [
        'borders' => [
          'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
          'inside' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
      ]
    );
    $sheet->getStyle('D1:F2')->applyFromArray(
      [
        'font' => [
          'bold' => true
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
      ]
    );
    $sheet->getStyle('D1:D' . $lastDimension)->applyFromArray(
      [
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
      ]
    );

    foreach (range('D', 'F') as $columnID) {
      $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    // End Sheet Reference

    $this->spreadsheet->createSheet();
    $sheet = $this->spreadsheet->setActiveSheetIndex(1);
    $sheet->setTitle('Questions');
    $sheet->setCellValue('A1', 'IMPORT QUESTIONS');
    $sheet->setCellValue('A2', 'No');
    $sheet->setCellValue('B2', 'Method');
    $sheet->setCellValue('C2', 'Question');
    $sheet->setCellValue('D2', 'Active');
    $sheet->mergeCells('A1:D1');
    $lastColumn = 'D';

    $i = 2;
    $noSoal = [];
    for ($no = 1; $no <= $total; $no++) {
      $noSoal[] = $no;
      $sheet->setCellValue('A' . ++$i, $no);

      $sheet->getCell('B' . $i)
        ->getDataValidation()
        ->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST)
        ->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION)
        ->setAllowBlank(false)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('Input error')
        ->setError('Value is not in list.')
        ->setPromptTitle('Pick from list')
        ->setPrompt('Please pick a value from the drop-down list.')
        ->setFormula1('References!$A$3:$A$' . $lastMethod);
    }
    $lastRow = $i;

    $sheet->getStyle('A1:' . $lastColumn . $i)->applyFromArray(
      [
        'borders' => [
          'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
          'inside' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
      ]
    );
    $sheet->getStyle('A1:' . $lastColumn . '2')->applyFromArray(
      [
        'font' => [
          'bold' => true
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
      ]
    );
    $sheet->getStyle('A1:A' . $i)->applyFromArray(
      [
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
      ]
    );

    foreach (range('A', $lastColumn) as $columnID) {
      $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $this->spreadsheet->createSheet();
    $sheet = $this->spreadsheet->setActiveSheetIndex(2);
    $sheet->setTitle('Answers');
    $sheet->setCellValue('A1', 'IMPORT ANSWERS');
    $sheet->setCellValue('A2', 'No');
    $sheet->setCellValue('B2', 'Question');
    $sheet->setCellValue('C2', 'Dimension');
    $sheet->setCellValue('D2', 'Answer');
    $sheet->setCellValue('E2', 'Feedback');
    $sheet->setCellValue('F2', 'Point');
    $sheet->setCellValue('G2', 'Active');
    $sheet->mergeCells('A1:G1');
    $lastColumn = 'G';

    $i = 3;
    for ($no = 1; $no <= $total; $no++) {
      $sheet->setCellValue('A' . $i, $no);

      $sheet->getCell('B' . $i)
        ->getDataValidation()
        ->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST)
        ->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION)
        ->setAllowBlank(false)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('Input error')
        ->setError('Value is not in list.')
        ->setPromptTitle('Pick from list')
        ->setPrompt('Please pick a value from the drop-down list.')
        ->setFormula1('Questions!$A$3:$A$' . $lastRow);

      $sheet->getCell('C' . $i)
        ->getDataValidation()
        ->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST)
        ->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION)
        ->setAllowBlank(false)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('Input error')
        ->setError('Value is not in list.')
        ->setPromptTitle('Pick from list')
        ->setPrompt('Please pick a value from the drop-down list.')
        ->setFormula1('References!$D$3:$D$' . $lastDimension);

      $i++;
    }
    $i--;

    $sheet->getStyle('A1:' . $lastColumn . $i)->applyFromArray(
      [
        'borders' => [
          'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
          'inside' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
      ]
    );
    $sheet->getStyle('A1:' . $lastColumn . '2')->applyFromArray(
      [
        'font' => [
          'bold' => true
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
      ]
    );
    $sheet->getStyle('A1:A' . $i)->applyFromArray(
      [
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
      ]
    );

    foreach (range('A', $lastColumn) as $columnID) {
      $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $this->spreadsheet->getProperties()->setCreator('Titian Indonesia')
      ->setLastModifiedBy('Titian Indonesia')
      ->setTitle('Data Questions')
      ->setSubject('Data Questions')
      ->setDescription('Data Questions')
      ->setKeywords('data Questions')
      ->setCategory('Data Questions');
    $this->spreadsheet->setActiveSheetIndex(0);
  }

  private function _answers($total)
  {
    $sheet = $this->spreadsheet->setActiveSheetIndex(0);
    $sheet->setTitle('Answers');
    $sheet->setCellValue('A1', 'IMPORT ANSWERS');
    $sheet->setCellValue('A2', 'No');
    $sheet->setCellValue('B2', 'Question');
    $sheet->setCellValue('C2', 'Dimension');
    $sheet->setCellValue('D2', 'Answer');
    $sheet->setCellValue('E2', 'Feedback');
    $sheet->setCellValue('F2', 'Point');
    $sheet->setCellValue('G2', 'Active');
    $sheet->mergeCells('A1:G1');
    $lastColumn = 'G';

    $mDimensions = new \App\Models\M_dimensions();
    $dimensions  = $mDimensions->efektif(['select' => 'a.id, a.name, b.name as method'])['rows'];
    $dimension   = [];
    foreach ($dimensions as $key => $value) {
      $dimension[] = '[' . $value['id'] . ']. - ' . $value['method'] . ' - ' . $value['name'];
    }

    $i = 3;
    for ($no = 1; $no <= $total; $no++) {
      $sheet->setCellValue('A' . $i, $no);

      $validation = $sheet->getCell('C' . $i)
        ->getDataValidation();
      $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
      $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
      $validation->setAllowBlank(false);
      $validation->setShowInputMessage(true);
      $validation->setShowErrorMessage(true);
      $validation->setShowDropDown(true);
      $validation->setErrorTitle('Input error');
      $validation->setError('Value is not in list.');
      $validation->setPromptTitle('Pick from list');
      $validation->setPrompt('Please pick a value from the drop-down list.');
      $validation->setFormula1('"' . implode(',', $dimension) . '"');

      $i++;
    }
    $i--;

    $sheet->getStyle('A1:' . $lastColumn . $i)->applyFromArray(
      [
        'borders' => [
          'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
          'inside' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
      ]
    );
    $sheet->getStyle('A1:' . $lastColumn . '2')->applyFromArray(
      [
        'font' => [
          'bold' => true
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
      ]
    );
    $sheet->getStyle('A1:A' . $i)->applyFromArray(
      [
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
      ]
    );

    foreach (range('A', $lastColumn) as $columnID) {
      $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $this->spreadsheet->getProperties()->setCreator('Titian Indonesia')
      ->setLastModifiedBy('Titian Indonesia')
      ->setTitle('Data Answers')
      ->setSubject('Data Answers')
      ->setDescription('Data Answers')
      ->setKeywords('data Answers')
      ->setCategory('Data Answers');
    $this->spreadsheet->setActiveSheetIndex(0);
  }
}
