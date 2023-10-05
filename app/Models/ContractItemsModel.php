<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractItemsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'layby_contract_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['contract_id','item_id','uom_id','uom_value','qty','rate','discount','discount_type','discount_amount','tax_name','tax_value','currency_amt','item_amount','tax_amount','total_amount'];

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

    public function GetContractItemsData($id) {
            $this->table('layby_contract_items')->select("*");
            $this->where('contract_id',$id);
            return $this->findAll();
    }
}
