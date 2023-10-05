<?php

namespace App\Models;

use CodeIgniter\Model;

class GoodsReturnedModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'goods_returned';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['p_o_id','returned_note','total_tax','sub_total','total_amount','adjustment_value'];

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

    public function GetGoodsReturnedData()
    {
        $this->select('goods_returned.*,suppliers.registered_name,categories.category_name');
        $this->join('suppliers','suppliers.id = goods_returned.supplier_id');
        $this->join('categories','categories.id = goods_returned.category_id','left');
        
        return $this->findAll();
    }
}
