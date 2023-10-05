<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model{
    protected $DBGroup          = 'default';
    protected $table            = 'purchaseorders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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

    
    public function getOrderDataByOrderId($id){
            $this->select('*');
            $this->where('id',$id);
            $result = $this->first();
            
            return $result;
    }
    public function GetPurchaseOrderStatus(){
            $this->select('id,order_number');
            $this->where('order_status',1);
            $this->orWhere('order_status',3);
            $this->orWhere('order_status',4);
            $result = $this->findAll();
            return $result;
    }
    public function GetReceivedOrderStatus($store_id){
            $this->select('id,order_number');
            $this->where('store_id',$store_id);
            $this->whereIn('order_status',[1,4]);
            $result = $this->findAll();
            return $result;
    }
    public function GetPurchaseDataByOrderId($id)
    { 
        $this->select('purchaseorders.*,stores.store_name,suppliers.registered_name as supplier_name,suppliers.address,currency_code');
        $this->join('stores', 'purchaseorders.store_id = stores.id','left');
        $this->join('suppliers', 'purchaseorders.supplier_id = suppliers.id','left');
        $this->join('currencies', 'purchaseorders.currency_id = currencies.id','left');
        // $this->join('categories', 'purchaseorders.category_id = categories.id','left');
        $this->where('purchaseorders.id',$id);
        return $this->first();
    }
   
}
