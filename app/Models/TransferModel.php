<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transfer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['supply_store_id','receiver_store_id','category_id','order_number','due_date','submission_date','transfer_number','created_at'];

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

    public function GetReceiverStore($value='')
    {
       
        $this->select('rst.id,rst.store_name as receiver_store');
        $this->join('stores as rst', 'rst.id = transfer.receiver_store_id');
        return $this->findAll();

    }
     public function GetSupplyStore($value='')
    {
       
        $this->select('st.id,st.store_name as supply_store');
        $this->join('stores as st', 'st.id = transfer.supply_store_id');
        return $this->findAll();
    }
}
