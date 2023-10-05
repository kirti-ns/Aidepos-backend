<?php

namespace App\Models;

use CodeIgniter\Model;

class TaxesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'taxes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tax_type_id','tax_rate','status'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

   public function getTaxData(){
            $this->select('taxes.id,m.tax_type');
            $this->join('tax_master as m', 'taxes.tax_type_id = m.id');
            $this->where('taxes.status',1);
            $this->orderBy('taxes.id desc');
            return $this->findAll();
    }
    
     public function GetTaxMasterData()
    {
        $this->select('taxes.*,tax_master.tax_type');
        $this->join('tax_master','tax_master.id = taxes.tax_type_id');
        return $this->findAll();
    }
}
