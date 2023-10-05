<?php

namespace App\Models;

use CodeIgniter\Model;

class BackOrderModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'back_order';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['customer_id','currency_id','supplier_id','category_id','order_number','due_date'];

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

    public function GetBackOrderData()
    {
        $this->select('back_order.*,suppliers.registered_name,categories.category_name,currencies.exchange_rate');
        $this->join('suppliers','suppliers.id = back_order.supplier_id');
        $this->join('categories','categories.id = back_order.category_id','left');
        $this->join('currencies','currencies.id = back_order.currency_id','left');
        return $this->findAll();
    }
}
