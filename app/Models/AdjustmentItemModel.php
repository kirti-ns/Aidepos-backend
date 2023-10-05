<?php

namespace App\Models;

use CodeIgniter\Model;

class AdjustmentItemModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stock_adjustments_items';
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

      public function GetStockSubItemData($id)
    {
        $this->select('stock_adjustments_items.id,stock_adjustments_items.item_id,stock_adjustments_items.quantity,stock_adjustments_items.cost,items.item_name,stock_adjustments_items.item_per_cost ');
        $this->table('stock_adjustments_items');
        $this->join('items', 'items.id = stock_adjustments_items.item_id');
        $this->where('stock_adjust_id',$id);
        $this->orderBy('stock_adjustments_items.id','DESC');
        return $this->findAll();
    }
}
