<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['item_type','item_master_id','sku_barcode','barcode','supply_price','markup','mrp','retail_price','current_inventory','inventory_value','re_order_point','minimum_retail_price','category_id','subcategory_id','uom_id','tax_id','purchase_tax_id','brand_id','modifier_id','status_type','item_description','item_options'];

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

    public function GetItemData()
    {
      $this->table('items')->select('items.*,uom_master.uom,categories.category_name,subcategories.subcategory_name,tax_master.tax_type,stock_adjustments_items.cost');
           $this->join('uom_master', 'uom_master.id = items.uom_id','left');
           $this->join('categories', 'categories.id = items.category_id','left');
           $this->join('subcategories', 'subcategories.id = items.subcategory_id','left');
           $this->join('taxes', 'taxes.id = items.tax_id','left');
           $this->join('tax_master', 'tax_master.id = taxes.tax_type_id','left');
           $this->join('stock_adjustments_items', 'stock_adjustments_items.item_id = items.id','left');
           return $this->findAll();
    }
    public function GetItemsByBrandId($id) {
        $this->table('items')->select('items.*,items_price.supply_price,items_price.retail_price,items_price.current_inventory,items_price.inventory_value,uom_master.uom,categories.category_name,subcategories.subcategory_name,tax_master.tax_type');
        $this->join('items_price', 'items.id = items_price.items_id','left');
        $this->join('uom_master', 'uom_master.id = items.uom_id','left');
        $this->join('categories', 'categories.id = items.category_id','left');
        $this->join('subcategories', 'subcategories.id = items.subcategory_id','left');
        $this->join('taxes', 'taxes.id = items.tax_id','left');
        $this->join('tax_master', 'tax_master.id = taxes.tax_type_id','left');
        $this->where('brand_id',$id);
        return $this->findAll();
    }
    
    public function getItemStock($id,$store_id=''){
            $this->table('items')->select('p.retail_price,p.current_inventory');
            $this->join('items_price p','p.items_id = items.id');
            $this->where('items.id',$id);
            $this->where('p.store_id',$store_id);
            $result = $this->first();
            $returnObj = [
              'price' => $result['retail_price'],
              'stock' => $result['current_inventory']
            ];
            // = isset($result['current_inventory'])?$result['current_inventory']:"0";
            return $returnObj;
    }
    public function GetItemDataByCategoryId($id,$pos_id='')
    {
      $this->table('items')->select('items.id,items.item_name');
      if($pos_id != '') {
        $this->where('pos_id',$pos_id);
      }
      $this->where('category_id',$id);
      return $this->findAll();  
    }
    public function getCanPurchaseItems($pos_id){
        $array = [];
        $this->table('items')->select('items.id, items.item_name, items.item_type');
        // $this->join('items_price p','items.id = p.items_id');
        $this->whereIn('items.item_type',[1,3]);
        $this->like('item_options','%"can_purchase":1%');
        if($pos_id != '') {
          $this->where('items.pos_id',$pos_id);
        }
        // $this->groupBy('items.id');
        // $this->where('items.status',1);

        $items = $this->findAll();
        $array = $items;
        $variant = $this->table('items')->select('items.id, items.item_name')->where('item_type',2)->like('item_options','%"can_purchase":1%')->findAll();
        foreach($variant as $k => $v) {
            $variant_items = $this->table('items')->select('items.id, items.item_name')->where('item_type',4)->where('item_master_id',$v['id'])->findAll();
            array_push($array, ...$variant_items);
        }
        return $array;
    }
    public function getCanPurchaseItem($pos_id,$txt){

        $this->table('items')->select('items.id, items.item_name, items.item_type');
        $this->like('item_options','%"can_purchase":1%');
        $this->whereIn('items.item_type',[1,3,4]);
        $this->where("(item_name LIKE '%".$txt."%' OR barcode LIKE '%".$txt."%')");
        // $this->like('item_name','%'.$txt)->orLike('barcode','%'.$txt);
        if($pos_id != '') {
          $this->where('items.pos_id',$pos_id);
        }

        return $this->findAll();
    }
    public function getCanSaleItems($pos_id, $txt = ''){
        $this->table('items')->select('items.id, items.item_name, items.item_type');
        // $this->join('items_price p','items.id = p.items_id');
        $this->like('item_options','%"can_sale":1%');
        if($txt != '') {
            $this->whereIn('items.item_type',[1,3,4]);
            $this->like('item_name','%'.$txt)->orLike('barcode','%'.$txt);
        } else {
            $this->whereIn('items.item_type',[1,3]);
        }
        if($pos_id != '') {
          $this->where('items.pos_id',$pos_id);
        }
        // $this->groupBy('items.id');
        // $this->where('items.status',1);
        $items = $this->findAll();
        $array = $items;
        if($txt == '') {
            $variant = $this->table('items')->select('items.id, items.item_name')->where('item_type',2)->like('item_options','%"can_sale":1%')->findAll();
            foreach($variant as $k => $v) {
                $variant_items = $this->table('items')->select('items.id, items.item_name')->where('item_type',4)->where('item_master_id',$v['id'])->findAll();
                array_push($array, ...$variant_items);
            }
        }
        return $array;
    }
    public function getIsIngredientItems($pos_id){
        $this->table('items')->select('items.id, p.id as pr_id, items.item_name, items.item_type');
        $this->join('items_price p','items.id = p.items_id');
        $this->like('item_options','%"is_ingredient":1%');
        if($pos_id != '') {
          $this->where('items.pos_id',$pos_id);
        }
        $this->groupBy('items.id');
        // $this->where('items.status',1);

        return $this->findAll();
    }
    public function getPreProductionItems($pos_id){
        $this->table('items')->select('items.id, p.id as pr_id, items.item_name, items.item_type');
        $this->join('items_price p','items.id = p.items_id');
        $this->like('item_options','%"pre_production":1%');
        if($pos_id != '') {
          $this->where('items.pos_id',$pos_id);
        }
        $this->groupBy('items.id');
        // $this->where('items.status',1);

        return $this->findAll();
    }
    public function getItemList($pos_id){
        $this->table('items')->select('items.id, p.id as pr_id, items.item_name, items.item_type');
        $this->join('items_price p','items.id = p.items_id');
        if($pos_id != '') {
          $this->where('items.pos_id',$pos_id);
        }
        $this->groupBy('items.id');
        $this->where('items.status',1);

        return $this->findAll();
    }
    public function getItemListAllStatus($pos_id){
        $this->table('items')->select('items.id, p.id as pr_id, items.item_name, items.item_type');
        $this->join('items_price p','items.id = p.items_id');
        $this->groupBy('items.id');
        if($pos_id != '') {
          $this->where('items.pos_id',$pos_id);
        }
        return $this->findAll();
    }
    public function getItemDataById($pos_id,$id){
        $this->table('items')->select('items.id, items.item_name, items.item_type');
        $this->whereIn('id',$id);
        if($pos_id != '') {
          $this->where('items.pos_id',$pos_id);
        }
        return $this->findAll();
    }
}