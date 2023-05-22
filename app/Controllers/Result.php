<?php

namespace App\Controllers;

use \IM\CI\Controllers\GlobalController;
use App\Controllers\Support\Pdf;

class Result extends GlobalController
{
	private function rumusData(array $data)
	{
		$jumlahData = count($data);
		$jumlahNilai = array_sum($data);
		$mean = $jumlahNilai/$jumlahData;

		$jumlahSelisihKuadrat = 0;
		foreach($data as $nilai) {
			$selisih = $nilai - $mean;
			$selisihKuadrat = $selisih * $selisih;

			$jumlahSelisihKuadrat += $selisihKuadrat;
		}

		$variansi = $jumlahSelisihKuadrat / ($jumlahData - 1);
		$standarDeviasi = sqrt($variansi);

		$result = [
			'jumlahData' => $jumlahData,
			'jumlahNilai' => $jumlahNilai,
			'mean'	=> $mean,
			'standarDeviasi' => $standarDeviasi
		];

		return $result;
	}

	private function rumusZ($data, $hasil_hitung){
		$skorZ = ($data - $hasil_hitung['mean']) / $hasil_hitung['standarDeviasi'];

		return $skorZ;
	}

	private function z_scoring($resultID)
	{
		try{
			$id = $resultID;
			$mUsersTests = new \App\Models\M_users_tests();
			
			$params = [
				'where' => [
					['a.test_id', $id, 'AND']
				],
				'order' => [['open', 'desc']]
			];
			$data = $mUsersTests->efektif($params);
			$array_score = [];
			$array_dimension = [];
			
			foreach($data['rows'] as $key => $value){
				$answers = json_decode($value['answers']);
				$mAnswer = new \App\Models\M_answers();
				
				$data['rows'][$key]['scoring'] = 0;

				foreach ($answers as $a => $b) {
					$skor = $mAnswer->baris($b, ['select' => 'a.id, dimension_id, c.name, point']);
					$point = (int) ($skor ? $skor['point'] : 0);
					
					/* if (!isset($data['rows'][$key]['data_answer'][$skor['dimension_id']])) {
						$data['rows'][$key]['data_answer'][$skor['dimension_id']] = ['detail' => [], 'data_point' => [],'point' => 0];
					} */

					/* array_push($array_dimension, $skor['dimension_id']);
					array_push($data['rows'][$key]['data_answer'][$skor['dimension_id']]['detail'], $skor);
					array_push($data['rows'][$key]['data_answer'][$skor['dimension_id']]['data_point'], $point); */
					
					$data['rows'][$key]['scoring'] += $point;
				}
				
				array_push($array_score, $data['rows'][$key]['scoring']);
			}

			$data['hasil_hitung'] = $this->rumusData($array_score);

			foreach($data['rows'] as $key => $value){
				$z_skor = $this->rumusZ($data['rows'][$key]['scoring'], $data['hasil_hitung']);
				//$data['rows'][$key]['z_scoring'] = $z_skor; 
			}
			return $data['hasil_hitung'];
		}catch(\Exception $e){
			return $e->getMessage();
		}
	}

	public function index($resultID)
	{
		try {
			$id          = decryptUrl($resultID);
			$mUsersTests = new \App\Models\M_users_tests();
			$tes         = $mUsersTests->baris($id);

			$answers = json_decode($tes['answers']);
			$scoring = [];
			$mAnswer = new \App\Models\M_answers();
			foreach ($answers as $key => $value) {
				$scoring[] = ($skor = $mAnswer->baris($value, ['select' => 'dimension_id'])) ? $skor['dimension_id'] : "0";
			}
			$mDimension = new \App\Models\M_dimensions();
			$dimension  = [];
			$narrations = [];
			$scoring    = array_count_values($scoring);
			ksort($scoring, 1);
			foreach ($scoring as $key => $value) {
				$dim = $mDimension->baris($key);
				$dim = (is_null($dim)) ? ['method' => 'X', 'name' => 'Y'] : $dim;
				// $dimension[$dim['method']][$key] = $dim['name'];
				$dimension[$dim['method']][$dim['name']] = $value;	
				
				$mNarrations = new \App\Models\M_Narrations();

				$params = [
					'where' => [
						['a.method_id', $dim['id_method'], 'AND']
					]
				];

				$nar = $mNarrations->efektif($params);

				foreach($nar['rows'] as $value){
					$narrations[$dim['method']] = $value['description'];
				}
			}

			$userDir  = 'uploads/' . $tes['username'] . '/';
			$fileName = 'result-' . $tes['id'] . '.png';
			$qrcode   = $userDir . $fileName;
			if (!file_exists($qrcode)) {
				if(!file_exists($userDir))
					mkdir($userDir, 0777, true);

				$options = new \chillerlan\QRCode\QROptions([
					'version' => 8,
				]);
				$qr_base64 = (new \chillerlan\QRCode\QRCode($options))->render(site_url('result/' . encryptUrl($tes['id'])));
				$dataImg   = explode(',', $qr_base64);
				file_put_contents($userDir . $fileName, base64_decode($dataImg[1]));
			}

			$pdf = new Pdf('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

			$pdf->SetCreator('TITIAN KARIR');
			$pdf->SetAuthor('Titian Indonesia');
			$pdf->SetTitle('Hasil ' . $tes['name'] . ' - Titian Karir');
			$pdf->SetSubject('Hasil ' . $tes['name'] . ' - Titian Karir');

			$data = ['data' => $tes, 'qrcode' => $qrcode];
			$pdf->addPage();
			$pdf->writeHTML(view('pdf/cover', $data), true, false, true, false, '');

			$pdf->SetMargins(10, 20, 10, true);
			$pdf->addPage();
			$pdf->writeHTML(view('pdf/pengantar'), true, false, true, false, '');

			$data = [
				'dimension' => $dimension,
				'scoring' => $scoring,
				'narration' => $narrations
			];
			$pdf->SetMargins(10, 20, 10, true);
			$pdf->addPage();
			$pdf->writeHTML(view('pdf/isi', $data), true, false, true, false, '');

			$this->response->setContentType('application/pdf');
			$pdf->Output('Hasil ' . $tes['name'] . ' - Titian Karir.pdf', 'I');
		} catch (\Exception $e) {
			dd($e->getMessage());
			$this->render('client/error');
		}
	}

	public function finalZscoring($userId)
	{
		echo "<pre>";
		
		$id          = $userId;
		$mUsersTests = new \App\Models\M_users_tests();
		$userTest    = $mUsersTests->baris($id);

		$userTest['point'] = 0;
		$userTest['hasil_hitung'] = $this->z_scoring($userTest['test_id']);

		$answers = json_decode($userTest['answers']);
		$mAnswer = new \App\Models\M_answers();
		
		foreach ($answers as $a => $b) {
			$skor = $mAnswer->baris($b, ['select' => 'a.id, dimension_id, c.name, point']);
			$point = (int) ($skor ? $skor['point'] : 0);
			

			$userTest['point'] += $point;
		}

		$userTest['scoring'] = $this->rumusZ($userTest['point'], $userTest['hasil_hitung']);
		print_r($userTest);
	}
}