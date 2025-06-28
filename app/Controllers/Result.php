<?php

namespace App\Controllers;

use Mpdf\Mpdf;

use \IM\CI\Controllers\GlobalController;

use Exception;

class Result extends GlobalController
{
	private function _rumusData(array $data)
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

	private function _rumusZ($data, $hasil_hitung)
	{
		if ($hasil_hitung['standarDeviasi'] != 0) {
			$skorZ = ($data - $hasil_hitung['mean']) / $hasil_hitung['standarDeviasi'];
		} else {
			$skorZ = 0;
		}

		return $skorZ;
	}

	private function _rumusT($scoring)
	{
		$skorT = 50 + (10 * $scoring);
		return $skorT;
	}

	private function _kategorisasiT($arrayTScoring)
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

	private function _checkKategorisasi($tScoring, $kategorisasiT)
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

	private function _zScoring($resultID)
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
					$resultRumusData = $this->_rumusData($dataSkor);

					$data['hasil_hitung_dimension'][$skor['dimension_id']]['hasil_rumus'] = $resultRumusData;
					$arrayTScoring = [];
					foreach ($dataSkor as $k => $v) {
						$z_scoring = $this->_rumusZ($v, $resultRumusData);
						$t_scoring = $this->_rumusT($z_scoring);
						$arrayTScoring[$k] = $t_scoring;

						$data['hasil_hitung_dimension'][$skor['dimension_id']]['hasil_perhitungan_data'][$k] = [
							'z_scoring' => $z_scoring
						];
					}

					$kategorisasiT = $this->_kategorisasiT($arrayTScoring);
					$data['hasil_hitung_dimension'][$skor['dimension_id']]['kategorisasi_cek'] = $kategorisasiT;

					foreach ($arrayTScoring as $p => $q) {
						$kategorisasiCek = $this->_checkKategorisasi($q, $kategorisasiT);
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

	private function _loadInitialData($resultID)
	{
		$id = decryptUrl($resultID);
		$mUsersTests = new \App\Models\M_users_tests();
		$scoringData = $mUsersTests->baris($id);

		if (!$scoringData) {
			return null;
		}

		// Inisialisasi array-array yang akan diisi nanti
		$scoringData['scoring'] = [];
		$scoringData['methodCheck'] = [];
		$scoringData['dimCheck'] = [];
		$scoringData['interestCheck'] = [];

		return $scoringData;
	}

	private function _calculateAllScores($scoringData)
	{
		$mQuestions = new \App\Models\M_questions();
		$mAnswer = new \App\Models\M_answers();
		$mDevelopment = new \App\Models\M_development_recommendations();
		$mInterest = new \App\Models\M_interest_occupation();

		$answers = json_decode($scoringData['answers']);
		$questionId = explode(',', $scoringData['question']);

		foreach ($questionId as $key => $value) {
			$questionUser = $mQuestions->baris($value);
			if (!in_array($questionUser['method'], $scoringData['methodCheck'])) {
				array_push($scoringData['methodCheck'], $questionUser['method']);
			}
		}

		if (array_intersect(["RIASEC", "Self Efficacy", "Minat Karir", "Kesiapan Kerja", "Self Efficacy SMP-SMA", "Kompetensi", "Kepribadian"], $scoringData['methodCheck'])) {
			// Loop utama untuk skoring per jawaban
			foreach ($answers as $a => $b) {
				$userAnswers = $mAnswer->baris($b, ['select' => 'a.id, dimension_id, c.name dimension, d.name method, point']);
				$answersMethod = $userAnswers['method'];
				$answersDimension = $userAnswers['dimension'];

				if ($answersMethod == "RIASEC" || $answersMethod == "Minat Karir") {
					if (!isset($scoringData['scoring'][$answersMethod]['data'][$answersDimension])) {
						$scoringData['scoring'][$answersMethod]['data'][$answersDimension] = ['point' => [], 'total' => 0, 'percentage' => 0];
					}
					array_push($scoringData['dimCheck'], $answersDimension);
					array_push($scoringData['scoring'][$answersMethod]['data'][$answersDimension]['point'], $userAnswers['point']);
					$scoringData['scoring'][$answersMethod]['data'][$answersDimension]['total'] += $userAnswers['point'];
					$total = $scoringData['scoring'][$answersMethod]['data'][$answersDimension]['total'];
					$scoringData['scoring'][$answersMethod]['data'][$answersDimension]['percentage'] = round(($total / count($scoringData['scoring'][$answersMethod]['data'][$answersDimension]['point'])) * 100);
				} elseif (in_array($answersMethod, ["Self Efficacy", "Kesiapan Kerja", "Self Efficacy SMP-SMA", "Kompetensi", "Kepribadian"])) {
					if (!isset($scoringData['scoring'][$answersMethod]['data'][$answersDimension])) {
						$scoringData['scoring'][$answersMethod]['data'][$answersDimension] = ['point' => [], 'total_point' => 0, 'value' => 0, 'percentage' => 0, 'max_point' => 0];
					}
					array_push($scoringData['scoring'][$answersMethod]['data'][$answersDimension]['point'], $userAnswers['point']);
					$scoringData['scoring'][$answersMethod]['data'][$answersDimension]['total_point'] += $userAnswers['point'];
					$total_point = $scoringData['scoring'][$answersMethod]['data'][$answersDimension]['total_point'];
					$countAnswer = count($scoringData['scoring'][$answersMethod]['data'][$answersDimension]['point']);
					$scoringData['scoring'][$answersMethod]['data'][$answersDimension]['value'] = $total_point / $countAnswer;
					$scoringData['scoring'][$answersMethod]['data'][$answersDimension]['max_point'] = $countAnswer * 5;
					$scoringData['scoring'][$answersMethod]['data'][$answersDimension]['percentage'] = round(($total_point / $scoringData['scoring'][$answersMethod]['data'][$answersDimension]['max_point']) * 100);

					if (!isset($scoringData['scoring'][$answersMethod]['global'])) {
						$scoringData['scoring'][$answersMethod]['global'] = ['total_point' => 0, 'total_questions' => 0, 'average' => 0, 'percentage' => 0, 'max_point' => 0];
					}
					$scoringData['scoring'][$answersMethod]['global']['total_point'] += $userAnswers['point'];
					$scoringData['scoring'][$answersMethod]['global']['total_questions']++;
				}
			}

			// Loop untuk proses setelah skoring (rata-rata global, sort, rekomendasi)
			foreach ($scoringData['methodCheck'] as $method) {
				if (in_array($method, ["Self Efficacy", "Kesiapan Kerja", "Self Efficacy SMP-SMA", "Kompetensi"])) {
					if (isset($scoringData['scoring'][$method]['global']) && $scoringData['scoring'][$method]['global']['total_questions'] > 0) {
						$global = &$scoringData['scoring'][$method]['global'];
						$global['average'] = $global['total_point'] / $global['total_questions'];
						$global['max_point'] = ($global['total_questions'] * 5);
						$global['percentage'] = round(($global['total_point'] / $global['max_point']) * 100);
					}
				}
				if (in_array($method, ["Minat Karir", "Kesiapan Kerja", "Kompetensi"])) {
					foreach ($scoringData['dimCheck'] as $dimension) {
						if (isset($scoringData['scoring'][$method])) {
							uksort($scoringData['scoring'][$method]['data'], function ($key1, $key2) use ($scoringData, $method) {
								return $scoringData['scoring'][$method]['data'][$key2]['percentage'] <=> $scoringData['scoring'][$method]['data'][$key1]['percentage'];
							});
						}
					}
					if ($method == "Minat Karir") {
						$scoringData['interestCheck'] = array_slice(array_keys(array_filter($scoringData['scoring'][$method]['data'], function ($key) {
							return in_array($key, ['R', 'I', 'A', 'S', 'E', 'C']);
						}, ARRAY_FILTER_USE_KEY)), 0, 3);
						$scoringData['scoring'][$method]['development'] = [];
						$scoringData['scoring'][$method]['dominan'] = $scoringData['interestCheck'];
						foreach ($scoringData['scoring'][$method]['dominan'] as $value) {
							array_push($scoringData['scoring'][$method]['development'], $mDevelopment->where('key', $value)->first());
						}
						$scoringData['scoring'][$method]['carrer_possibility'] = $mInterest->getFilteredInterestsData($scoringData['interestCheck']);
					} else if ($method == "Kesiapan Kerja") {
						$scoringData['scoring'][$method]['recommendation'] = [];
						foreach ($scoringData['scoring'][$method]['data'] as $key => $value) {
							if ($value['percentage'] > 66.67) $level = 'Tinggi';
							elseif ($value['percentage'] > 33.33) $level = 'Sedang';
							else $level = 'Rendah';
							array_push($scoringData['scoring'][$method]['recommendation'], $mDevelopment->where('key', $key)->where('level', $level)->first());
						}
					}
				}
			}
		}

		return $scoringData;
	}

	private function _getSupportingDetails($scoringData)
	{
		$mDimension = new \App\Models\M_dimensions();
		$mNarrations = new \App\Models\M_Narrations();
		$mAnswer = new \App\Models\M_answers();

		$answers = json_decode($scoringData['answers']);
		$dataDimension = [];
		foreach ($answers as $key => $value) {
			$skor = $mAnswer->baris($value, ['select' => 'dimension_id']);
			$dataDimension[] = $skor ? $skor['dimension_id'] : "0";
		}

		$dataDimension = array_count_values($dataDimension);
		ksort($dataDimension, 1);

		$dimensionDetails = [];
		$narrations = [];
		foreach ($dataDimension as $key => $value) {
			$dim = $mDimension->baris($key);
			$dim = (is_null($dim)) ? ['method' => 'X', 'name' => 'Y'] : $dim;
			$dimensionDetails[$dim['method']][$dim['name']] = $value;

			$nar = $mNarrations->efektif(['where' => [['a.method_id', $dim['id_method'], 'AND']]])['rows'];
			foreach ($nar as $nar_value) {
				$narrations[$dim['method']] = $nar_value['description'];
			}
		}

		$scoringData['dimension_details'] = $dimensionDetails;
		$scoringData['narrations'] = $narrations;

		return $scoringData;
	}

	private function _generatePdfReport($scoringData)
	{
		$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
		$dateTest = date_format(date_create($scoringData['start']), "d-m-Y");
		$pdfName = 'Hasil Tes ' . $dateTest . ' - ' . $scoringData['username'] . '.pdf';
		$mpdf->SetTitle($pdfName);

		$cover = view('pdf/description_result/description_result', $scoringData);
		$mpdf->WriteHTML($cover);

		if (isset($scoringData['methodCheck']) && (in_array("RIASEC", $scoringData['methodCheck']) || in_array("Self Efficacy", $scoringData['methodCheck']) || in_array("Minat Karir", $scoringData['methodCheck']) || in_array("Kesiapan Kerja", $scoringData['methodCheck']))) {
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('pdf/description_result/description_result_1', $scoringData));
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('pdf/description_result/description_result_2', $scoringData));
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('pdf/description_result/description_result_3', $scoringData));
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('pdf/description_result/description_result_4', $scoringData));
		} else {
			// Blok ini sepertinya untuk jenis tes yang berbeda / fallback
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('result_pdf/description_result'));
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('result_pdf/riasec_result'));
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('result_pdf/carrer_result'));
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('result_pdf/kepribadian_result'));
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('result_pdf/kepribadian2_result'));
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('result_pdf/kepribadian3_result'));
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('result_pdf/end_result'));
		}

		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output($pdfName, 'I');
	}

	public function index($resultID)
	{
		try {
			// Langkah 1: Siapkan semua data mentah dari database
			$scoringData = $this->_loadInitialData($resultID);
			if (is_null($scoringData)) {
				throw new Exception("Data tes dengan ID tersebut tidak ditemukan.");
			}

			// Langkah 2: Lakukan semua perhitungan skor utama
			$scoringData = $this->_calculateAllScores($scoringData);

			// NOTE: Bagian ini sepertinya alternatif scoring, kita pisah juga
			// Jika tidak ada method scoring utama, jalankan finalScoring
			if (empty($scoringData['methodCheck'])) {
				$scoringData = $this->finalScoring($scoringData['id']);
			}

			// Langkah 3: Ambil detail & narasi pendukung
			$scoringData = $this->_getSupportingDetails($scoringData);

			echo "<pre>";
			print_r($scoringData);
			die();
			// Langkah 4: Buat dan tampilkan laporan PDF
			// Tidak ada 'return' karena fungsi Output() langsung mengirim response ke browser
			$this->_generatePdfReport($scoringData);
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

		$hasil_hitung_dimensions = $this->_zScoring($userTest['test_id']);

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
