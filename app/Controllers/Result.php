<?php

namespace App\Controllers;

use Mpdf\Mpdf;

use \IM\CI\Controllers\GlobalController;

use Exception;

class Result extends GlobalController
{
	private function rumusData(array $data)
	{
		try {
			$jumlahData = count($data);
			$jumlahNilai = array_sum($data);
			$mean = $jumlahNilai / $jumlahData;

			$variansi = 0;
			foreach ($data as $nilai) {
				$variansi += pow(($nilai - $mean), 2);
			}

			if ($jumlahData <= 1) {
				$result = [
					'jumlahData' => $jumlahData,
					'jumlahNilai' => $jumlahNilai,
					'mean'	=> $mean,
					'standarDeviasi' => $mean,
					'message' => 'Jumlah data hanya 1'
				];

				return $result;
			}

			$newVariansi = $variansi / ($jumlahData);
			$standarDeviasi = sqrt($newVariansi);

			$result = [
				'jumlahData' => $jumlahData,
				'jumlahNilai' => $jumlahNilai,
				'mean'	=> $mean,
				'standarDeviasi' => $standarDeviasi
			];

			return $result;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	private function rumusZ($data, $hasil_hitung)
	{
		$skorZ = ($data - $hasil_hitung['mean']) / $hasil_hitung['standarDeviasi'];

		return $skorZ;
	}

	private function rumusT($scoring)
	{
		$skorT = 50 + (10 * $scoring);
		return $skorT;
	}

	private function kategorisasiT($arrayTScoring)
	{
		$XMin = min($arrayTScoring);
		$XMax = max($arrayTScoring);
		$mean = ($XMax + $XMin) / 2;
		$sd = ($XMax - $XMin) / 6;
		$data = [
			'XMin' => $XMin,
			'XMax' => $XMax,
			'mean' => $mean,
			'sd' => $sd
		];

		return $data;
	}

	private function checkKategorisasi($tScoring, $kategorisasiT)
	{
		$sr = $kategorisasiT['mean'] - (1.5 * $kategorisasiT['sd']);
		$r = $kategorisasiT['mean'] - (0.5 * $kategorisasiT['sd']);
		$t = $kategorisasiT['mean'] + (0.5 * $kategorisasiT['sd']);
		$st = $kategorisasiT['mean'] + (1.5 * $kategorisasiT['sd']);

		if ($tScoring <= $sr) {
			$result = "Sangat Rendah";
		} elseif ($tScoring > $sr && $tScoring <= $r) {
			$result = "Rendah";
		} elseif ($tScoring > $r && $tScoring <= $t) {
			$result = "Sedang";
		} elseif ($tScoring > $t && $tScoring <= $st) {
			$result = "Tinggi";
		} elseif ($tScoring > $st) {
			$result = "Sangat Tinggi";
		}

		return $result;
	}

	private function z_scoring($resultID)
	{
		try {
			$id = $resultID;
			$mUsersTests = new \App\Models\M_users_tests();

			$params = [
				'where' => [
					['a.test_id', $id, 'AND']
				],
				'order' => [['open', 'desc']]
			];
			$data = $mUsersTests->efektif($params);

			foreach ($data['rows'] as $key => $value) {
				$answers = json_decode($value['answers']);
				$mAnswer = new \App\Models\M_answers();

				$pointScoring = 0;

				//! COBA DATA POINT PER DIMENSION USER BUKAN PER POIN SOAL
				foreach ($answers as $a => $b) {
					$skor = $mAnswer->baris($b, ['select' => 'a.id, dimension_id, c.name, point']);
					$point = (int) ($skor ? $skor['point'] : 0);

					if (!isset($data['rows'][$key]['data_answer'][$skor['dimension_id']])) {
						$data['rows'][$key]['data_answer'][$skor['dimension_id']] = ['data_point' => [], 'point' => 0];
					}

					array_push($data['rows'][$key]['data_answer'][$skor['dimension_id']]['data_point'], $point);
					$data['rows'][$key]['data_answer'][$skor['dimension_id']]['point'] += $point;
					$pointScoring += $point;

					if (!isset($data['hasil_hitung_dimension'][$skor['dimension_id']])) {
						$data['hasil_hitung_dimension'][$skor['dimension_id']] = ['user_point' => []];
					}

					if (!isset($data['hasil_hitung_dimension'][$skor['dimension_id']]['user_point'][$value['user_id']])) {
						$data['hasil_hitung_dimension'][$skor['dimension_id']]['user_point'][$value['user_id']]  = 0;
					}


					$data['hasil_hitung_dimension'][$skor['dimension_id']]['user_point'][$value['user_id']] += $point;
				}
			}

			foreach ($data['rows'] as $key => $value) {
				$answers = json_decode($value['answers']);
				$mAnswer = new \App\Models\M_answers();



				foreach ($answers as $a => $b) {
					$skor = $mAnswer->baris($b, ['select' => 'a.id, dimension_id, c.name, point']);

					$dataSkor = $data['hasil_hitung_dimension'][$skor['dimension_id']]['user_point'];
					$resultRumusData = $this->rumusData($dataSkor);

					$data['hasil_hitung_dimension'][$skor['dimension_id']]['hasil_rumus'] = $resultRumusData;
					$arrayTScoring = [];
					foreach ($dataSkor as $k => $v) {
						$z_scoring = $this->rumusZ($v, $resultRumusData);
						$t_scoring = $this->rumusT($z_scoring);
						$arrayTScoring[$k] = $t_scoring;

						$data['hasil_hitung_dimension'][$skor['dimension_id']]['hasil_perhitungan_data'][$k] = [
							'z_scoring' => $z_scoring
						];
					}

					$kategorisasiT = $this->kategorisasiT($arrayTScoring);
					$data['hasil_hitung_dimension'][$skor['dimension_id']]['kategorisasi_cek'] = $kategorisasiT;

					foreach ($arrayTScoring as $p => $q) {
						$kategorisasiCek = $this->checkKategorisasi($q, $kategorisasiT);
						$data['hasil_hitung_dimension'][$skor['dimension_id']]['hasil_perhitungan_data'][$p] += [
							't_scoring' => $q,
							'kategorisasi_t' => $kategorisasiCek
						];
					}
				}
			}
			return $data['hasil_hitung_dimension'];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function index($resultID)
	{
		try {
			echo "<pre>";
			$id          = decryptUrl($resultID);
			
			$mUsersTests = new \App\Models\M_users_tests();
			$mQuestions = new \App\Models\M_questions();
			$mAnswer = new \App\Models\M_answers();
			
			$tes         = $mUsersTests->baris($id);
			
			$scoring = [];
			$methodCheck = [];
			$questionId = explode(',', $tes['question']); 
			$answers = json_decode($tes['answers']);
			
			foreach($questionId as $key => $value) {
				$questionUser = $mQuestions->baris($value);
				(!in_array($questionUser['method'], $methodCheck)) ? array_push($methodCheck, $questionUser['method']) : ''; 
				
			}

			if(in_array("RIASEC", $methodCheck) || in_array("Self Efficacy", $methodCheck)){
				foreach ($answers as $a => $b) {
					$userAnswers = $mAnswer->baris($b, ['select' => 'a.id, dimension_id, c.name dimension, d.name method, point']);
					$answersMethod = $userAnswers['method'];
					$answersDimension = $userAnswers['dimension'];

					if($answersMethod == "RIASEC") {
						if (!isset($scoring[$answersMethod][$answersDimension])) {
							$scoring[$answersMethod][$answersDimension] = ['point' => [], 'total' => 0];
						}
						array_push($scoring[$answersMethod][$answersDimension]['point'], $userAnswers['point']);
						$scoring[$answersMethod][$answersDimension]['total'] += $userAnswers['point'];
					} elseif($answersMethod == "Self Efficacy") { 
						 if (!isset($scoring[$answersMethod][$answersDimension])) {
							$scoring[$answersMethod][$answersDimension] = ['point' => [], 'total_point' => 0, 'value' => 0];
						}
						array_push($scoring[$answersMethod][$answersDimension]['point'], $userAnswers['point']);
						$scoring[$answersMethod][$answersDimension]['total_point'] += $userAnswers['point'];
						$total_point = $scoring[$answersMethod][$answersDimension]['total_point'];
						$countAnswer = count($scoring[$answersMethod][$answersDimension]['point']);
						$scoring[$answersMethod][$answersDimension]['value'] = $total_point/$countAnswer;
					}
				}

				print_r($scoring);
			} else {
				$scoringData = $this->finalScoring($id);
				$answers = json_decode($scoringData['answers']);
			}

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

				foreach ($nar['rows'] as $value) {
					$narrations[$dim['method']] = $value['description'];
				}
			}

			$userDir  = 'uploads/' . $scoringData['username'] . '/';
			$fileName = 'result-' . $scoringData['id'] . '.png';
			$qrcode   = $userDir . $fileName;
			if (!file_exists($qrcode)) {
				if (!file_exists($userDir))
					mkdir($userDir, 0777, true);

				$options = new \chillerlan\QRCode\QROptions([
					'version' => 8,
				]);
				$qr_base64 = (new \chillerlan\QRCode\QRCode($options))->render(site_url('result/' . encryptUrl($tes['id'])));
				$dataImg   = explode(',', $qr_base64);
				file_put_contents($userDir . $fileName, base64_decode($dataImg[1]));
			}
			$dateTest = date_create($scoringData['start']);
			$dateTest = date_format($dateTest, "d-m-Y");

			$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);

			//DIBAGI PER DIMENSION DIAMBIL DARI HASIL DATA HASIL

			$header = view('result_pdf/header_result', $scoringData);
			$footer = view('result_pdf/footer_result');

			$cover = view('result_pdf/cover_result', $scoringData);
			$description = view('result_pdf/description_result');
			$riasec = view('result_pdf/riasec_result');
			$carrer = view('result_pdf/carrer_result');
			$kepribadian1 = view('result_pdf/kepribadian_result');
			$kepribadian2 = view('result_pdf/kepribadian2_result');
			$kepribadian3 = view('result_pdf/kepribadian3_result');
			$end = view('result_pdf/end_result');

			$pdfName = 'Hasil Tes ' . $dateTest . ' - ' . $scoringData['username'] . '.pdf';

			$mpdf->SetTitle($pdfName);

			$mpdf->SetHTMLHeader($header);
			$mpdf->SetHTMLFooter($footer);
			$mpdf->WriteHTML($cover);
			$mpdf->AddPage();
			$mpdf->WriteHTML($description);
			$mpdf->AddPage();
			$mpdf->WriteHTML($riasec);
			$mpdf->AddPage();
			$mpdf->WriteHTML($carrer);
			$mpdf->AddPage();
			$mpdf->WriteHTML($kepribadian1);
			$mpdf->AddPage();
			$mpdf->WriteHTML($kepribadian2);
			$mpdf->AddPage();
			$mpdf->WriteHTML($kepribadian3);
			$mpdf->AddPage();
			$mpdf->WriteHTML($end);

			$this->response->setHeader('Content-Type', 'application/pdf');

			$mpdf->Output($pdfName, 'I');
		} catch (\Exception $e) {
			dd($e->getMessage());
			$this->render('client/error');
		}
	}

	public function finalScoring($userId)
	{
		$id          = $userId;
		$mUsersTests = new \App\Models\M_users_tests();
		$userTest    = $mUsersTests->baris($id);

		if (empty($userTest)) {
			return 'User belum melakukan test';
		}
		
		$hasil_hitung_dimensions = $this->z_scoring($userTest['test_id']);
		
		$answers = json_decode($userTest['answers']);
		$mAnswer = new \App\Models\M_answers();
		
		foreach ($answers as $a => $b) {
			$skor = $mAnswer->baris($b, ['select' => 'a.id, dimension_id, c.name, point']);
			$point = (int) ($skor ? $skor['point'] : 0);
			$dimension = $skor['dimension_id'];

			if (!isset($userTest['point'][$dimension])) {
				$userTest['point'][$dimension] = ['total_point' => 0, 'detail_point' => []];
			}

			array_push($userTest['point'][$dimension]['detail_point'], $skor['point']);
			$userTest['point'][$dimension]['total_point'] += $point;
			$userTest['point'][$dimension]['point_result'] = $hasil_hitung_dimensions[$dimension]['hasil_perhitungan_data'][$userTest['user_id']];
		}
		return $userTest;
	}
}
