<?php

namespace App\Models;

use CodeIgniter\Model;

class M_skills_occupation extends Model
{
	protected $DBGroup    = 'default';
	protected $table      = 'skills';
	protected $primaryKey = 'element_id';

	protected $kolom       = 'oentsoc_code, element_id, domain_source';
	protected $gabung      = [];
	protected $sama        = [];
	protected $grupSama    = [];
	protected $seperti     = [];
	protected $grupSeperti = [];
	protected $group       = [];
	protected $punya       = [];
	protected $urut        = [
		['onetsoc_code', 'asc']
	];

	protected $theFields = ['onetsoc_code', 'element_id', 'domain_source'];

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	public function getSkillsByOnetSocCode($onetsocCode)
	{
		$builder = $this->db->table($this->table);

		// JOIN dengan occupation_data
		$builder->join('occupation_data', 'occupation_data.onetsoc_code = skills.onetsoc_code');

		// JOIN dengan content_model_reference
		$builder->join('content_model_reference', 'skills.element_id = content_model_reference.element_id');

		// Pilih kolom yang dibutuhkan
		$builder->select('content_model_reference.element_name, content_model_reference.description');

		// Tambahkan WHERE untuk onetsoc_code
		$builder->where('occupation_data.onetsoc_code', $onetsocCode);

		// GROUP BY element_name
		$builder->groupBy('content_model_reference.element_name');

		// Eksekusi query dan ambil hasil
		return $builder->get()->getResultArray();
	}
}
