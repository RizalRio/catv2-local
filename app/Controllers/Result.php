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
		if ($hasil_hitung['standarDeviasi'] != 0) {
			$skorZ = ($data - $hasil_hitung['mean']) / $hasil_hitung['standarDeviasi'];
		} else {
			$skorZ = 0;
		}

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
			$id          = decryptUrl($resultID);

			$mUsersTests = new \App\Models\M_users_tests();
			$mQuestions = new \App\Models\M_questions();
			$mAnswer = new \App\Models\M_answers();
			$mCarrer = new \App\Models\M_carrer_possibility();
			$mDevelopment = new \App\Models\M_development_recommendations();
			$mInterest = new \App\Models\M_interest_occupation();
			$mSkills = new \App\Models\M_skills_occupation();

			$scoringData         = $mUsersTests->baris($id);

			$scoring = [];
			$methodCheck = [];
			$dimCheck = [];
			$interestCheck = [];
			$questionId = explode(',', $scoringData['question']);
			$answers = json_decode($scoringData['answers']);

			foreach ($questionId as $key => $value) {
				$questionUser = $mQuestions->baris($value);
				(!in_array($questionUser['method'], $methodCheck)) ? array_push($methodCheck, $questionUser['method']) : '';
			}

			if (array_intersect(["RIASEC", "Self Efficacy", "Minat Karir", "Kesiapan Kerja"], $methodCheck)) {
				foreach ($answers as $a => $b) {
					$userAnswers = $mAnswer->baris($b, ['select' => 'a.id, dimension_id, c.name dimension, d.name method, point']);
					$answersMethod = $userAnswers['method'];
					$answersDimension = $userAnswers['dimension'];

					if ($answersMethod == "RIASEC" || $answersMethod == "Minat Karir") {
						if (!isset($scoring[$answersMethod]['data'][$answersDimension])) {
							$scoring[$answersMethod]['data'][$answersDimension] = ['point' => [], 'total' => 0, 'percentage' => 0];
						}
						array_push($dimCheck, $answersDimension);
						array_push($scoring[$answersMethod]['data'][$answersDimension]['point'], $userAnswers['point']);

						$scoring[$answersMethod]['data'][$answersDimension]['total'] += $userAnswers['point'];

						$total = $scoring[$answersMethod]['data'][$answersDimension]['total'];

						$scoring[$answersMethod]['data'][$answersDimension]['percentage'] = round(($total / count($scoring[$answersMethod]['data'][$answersDimension]['point'])) * 100);
					} elseif ($answersMethod == "Self Efficacy" || $answersMethod == "Kesiapan Kerja") {
						if (!isset($scoring[$answersMethod]['data'][$answersDimension])) {
							$scoring[$answersMethod]['data'][$answersDimension] = ['point' => [], 'total_point' => 0, 'value' => 0, 'percentage' => 0, 'max_point' => 0];
						}
						array_push($scoring[$answersMethod]['data'][$answersDimension]['point'], $userAnswers['point']);
						$scoring[$answersMethod]['data'][$answersDimension]['total_point'] += $userAnswers['point'];

						$total_point = $scoring[$answersMethod]['data'][$answersDimension]['total_point'];
						$countAnswer = count($scoring[$answersMethod]['data'][$answersDimension]['point']);

						$scoring[$answersMethod]['data'][$answersDimension]['value'] = $total_point / $countAnswer;
						$scoring[$answersMethod]['data'][$answersDimension]['max_point'] = $countAnswer * 5;
						$scoring[$answersMethod]['data'][$answersDimension]['percentage'] = round(($total_point / $scoring[$answersMethod]['data'][$answersDimension]['max_point']) * 100);

						if (!isset($scoring[$answersMethod]['global'])) {
							$scoring[$answersMethod]['global'] = [
								'total_point' => 0,
								'total_questions' => 0,
								'average' => 0,
								'percentage' => 0,
								'max_point' => 0
							];
						}

						$scoring[$answersMethod]['global']['total_point'] += $userAnswers['point'];
						$scoring[$answersMethod]['global']['total_questions']++;
					}
				}
				foreach ($methodCheck as $method) {
					if (in_array($method, ["Self Efficacy", "Kesiapan Kerja"])) {
						if (isset($scoring[$method]['global']) && $scoring[$method]['global']['total_questions'] > 0) {
							$scoring[$method]['global']['average'] = $scoring[$method]['global']['total_point'] / $scoring[$method]['global']['total_questions'];
							$scoring[$method]['global']['max_point'] = ($scoring[$method]['global']['total_questions'] * 5);
							$scoring[$method]['global']['percentage'] = round(($scoring[$method]['global']['total_point'] / $scoring[$method]['global']['max_point']) * 100);
						}
					}

					if (in_array($method, ["Minat Karir", "Kesiapan Kerja"])) {
						foreach ($dimCheck as $dimension) {
							if ($scoring[$method]) {
								uksort($scoring[$method]['data'], function ($key1, $key2) use ($scoring, $method) {
									return $scoring[$method]['data'][$key2]['percentage'] <=> $scoring[$method]['data'][$key1]['percentage'];
								});
							}
						}

						if ($method == "Minat Karir") {
							$interestCheck = array_slice(
								array_keys(
									array_filter(
										$scoring[$method]['data'],
										function ($key) {
											return in_array($key, ['R', 'I', 'A', 'S', 'E', 'C']);
										},
										ARRAY_FILTER_USE_KEY
									)
								),
								0,
								3
							);
							$scoring[$method]['development'] = [];
							$scoring[$method]['dominan'] = $interestCheck;

							foreach ($scoring[$method]['dominan'] as $value) {
								$developmentRecommend = $mDevelopment->where('key', $value)->first();
								array_push($scoring[$method]['development'], $developmentRecommend);
							}

							$carrerPossibility = $mInterest->getFilteredInterestsData($interestCheck);
							$scoring[$method]['carrer_possibility']	= $carrerPossibility;

							//mengambil rekomendasi function dengan skill yang dibutuhkan per occupation  

							/* foreach ($carrerPossibility as $column => $value) {
								$occupationSkills = $mSkills->getSkillsByOnetSocCode($value['onetsoc_code']);
								$scoring[$method]['carrer_possibility'][$column]['skills'] = $occupationSkills;
							}

							$stringInterest = implode('', $interestCheck);
							$recommendation = $mCarrer->baris($stringInterest);
							$scoring[$method]['carrer_possibility'] =  explode(',', $recommendation['carrer_possibility']); */
						} else if ($method == "Kesiapan Kerja") {
							//mengambil rekomendasi pengembangan skill

							$scoring[$method]['recommendation'] = $recommendationPriority = [];
							$level = null;
							foreach ($scoring[$method]['data'] as $key => $value) {
								if ($value['percentage'] > 66.67) {
									$level = 'Tinggi';
								} elseif ($value['percentage'] > 33.33) {
									$level = 'Sedang';
								} else {
									$level = 'Rendah';
								}

								$recommendationPriority = $mDevelopment->where('key', $key)->where('level', $level)->first();
								array_push($scoring[$method]['recommendation'], $recommendationPriority);
							}
						}
					}
				}

				foreach ($answers as $key => $value) {
					$dataDimension[] = ($skor = $mAnswer->baris($value, ['select' => 'dimension_id'])) ? $skor['dimension_id'] : "0";
				}

				$scoringData['scoring'] = $scoring;
			} else {
				$scoringData = $this->finalScoring($id);

				$answers = json_decode($scoringData['answers']);

				foreach ($answers as $key => $value) {
					$dataDimension[] = ($skor = $mAnswer->baris($value, ['select' => 'dimension_id'])) ? $skor['dimension_id'] : "0";
				}
			}

			$mDimension = new \App\Models\M_dimensions();
			$dimension  = [];
			$narrations = [];
			$dataDimension    = array_count_values($dataDimension);
			ksort($dataDimension, 1);
			foreach ($dataDimension as $key => $value) {
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

			$dateTest = date_create($scoringData['start']);
			$dateTest = date_format($dateTest, "d-m-Y");

			$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);

			//DIBAGI PER DIMENSION DIAMBIL DARI HASIL DATA HASIL
			$cover = view('pdf/description_result/description_result', $scoringData);

			if (in_array("RIASEC", $methodCheck) || in_array("Self Efficacy", $methodCheck) || in_array("Minat Karir", $methodCheck) || in_array("Kesiapan Kerja", $methodCheck)) {
				$descriptionKarir1 = view('pdf/description_result/description_result_1', $scoringData);
				$descriptionKarir2 = view('pdf/description_result/description_result_2', $scoringData);
				$descriptionKarir3 = view('pdf/description_result/description_result_3', $scoringData);
				$descriptionKarir4 = view('pdf/description_result/description_result_4', $scoringData);
			} else {
				$description = view('result_pdf/description_result');
				$riasec = view('result_pdf/riasec_result');
				$carrer = view('result_pdf/carrer_result');
				$kepribadian1 = view('result_pdf/kepribadian_result');
				$kepribadian2 = view('result_pdf/kepribadian2_result');
				$kepribadian3 = view('result_pdf/kepribadian3_result');
				$end = view('result_pdf/end_result');
			}

			$pdfName = 'Hasil Tes ' . $dateTest . ' - ' . $scoringData['username'] . '.pdf';

			$mpdf->SetTitle($pdfName);
			$mpdf->WriteHTML($cover);

			if (in_array("RIASEC", $methodCheck) || in_array("Self Efficacy", $methodCheck) || in_array("Minat Karir", $methodCheck) || in_array("Kesiapan Kerja", $methodCheck)) {
				$mpdf->AddPage();
				$mpdf->WriteHTML($descriptionKarir1);
				$mpdf->AddPage();
				$mpdf->WriteHTML($descriptionKarir2);
				$mpdf->AddPage();
				$mpdf->WriteHTML($descriptionKarir3);
				$mpdf->AddPage();
				$mpdf->WriteHTML($descriptionKarir4);
			} else {
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
			}

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
