<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractDepositModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'layby_contract_deposit';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['contract_id','deposit_date','deposit_amount'];

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

    public function countDepositData($id) {
        $this->table('layby_contract_deposit');
        $this->where('contract_id',$id);
        return $this->countAll();
    }

    public function GetDepositData($id) {
        $this->table('layby_contract_deposit')->select("*");
        $this->where('contract_id',$id);
        return $this->findAll();
    }
}
