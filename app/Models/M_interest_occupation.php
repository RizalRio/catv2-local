<?php

namespace App\Models;

use CodeIgniter\Model;

class M_interest_occupation extends Model
{
	protected $DBGroup    = 'default';
	protected $table      = 'interests_combination';
	protected $primaryKey = 'onetsoc_code';

	protected $kolom       = 'interest, job_zone, onetsoc_code, title, description';
	protected $gabung      = [];
	protected $sama        = [];
	protected $grupSama    = [];
	protected $seperti     = [];
	protected $grupSeperti = [];
	protected $group       = [];
	protected $punya       = [];
	protected $urut        = [
		['title', 'asc']
	];

	protected $theFields = ['interest', 'job_zone', 'onetsoc_code', 'description', 'title'];

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	public function getFilteredInterestsData($likeParams = [])
	{
		$likeCombination = implode('', $likeParams);

		$builder = $this->db->table($this->table);

		// JOIN dengan occupation_data
		$builder->join('occupation_data', 'interests_combination.onetsoc_code = occupation_data.onetsoc_code');

		// LEFT JOIN dengan bright_outlook
		$builder->join('bright_outlook', 'interests_combination.onetsoc_code = bright_outlook.onetsoc_code', 'left');

		// Pilih kolom yang dibutuhkan
		$builder->select('interests_combination.*, occupation_data.description, bright_outlook.categories AS bright_outlook');

		// Filter dengan kondisi LIKE

		if (!empty($likeParams)) {
			foreach ($likeParams as $column => $value) {
				$builder->like('interests_combination.interest', $value);
			}
		}

		// ORDER BY dengan kondisi CASE
		$builder->orderBy("CASE WHEN interests_combination.interest = '$likeCombination' THEN 1 ELSE 2 END", false);
		$builder->orderBy('interests_combination.interest', 'ASC');
		$builder->orderBy('interests_combination.job_zone', 'ASC');

		// Eksekusi query dan ambil hasil
		return $builder->get()->getResultArray();
	}
}
