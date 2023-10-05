<?php

namespace App\Models;

use CodeIgniter\Model;

class DirectGoodsReceivedItem extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'direct_goods_received_item';
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

    public function GetReceivedItemsData($id)
    { 
        $this->select('direct_goods_received_item.*,items.item_name,items.item_options');
        $this->join('items','items.id = direct_goods_received_item.item_id');
        $this->where('direct_received_id',$id);
        $result = $this->findAll();
        return $result;
    }
}
