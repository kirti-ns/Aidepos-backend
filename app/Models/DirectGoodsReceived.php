<?php

namespace App\Models;

use CodeIgniter\Model;

class DirectGoodsReceived extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'direct_goods_received';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

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

    public function getGoodsReceivedDataById($id)
    {
        $this->select('direct_goods_received.*,suppliers.registered_name as supplier_name,location.location_description,stores.store_name');
        $this->join('suppliers','direct_goods_received.supplier_id = suppliers.id');
        $this->join('location','direct_goods_received.location_id = location.id');
        $this->join('stores','direct_goods_received.store_id = stores.id');
        return $this->first();
    }
}
