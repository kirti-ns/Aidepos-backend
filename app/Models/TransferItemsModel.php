<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferItemsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transfer_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['transfer_id','item_id','inventory_detail_id','manufacture_expiry_date','cost_price','selling_price','inventory_quantity','quantity','created_at','updated_at'];

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

    public function GetTransferItemData($id='')
    {
        $this->select('transfer_items.*,items.sku_barcode,items.item_name,detail.lot_no,detail.dom,detail.expiry_date');
        $this->join('items','items.id = transfer_items.item_id','left');
        $this->join('current_inventory_details detail','transfer_items.inventory_detail_id = detail.id','left');
        $this->where('transfer_id',$id);
        $result =  $this->findAll();
        return $result;
    }
    public function GetTotalQty($id='')
    {
         $this->select('sum(quantity) as qty');
         $this->where('transfer_id',$id);
        $total =  $this->first();
        return $total;
    }
}
