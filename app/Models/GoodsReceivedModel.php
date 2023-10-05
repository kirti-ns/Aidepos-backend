<?php

namespace App\Models;

use CodeIgniter\Model;

class GoodsReceivedModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'goods_received';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['store_id','location_id','supplier_id','p_o_id','due_date','status','total_tax','sub_total','received_note','date'];

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

    public function GetGoodsReceivedData()
    {
        $this->select('goods_received.*,suppliers.registered_name');
        $this->join('suppliers','suppliers.id = goods_received.supplier_id');
        return $this->findAll();
    }
    public function getGoodsReceivedDataById($id='')
    {
        $this->select('goods_received.*,purchaseorders.is_include_tax,purchaseorders.order_number,purchaseorders.store_id,purchaseorders.supplier_id,purchaseorders.due_date,purchaseorders.terms,currencies.currency_code,purchaseorders.currency_rate,stores.store_name,suppliers.registered_name as supplier_name,location.location_description');
        $this->join('purchaseorders','purchaseorders.id = goods_received.p_o_id');
        $this->join('currencies','purchaseorders.currency_id = currencies.id','left');
        $this->join('stores', 'purchaseorders.store_id = stores.id','left');
        $this->join('location', 'goods_received.location_id = location.id','left');
        $this->join('suppliers', 'purchaseorders.supplier_id = suppliers.id','left');
        $this->where('goods_received.id',$id);
        return $this->first();
    }

}
