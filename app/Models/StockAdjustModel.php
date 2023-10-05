<?php

namespace App\Models;

use CodeIgniter\Model;

class StockAdjustModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stockadjusts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['store_id','reason','narration'];

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

    public function GetStockData()
    {
       $this->select('stockadjusts.*,stores.store_name,stock_adjustments_reason.reason');
        $this->join('stores', 'stores.id = stockadjusts.store_id');
        $this->join('stock_adjustments_reason', 'stock_adjustments_reason.id = stockadjusts.reason_id');
         $this->orderBy('stockadjusts.id','DESC');
        return $this->findAll();
    }
}
