<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractTransactionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'layby_contract_transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['contract_id','transaction_type','date','payment_type','amount'];

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
        $this->table('layby_contract_transaction');
        $this->where('contract_id',$id);
        $this->where('transaction_type',1);
        return $this->countAll();
    }

    public function GetDepositData($id) {
        $this->table('layby_contract_transaction')->select("*");
        $this->where('contract_id',$id);
        $this->where('transaction_type',1);
        return $this->findAll();
    }

    public function checkContractDepositAmt($id) {
        $this->selectSum('amount');
        $this->where('contract_id',$id);
        $this->where('transaction_type',1);
        return $this->first();
    }

    public function checkContractRefundAmt($id) {
        $this->selectSum('amount');
        $this->where('contract_id',$id);
        $this->where('transaction_type',2);
        return $this->first();
    }
}

