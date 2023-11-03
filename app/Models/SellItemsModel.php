<?php

namespace App\Models;

use CodeIgniter\Model;

class SellItemsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sell_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['s_o_id','item_id','uom_id','uom_value','qty','rate','discount','discount_type','tax_value','tax_name','item_amount','tax_amount','total_amount','created_at','updated_at'];

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

    public function getSaleItemsByMonths($month,$pos_id)
    { 
        $this->select('sell_items.item_id,items.item_name,sum(sell_items.qty) as total_qty');
        $this->join('items','items.id=sell_items.item_id');
        // $this->join('items_master','items_master.id=items.item_master_id');
        $this->where('month(sell_items.created_at)',$month);
        $this->groupBy('sell_items.item_id');
        $result =  $this->findAll();
         
        return $result;
    }
    public function getSaleItemsByYear($year)
    { 
        $this->select('item_id,item_name,sum(sell_items.qty) as total_qty');
        $this->join('items','items.id=sell_items.item_id');
        $this->where('year(sell_items.created_at)',$year);
        $this->groupBy('item_id');
        $result =  $this->findAll();
       //p($this->getLastQuery());
        return $result;
    }
    public function getSaleItemsByWeek($start_date,$end_date)
    { 
        $this->select('item_id,item_name,sum(sell_items.qty) as total_qty');
        $this->join('items','items.id=sell_items.item_id');
        $this->where('sell_items.created_at >= ',$start_date);
        $this->where('sell_items.created_at <= ',$end_date);
        $this->groupBy('item_id');
        $result =  $this->findAll();
         
        return $result;
    }
}
