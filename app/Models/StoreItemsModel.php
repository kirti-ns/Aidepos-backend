<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\ItemModel;

class StoreItemsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'store_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["store_id","location_id","item_id","open_qty","open_value","received_qty","received_value","return_qty","return_value","adjustment_qty","adjustment_value","production_qty","production_value","transfer_qty","transfer_value","rejected_qty","rejected_value"];

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
    
    public function getStoreItems($item_id, $store_id, $location_id)
    {
      $this->table('store_items')->select('*');
      $this->where('item_id',$item_id);
      $this->where('store_id',$store_id);
      $this->where('location_id',$location_id);
      $this->where("DATE_FORMAT(created_at,'%Y-%m-%d') =",date('Y-m-d'));
      $result = $this->first();

      return $result;
    }
    public function receivedItem($data,$lot_data = [])
    {
      $result = $this->getStoreItems($data['item_id'],$data['store_id'],$data['location_id']);

      $itemModel = new ItemModel();
      $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);
      $stock =  (int) $itemObj['stock'];
      $price =  (int) $itemObj['price'];


      if(empty($result)) {
          $close_qty = $stock + $data['qty'];

          $add_data = [
            'open_qty' => $stock,
            'open_value' => $stock * $price,
            'item_id' => $data['item_id'],
            'store_id' => $data['store_id'],
            'location_id' => $data['location_id'],
            'received_qty' => $data['qty'],
            'received_value' => $data['qty'] * $price,
            'close_qty' =>  $close_qty,
            'close_value' => $close_qty * $price
          ];

          $this->db->table('store_items')->insert($add_data);
          $query =  $this->db->insertID();

          $locationQty = $data['qty'];
          //Checking in current_inventory table    
          $invtQuery = $this->db->table('current_inventory')->where('pos_id',$data['pos_id'])->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
          $invtRow = $invtQuery->getRow();
          $invtID = "";

          if(!empty($invtRow)) {
            $invtID = $invtRow->id;
            $locationQty = isset($invtRow->quantity)?$locationQty + $invtRow->quantity:$locationQty;
            $updateCurrInventory = [
              'quantity'=>$locationQty
            ];
            $this->db->table('current_inventory')->where('id',$invtRow->id)
            ->set($updateCurrInventory)
            ->update();

            //Checking in current_inventory_details table
            $detailQuery = $this->db->table('current_inventory_details')->where('current_inventory_id',$invtRow->id)->where('p_o_id',$lot_data['p_o_id'])->where('p_item_id',$lot_data['p_item_id'])->get();
            $detailRow = $detailQuery->getRow();
            if(!empty($detailRow)) {

              $updateInvtDetails = [
                'qty'=>$data['qty'],
                'lot_no'=>$lot_data['lot_no'],
                'dom'=>$lot_data['dom'],
                'expiry_date'=>$lot_data['expiry_date']
              ];
              $this->db->table('current_inventory_details')->where('id',$detailRow->id)
              ->set($updateInvtDetails)
              ->update();

            } else {
              $lot_add_data = array(
                'pos_id'=>$data['pos_id'],
                'p_o_id'=>$lot_data['p_o_id'],
                'p_item_id'=>$lot_data['p_item_id'],
                'current_inventory_id'=>$invtID,
                'qty'=>$data['qty'],
                'lot_no'=>$lot_data['lot_no'],
                'dom'=>$lot_data['dom'],
                'expiry_date'=>$lot_data['expiry_date']
              );
              $this->db->table('current_inventory_details')->insert($lot_add_data);
            }
          } else {
            $invt_data = array(
              'pos_id'=>$data['pos_id'],
              'item_id'=>$data['item_id'],
              'store_id'=>$data['store_id'],
              'location_id'=>$data['location_id'],
              'quantity'=>$locationQty
            );
            $this->db->table('current_inventory')->insert($invt_data);
            $invtID = $this->db->insertID();

            if($data['type'] == "received" && !empty($lot_data)) {
              $lot_add_data = array(
                'pos_id'=>$data['pos_id'],
                'p_o_id'=>$lot_data['p_o_id'],
                'p_item_id'=>$lot_data['p_item_id'],
                'current_inventory_id'=>$invtID,
                'qty'=>$lot_data['qty'],
                'lot_no'=>$lot_data['lot_no'],
                'dom'=>$lot_data['dom'],
                'expiry_date'=>$lot_data['expiry_date'],
              );
              $this->db->table('current_inventory_details')->insert($lot_add_data);
            }
          }

          $updateStock = array('current_inventory'=>$add_data['close_qty']);
          $updateStockValue = array('inventory_value'=>$price*$close_qty);
          $this->db->table('items_price')->where('store_id',$data['store_id'])->where('items_id',$data['item_id'])
            ->set($updateStock)
            ->set($updateStockValue)
            ->update();

          /*if(!empty($query)){
            $this->getUpdateCloseQty($close_qty,$query);
          }*/

          return $query;
      } else {
        $add_data = [
          'item_id' => $data['item_id'],
          'store_id' => $data['store_id'],
          'received_qty' => $result['received_qty'] + $data['qty'],
          'received_value' => ($result['received_qty'] + $data['qty']) * $price
        ];

        $this->db
          ->table('store_items')
          ->where(["id" => $result['id']])
          ->set($add_data)
          ->update();

        $this->table('store_items')->select('*');
        $this->where(["id" => $result['id']]);
        $result = $this->first();

        $locationQty = $data['qty'];
            
        $invtQuery = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
        $invtRow = $invtQuery->getRow();
        if(!empty($invtRow)) {
          $invtID = $invtRow->id;
          $locationQty = isset($invtRow->quantity)?abs($locationQty + $invtRow->quantity):$locationQty;
          $updateCurrInventory = [
            'quantity'=>$locationQty
          ];
          $this->db->table('current_inventory')->where('id',$invtRow->id)
          ->set($updateCurrInventory)
          ->update();

          //Checking in current_inventory_details table
          $detailQuery = $this->db->table('current_inventory_details')->where('current_inventory_id',$invtRow->id)->where('p_o_id',$lot_data['p_o_id'])->where('p_item_id',$lot_data['p_item_id'])->get();
          $detailRow = $detailQuery->getRow();
          if(!empty($detailRow)) {

            $updateInvtDetails = [
              'qty'=>$data['qty'],
              'lot_no'=>$lot_data['lot_no'],
              'dom'=>$lot_data['dom'],
              'expiry_date'=>$lot_data['expiry_date']
            ];
            $this->db->table('current_inventory_details')->where('id',$detailRow->id)
            ->set($updateInvtDetails)
            ->update();

          } else {
            $lot_add_data = array(
              'pos_id'=>$data['pos_id'],
              'p_o_id'=>$lot_data['p_o_id'],
              'p_item_id'=>$lot_data['p_item_id'],
              'current_inventory_id'=>$invtID,
              'qty'=>$data['qty'],
              'lot_no'=>$lot_data['lot_no'],
              'dom'=>$lot_data['dom'],
              'expiry_date'=>$lot_data['expiry_date']
            );
            $this->db->table('current_inventory_details')->insert($lot_add_data);
          }
        }  

        $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
        $add_qty = $result['open_qty'] + $result['received_qty'];
        $close_qty = ($add_qty) - ($remove_qty);
            
        $close_value = $close_qty * $price;
        $updateStock = array('current_inventory'=>$close_qty);
        $updateStockValue = array('inventory_value'=>$price*$close_qty);
        $this->db->table('items_price')->where('store_id',$data['store_id'])->where('items_id',$data['item_id'])
            ->set($updateStock)
            ->set($updateStockValue)
            ->update();
            
        $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);

        return true;   
      }
    }
    public function directReceivedItem($data,$lot_data = [])
    {
      $result = $this->getStoreItems($data['item_id'],$data['store_id'],$data['location_id']);

      $itemModel = new ItemModel();
      $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);
      $stock =  (int) $itemObj['stock'];
      $price =  (int) $itemObj['price'];


      if(empty($result)) {
          $close_qty = $stock + $data['qty'];

          $add_data = [
            'open_qty' => $stock,
            'open_value' => $stock * $price,
            'item_id' => $data['item_id'],
            'store_id' => $data['store_id'],
            'location_id' => $data['location_id'],
            'received_qty' => $data['qty'],
            'received_value' => $data['qty'] * $price,
            'close_qty' =>  $close_qty,
            'close_value' => $close_qty * $price
          ];

          $this->db->table('store_items')->insert($add_data);
          $query =  $this->db->insertID();

          $locationQty = $data['qty'];
          //Checking in current_inventory table    
          $invtQuery = $this->db->table('current_inventory')->where('pos_id',$data['pos_id'])->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
          $invtRow = $invtQuery->getRow();
          $invtID = "";

          if(!empty($invtRow)) {
            $invtID = $invtRow->id;
            $locationQty = isset($invtRow->quantity)?$locationQty + $invtRow->quantity:$locationQty;
            $updateCurrInventory = [
              'quantity'=>$locationQty
            ];
            $this->db->table('current_inventory')->where('id',$invtRow->id)
            ->set($updateCurrInventory)
            ->update();

            //Adding in current_inventory_details table
              $lot_add_data = array(
                'pos_id'=>$data['pos_id'],
                'current_inventory_id'=>$invtID,
                'qty'=>$data['qty'],
                'lot_no'=>$lot_data['lot_no'],
                'dom'=>$lot_data['dom'],
                'expiry_date'=>$lot_data['expiry_date']
              );
              $this->db->table('current_inventory_details')->insert($lot_add_data);
            
          } else {
            $invt_data = array(
              'pos_id'=>$data['pos_id'],
              'item_id'=>$data['item_id'],
              'store_id'=>$data['store_id'],
              'location_id'=>$data['location_id'],
              'quantity'=>$locationQty
            );
            $this->db->table('current_inventory')->insert($invt_data);
            $invtID = $this->db->insertID();

            if($data['type'] == "received" && !empty($lot_data)) {
              $lot_add_data = array(
                'pos_id'=>$data['pos_id'],
                'current_inventory_id'=>$invtID,
                'qty'=>$lot_data['qty'],
                'lot_no'=>$lot_data['lot_no'],
                'dom'=>$lot_data['dom'],
                'expiry_date'=>$lot_data['expiry_date'],
              );
              $this->db->table('current_inventory_details')->insert($lot_add_data);
            }
          }

          $updateStock = array('current_inventory'=>$add_data['close_qty']);
          $updateStockValue = array('inventory_value'=>$price*$close_qty);
          $this->db->table('items_price')->where('store_id',$data['store_id'])->where('items_id',$data['item_id'])
            ->set($updateStock)
            ->set($updateStockValue)
            ->update();

          /*if(!empty($query)){
            $this->getUpdateCloseQty($close_qty,$query);
          }*/

          return $query;
      } else {
        $add_data = [
          'item_id' => $data['item_id'],
          'store_id' => $data['store_id'],
          'received_qty' => $result['received_qty'] + $data['qty'],
          'received_value' => ($result['received_qty'] + $data['qty']) * $price
        ];

        $this->db
          ->table('store_items')
          ->where(["id" => $result['id']])
          ->set($add_data)
          ->update();

        $this->table('store_items')->select('*');
        $this->where(["id" => $result['id']]);
        $result = $this->first();

        $locationQty = $data['qty'];
            
        $invtQuery = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
        $invtRow = $invtQuery->getRow();
        if(!empty($invtRow)) {
          $invtID = $invtRow->id;
          $locationQty = isset($invtRow->quantity)?abs($locationQty + $invtRow->quantity):$locationQty;
          $updateCurrInventory = [
            'quantity'=>$locationQty
          ];
          $this->db->table('current_inventory')->where('id',$invtRow->id)
          ->set($updateCurrInventory)
          ->update();

            $lot_add_data = array(
              'pos_id'=>$data['pos_id'],
              'current_inventory_id'=>$invtID,
              'qty'=>$data['qty'],
              'lot_no'=>$lot_data['lot_no'],
              'dom'=>$lot_data['dom'],
              'expiry_date'=>$lot_data['expiry_date']
            );
            $this->db->table('current_inventory_details')->insert($lot_add_data);
          
        }  

        $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
        $add_qty = $result['open_qty'] + $result['received_qty'];
        $close_qty = ($add_qty) - ($remove_qty);
            
        $close_value = $close_qty * $price;
        $updateStock = array('current_inventory'=>$close_qty);
        $updateStockValue = array('inventory_value'=>$price*$close_qty);
        $this->db->table('items_price')->where('store_id',$data['store_id'])->where('items_id',$data['item_id'])
            ->set($updateStock)
            ->set($updateStockValue)
            ->update();
            
        $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);

        return true;   
      }
    }
    public function returnedItem($data,$lot_data = [])
    {
        $result = $this->getStoreItems($data['item_id'],$data['store_id'],$data['location_id']);

        $itemModel = new ItemModel();
        $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);
        $stock =  (int) $itemObj['stock'];
        $price =  (int) $itemObj['price'];


        if(empty($result)) {
            $close_qty = $stock > 0 ? $stock - $data['qty'] : 0;
            $add_data = [
              'open_qty' => $stock,
              'open_value' => $stock * $price,   
              'item_id' => $data['item_id'],
              'store_id' => $data['store_id'],
              'location_id' => $data['location_id'],
              'return_qty' => $data['qty'],
              'return_value' => $data['qty'] * $price,
              'close_qty' => $close_qty,
              'close_value' => $close_qty * $price
            ];

            $this->db->table('store_items')->insert($add_data);
            $query =  $this->db->insertID();

            $invtQuery = $this->db->table('current_inventory')->where('pos_id',$data['pos_id'])->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
            $invtRow = $invtQuery->getRow();
            $locationQty = $data['qty'];

            if(!empty($invtRow)) {
              $invtID = $invtRow->id;
              $locationQty = isset($invtRow->quantity)?abs($locationQty - $invtRow->quantity):$locationQty;
              $updateCurrInventory = [
                'quantity'=>$locationQty
              ];
              $this->db->table('current_inventory')->where('id',$invtRow->id)
              ->set($updateCurrInventory)
              ->update();

              //Checking in current_inventory_details table
              $detailQuery = $this->db->table('current_inventory_details')->where('current_inventory_id',$invtRow->id)->where('p_o_id',$lot_data['p_o_id'])->where('p_item_id',$lot_data['p_item_id'])->get();
              $detailRow = $detailQuery->getRow();
              if(!empty($detailRow)) {

                $updateInvtDetails = [
                  'qty'=>$data['qty']
                ];
                $this->db->table('current_inventory_details')->where('id',$detailRow->id)
                ->set($updateInvtDetails)
                ->update();
              }
            }  
        } else {
            $add_data = [
              'item_id' => $data['item_id'],
              'store_id' => $data['store_id'],
              'return_qty' => $result['return_qty'] + $data['qty'],
              'return_value' => ($result['return_qty'] + $data['qty']) * $price
            ];

            $this->db
                ->table('store_items')
                ->where(["id" => $result['id']])
                ->set($add_data)
                ->update();

            $this->table('store_items')->select('*');
            $this->where(["id" => $result['id']]);
            $result = $this->first();

            $locationQty = $data['qty'];

            $invtQuery = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
            $invtRow = $invtQuery->getRow();
            if(!empty($invtRow)) {

              $locationQty = isset($invtRow->quantity)?abs($locationQty - $invtRow->quantity):$locationQty;
              
              $updateCurrInventory = [
                'quantity'=>$locationQty
              ];
              $this->db->table('current_inventory')->where('id',$invtRow->id)
              ->set($updateCurrInventory)
              ->update();

              $detailQuery = $this->db->table('current_inventory_details')->where('current_inventory_id',$invtRow->id)->where('p_o_id',$lot_data['p_o_id'])->where('p_item_id',$lot_data['p_item_id'])->get();
              $detailRow = $detailQuery->getRow();
              if(!empty($detailRow)) {

                $updateInvtDetails = [
                  'qty'=>$lot_data['qty']
                ];
                $this->db->table('current_inventory_details')->where('id',$detailRow->id)
                ->set($updateInvtDetails)
                ->update();
              }
            }  

            $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
            $add_qty = $result['open_qty'] + $result['received_qty'];
            $close_qty = ($add_qty) - ($remove_qty);
            
            $close_value = $close_qty * $price;
            $updateStock = array('current_inventory'=>$close_qty);
            $updateStockValue = array('inventory_value'=>$price*$close_qty);
            $this->db->table('items_price')->where('store_id',$data['store_id'])->where('items_id',$data['item_id'])
                ->set($updateStock)
                ->set($updateStockValue)
                ->update();
                
            $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);
            
            return true;  
        }
    }
    public function supplyTransfer($data)
    {
        $result = $this->getStoreItems($data['item_id'],$data['store_id'],$data['location_id']);

        $itemModel = new ItemModel();
        $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);
        // $stock =  (int) $itemObj['stock'];
        $price =  (int) $itemObj['price'];

        $invtQuery = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
        $invtRow = $invtQuery->getRow();

        $stock = isset($invtRow->quantity)?$invtRow->quantity:0;

        if(empty($result)) {
          $close_qty = $stock > 0 ? $stock - $data['qty'] : $data['qty'];
          $add_data = [
            'open_qty' => $stock,
            'open_value' => $stock * $price,   
            'item_id' => $data['item_id'],
            'location_id'=>$data['location_id'],
            'store_id' => $data['store_id'],
            'transfer_qty' => $data['qty'],
            'transfer_value' => $data['qty'] * $price,
            'close_qty' => $close_qty,
            'close_value' => $close_qty * $price
          ];

          $this->db->table('store_items')->insert($add_data);
          $query =  $this->db->insertID();

          $locationQty = $data['qty'];
          $invtID = $invtRow->id;
          $locationQty = isset($invtRow->quantity)?$invtRow->quantity - $locationQty:$locationQty;
          $updateCurrInventory = [
            'quantity'=>$locationQty
          ];
          $this->db->table('current_inventory')->where('id',$invtRow->id)
          ->set($updateCurrInventory)
          ->update();

          $detailQuery = $this->db->table('current_inventory_details')->where('id',$data['invt_detail_id'])->get();
          $detailRow = $detailQuery->getRow();

          $detailQty = $detailRow->qty - $data['qty'];

          $updateLot = array('qty'=>$detailQty);
          $this->db->table('current_inventory_details')->where('id',$data['invt_detail_id'])
            ->set($updateLot)
            ->update();

          $updateStock = array('current_inventory'=>$add_data['close_qty']);
          $updateStockValue = array('inventory_value'=>$price*$close_qty);
          $this->db->table('items_price')->where('store_id',$data['store_id'])->where('items_id',$data['item_id'])
            ->set($updateStock)
            ->set($updateStockValue)
            ->update();

          return $query;

        } else {
          $add_data = [
            'item_id' => $data['item_id'],
            'store_id' => $data['store_id'],
            'transfer_qty' => $result['transfer_qty'] + $data['qty'],
            'transfer_value' => ($result['transfer_qty'] + $data['qty']) * $price
          ];

          $this->db
                ->table('store_items')
                ->where(["id" => $result['id']])
                ->set($add_data)
                ->update();

            $this->table('store_items')->select('*');
            $this->where(["id" => $result['id']]);
            $result = $this->first();
            $locationQty = $data['qty'];
            $locationQty = isset($invtRow->quantity)?abs($locationQty - $invtRow->quantity):$locationQty;
            $updateCurrInventory = [
              'quantity'=>$locationQty
            ];

            $this->db->table('current_inventory')->where('id',$invtRow->id)
            ->set($updateCurrInventory)
            ->update();
            
            $detailQuery = $this->db->table('current_inventory_details')->where('id',$data['invt_detail_id'])->get();
            $detailRow = $detailQuery->getRow();

            $detailQty = $detailRow->qty - $data['qty'];

            $updateLot = array('qty'=>$detailQty);
            $this->db->table('current_inventory_details')->where('id',$data['invt_detail_id'])
              ->set($updateLot)
              ->update();

            $qPrice = $this->db->table('items_price')->where('items_id',$data['item_id'])->where('store_id',$data['store_id'])->get();
            $qPriceRes = $qPrice->getRow();

            $qStoreQty = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->selectSum('quantity')->get();
            $qStoreQtyRes = $qStoreQty->getRow();

            $uPriceData = [
                'current_inventory'=>$qStoreQtyRes->quantity,
                'inventory_value'=>$qStoreQtyRes->quantity*$qPriceRes->retail_price
            ];
            $this->db->table('items_price')->where('id',$qPriceRes->id)->set($uPriceData)->update();

            $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
            $add_qty = $result['open_qty'] + $result['received_qty'];
            $close_qty = ($add_qty) - ($remove_qty);
            
            $close_value = $close_qty * $price;
                
            $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);

            return true;   
        }
    }
    public function receiveTransfer($data)
    {
        $result = $this->getStoreItems($data['item_id'],$data['store_id'],$data['location_id']);

        $itemModel = new ItemModel();
        $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);

        // $stock =  (int) $itemObj['stock'];
        $price =  (int) $itemObj['price'];

        $invtQuery = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
        $invtRow = $invtQuery->getRow();

        $stock = isset($invtRow->quantity)?$invtRow->quantity:$data['qty'];

        if(empty($result)) {
          $close_qty = $stock > 0 ? $stock + $data['qty'] : $data['qty'];
          $add_data = [
            'open_qty' => $stock,
            'open_value' => $stock * $price,   
            'item_id' => $data['item_id'],
            'location_id'=>$data['location_id'],
            'store_id' => $data['store_id'],
            'received_qty' => $data['qty'],
            'received_value' => $data['qty'] * $price,
            'close_qty' => $close_qty,
            'close_value' => $close_qty * $price
          ];

          $this->db->table('store_items')->insert($add_data);
          $query =  $this->db->insertID();

          $locationQty = $data['qty'];

          $invtID = $invtRow->id;
          $locationQty = isset($invtRow->quantity)?$locationQty + $invtRow->quantity:$locationQty;
          $updateCurrInventory = [
            'quantity'=>$locationQty
          ];
          $this->db->table('current_inventory')->where('id',$invtRow->id)
          ->set($updateCurrInventory)
          ->update();

          $detailQuery = $this->db->table('current_inventory_details')->where('id',$data['invt_detail_id'])->get();
          $detailRow = $detailQuery->getRow();

          $detail_data = [
            'pos_id'=>$invtRow->pos_id,
            'current_inventory_id'=>$invtID,
            'qty'=>$data['qty'],
            'lot_no'=>$detailRow->lot_no,
            'dom'=>$detailRow->dom,
            'expiry_date'=>$detailRow->expiry_date
          ];

          $this->db->table('current_inventory_details')->insert($detail_data);

          $updateStock = array('current_inventory'=>$add_data['close_qty']);
          $updateStockValue = array('inventory_value'=>$price*$close_qty);
          $this->db->table('items_price')->where('store_id',$data['store_id'])->where('items_id',$data['item_id'])
            ->set($updateStock)
            ->set($updateStockValue)
            ->update();

          return $query;

        } else {
          $add_data = [
            'item_id' => $data['item_id'],
            'store_id' => $data['store_id'],
            'received_qty' => $result['received_qty'] + $data['qty'],
            'received_value' => ($result['received_qty'] + $data['qty']) * $price
          ];

          $this->db
                ->table('store_items')
                ->where(["id" => $result['id']])
                ->set($add_data)
                ->update();

          $this->table('store_items')->select('*');
          $this->where(["id" => $result['id']]);
          $result = $this->first();
          $locationQty = $data['qty'];
          $locationQty = isset($invtRow->quantity)?abs($locationQty + $invtRow->quantity):$locationQty;
          $updateCurrInventory = [
            'quantity'=>$locationQty
          ];

          $this->db->table('current_inventory')->where('id',$invtRow->id)
          ->set($updateCurrInventory)
          ->update();

          $detailQuery = $this->db->table('current_inventory_details')->where('id',$data['invt_detail_id'])->get();
          $detailRow = $detailQuery->getRow();

          $detail_data = [
            'pos_id'=>$invtRow->pos_id,
            'current_inventory_id'=>$invtRow->id,
            'qty'=>$data['qty'],
            'lot_no'=>$detailRow->lot_no,
            'dom'=>$detailRow->dom,
            'expiry_date'=>$detailRow->expiry_date
          ];

          $this->db->table('current_inventory_details')->insert($detail_data);
            
          $qPrice = $this->db->table('items_price')->where('items_id',$data['item_id'])->where('store_id',$data['store_id'])->get();
          $qPriceRes = $qPrice->getRow();

          $qStoreQty = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->selectSum('quantity')->get();
          $qStoreQtyRes = $qStoreQty->getRow();

          $uPriceData = [
              'current_inventory'=>$qStoreQtyRes->quantity,
              'inventory_value'=>$qStoreQtyRes->quantity*$qPriceRes->retail_price
          ];
          $this->db->table('items_price')->where('id',$qPriceRes->id)->set($uPriceData)->update();

            $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
            $add_qty = $result['open_qty'] + $result['received_qty'];
            $close_qty = ($add_qty) - ($remove_qty);
            $close_value = $close_qty * $price;
                
            $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);

            return true;
        }
    }
    public function soldItem($data)
    {
        $result = $this->getStoreItems($data['item_id'],$data['store_id'],$data['location_id']);

        $itemModel = new ItemModel();
        $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);
        // $stock =  (int) $itemObj['stock'];
        $price =  (int) $itemObj['price'];

        $invtQuery = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
        $invtRow = $invtQuery->getRow();
        $stock = isset($invtRow->quantity)?$invtRow->quantity:0;

        if(empty($result)) {
          $close_qty = $stock > 0 ? $stock - $data['qty'] : $data['qty'];
          $add_data = [
            'open_qty' => $stock,
            'open_value' => $stock * $price,   
            'item_id' => $data['item_id'],
            'location_id'=>$data['location_id'],
            'store_id' => $data['store_id'],
            'sold_qty' => $data['qty'],
            'sold_value' => $data['qty'] * $price,
            'close_qty' => $close_qty,
            'close_value' => $close_qty * $price
          ];

          $this->db->table('store_items')->insert($add_data);
          $query =  $this->db->insertID();

          $invtID = "";

          if(!empty($invtRow)) {
            $invtID = $invtRow->id;

            $deduct = $this->deductStock($data['item_id'], $data['qty'],$invtID);
            if ($deduct) {

              $qDetail = $this->db->table('current_inventory_details')->where('current_inventory_id',$invtID)->selectSum('qty')->get();
              $qDetailRes = $qDetail->getRow();

              $uQty = ['quantity'=>$qDetailRes->qty];
              $this->db->table('current_inventory')->where('id',$invtID)->set($uQty)->update();

              $qStoreQty = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->selectSum('quantity')->get();
              $qStoreQtyRes = $qStoreQty->getRow();

              $qPrice = $this->db->table('items_price')->where('items_id',$data['item_id'])->where('store_id',$data['store_id'])->get();
              $qPriceRes = $qPrice->getRow();

              $uPriceData = [
                  'current_inventory'=>$qStoreQtyRes->quantity,
                  'inventory_value'=>$qStoreQtyRes->quantity*$qPriceRes->retail_price
              ];
              $this->db->table('items_price')->where('id',$qPriceRes->id)->set($uPriceData)->update();
               
            } else {
            //     // Insufficient stock or other error; handle accordingly
                return json_encode([
                    "status" => "false",
                    "message" => "Sale failed due to insufficient stock.",
                ]);
            }
          }

        } else {

          $add_data = [
            'item_id' => $data['item_id'],
            'store_id' => $data['store_id'],
            'sold_qty' => $result['sold_qty']  +  $data['qty'],
            'sold_value' => ($result['sold_qty']  +  $data['qty']) * $price
          ];

          $this->db
                ->table('store_items')
                ->where(["id" => $result['id']])
                ->set($add_data)
                ->update();

          $this->table('store_items')->select('*');
          $this->where(["id" => $result['id']]);
          $result = $this->first();

          if(!empty($invtRow)) {
            $invtID = $invtRow->id;

            $deduct = $this->deductStock($data['item_id'], $data['qty'],$invtID);
            if ($deduct) {

              $qDetail = $this->db->table('current_inventory_details')->where('current_inventory_id',$invtID)->selectSum('qty')->get();
              $qDetailRes = $qDetail->getRow();

              $uQty = ['quantity'=>$qDetailRes->qty];
              $this->db->table('current_inventory')->where('id',$invtID)->set($uQty)->update();

              $qStoreQty = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->selectSum('quantity')->get();
              $qStoreQtyRes = $qStoreQty->getRow();

              $qPrice = $this->db->table('items_price')->where('items_id',$data['item_id'])->where('store_id',$data['store_id'])->get();
              $qPriceRes = $qPrice->getRow();

              $uPriceData = [
                  'current_inventory'=>$qStoreQtyRes->quantity,
                  'inventory_value'=>$qStoreQtyRes->quantity*$qPriceRes->retail_price
              ];
              $this->db->table('items_price')->where('id',$qPriceRes->id)->set($uPriceData)->update();
               
            } else {
            //     // Insufficient stock or other error; handle accordingly
                return json_encode([
                    "status" => "false",
                    "message" => "Sale failed due to insufficient stock.",
                ]);
            }
          }

            $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
            $add_qty = $result['open_qty'] + $result['received_qty'];
            $close_qty = ($add_qty) - ($remove_qty);
            
            $close_value = $close_qty * $price;
            
            $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);
            return true;
        }
    }
    public function laybyItemStock($data)
    {
        $result = $this->getStoreItems($data['item_id'],$data['store_id'],$data['location_id']);

        $itemModel = new ItemModel();
        $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);
        // $stock =  (int) $itemObj['stock'];
        $price =  (int) $itemObj['price'];

        $invtQuery = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
        $invtRow = $invtQuery->getRow();
        $stock = isset($invtRow->quantity)?$invtRow->quantity:0;

        if(empty($result)) {
          $close_qty = $stock > 0 ? $stock - $data['qty'] : $data['qty'];
          $add_data = [
            'open_qty' => $stock,
            'open_value' => $stock * $price,   
            'item_id' => $data['item_id'],
            'location_id'=>$data['location_id'],
            'store_id' => $data['store_id'],
            'sold_qty' => $data['qty'],
            'sold_value' => $data['qty'] * $price,
            'close_qty' => $close_qty,
            'close_value' => $close_qty * $price
          ];

          $this->db->table('store_items')->insert($add_data);
          $query =  $this->db->insertID();

          $invtID = "";

          if(!empty($invtRow)) {
            $invtID = $invtRow->id;

            $deduct = $this->deductLaybyStock($data['item_id'], $data['store_id'], $data['qty'],$invtID);
            if ($deduct) {

              $qDetail = $this->db->table('current_inventory_details')->where('current_inventory_id',$invtID)->selectSum('qty')->get();
              $qDetailRes = $qDetail->getRow();

              $uQty = ['quantity'=>$qDetailRes->qty];
              $this->db->table('current_inventory')->where('id',$invtID)->set($uQty)->update();

              $qStoreQty = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->selectSum('quantity')->get();
              $qStoreQtyRes = $qStoreQty->getRow();

              $qPrice = $this->db->table('items_price')->where('items_id',$data['item_id'])->where('store_id',$data['store_id'])->get();
              $qPriceRes = $qPrice->getRow();

              $uPriceData = [
                  'current_inventory'=>$qStoreQtyRes->quantity,
                  'inventory_value'=>$qStoreQtyRes->quantity*$qPriceRes->retail_price
              ];
              $this->db->table('items_price')->where('id',$qPriceRes->id)->set($uPriceData)->update();
               
            } else {
            //     // Insufficient stock or other error; handle accordingly
                return json_encode([
                    "status" => "false",
                    "message" => "Sale failed due to insufficient stock.",
                ]);
            }
          }

        } else {

          $add_data = [
            'item_id' => $data['item_id'],
            'store_id' => $data['store_id'],
            'sold_qty' => $result['sold_qty']  +  $data['qty'],
            'sold_value' => ($result['sold_qty']  +  $data['qty']) * $price
          ];

          $this->db
                ->table('store_items')
                ->where(["id" => $result['id']])
                ->set($add_data)
                ->update();

          $this->table('store_items')->select('*');
          $this->where(["id" => $result['id']]);
          $result = $this->first();

          if(!empty($invtRow)) {
            $invtID = $invtRow->id;

            $deduct = $this->deductLaybyStock($data['item_id'], $data['store_id'], $data['qty'],$invtID);
            if ($deduct) {

              $qDetail = $this->db->table('current_inventory_details')->where('current_inventory_id',$invtID)->selectSum('qty')->get();
              $qDetailRes = $qDetail->getRow();

              $uQty = ['quantity'=>$qDetailRes->qty];
              $this->db->table('current_inventory')->where('id',$invtID)->set($uQty)->update();

              $qStoreQty = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->selectSum('quantity')->get();
              $qStoreQtyRes = $qStoreQty->getRow();

              $qPrice = $this->db->table('items_price')->where('items_id',$data['item_id'])->where('store_id',$data['store_id'])->get();
              $qPriceRes = $qPrice->getRow();

              $uPriceData = [
                  'current_inventory'=>$qStoreQtyRes->quantity,
                  'inventory_value'=>$qStoreQtyRes->quantity*$qPriceRes->retail_price
              ];
              $this->db->table('items_price')->where('id',$qPriceRes->id)->set($uPriceData)->update();
               
            } else {
            //     // Insufficient stock or other error; handle accordingly
                return json_encode([
                    "status" => "false",
                    "message" => "Sale failed due to insufficient stock.",
                ]);
            }
          }

            $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
            $add_qty = $result['open_qty'] + $result['received_qty'];
            $close_qty = ($add_qty) - ($remove_qty);
            
            $close_value = $close_qty * $price;
            
            $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);
            return true;
        }
    }
    public function deductStock($item_id, $qty, $invtID)
    {
        $query = $this->db->table('current_inventory_details')->where('current_inventory_id', $invtID)->where('qty >', 0)->orderBy('lot_no', 'ASC')->get();
        $records = $query->getResult();
        
        if (count($records) > 0) {
            foreach ($records as $row) {
                // Deduct quantity from the selected stock batch
                $deductedQty = min($row->qty, $qty);
                $qty -= $deductedQty;

                $uQty = (int) $row->qty - (int)$deductedQty;
                $uObj = ['qty'=>$uQty];

                $this->db->table('current_inventory_details')->where('id', $row->id)->set($uObj)->update();
                
                if ($qty === 0) {
                    break;
                }
            }
            
            return true;
        }
        
        return false;
    }
    public function deductLaybyStock($item_id, $store_id, $qty, $invtID)
    {
        $sessData = getSessionData();
        $query = $this->db->table('current_inventory_details')->where('current_inventory_id', $invtID)->where('qty >', 0)->orderBy('lot_no', 'ASC')->get();
        $records = $query->getResult();

        if (count($records) > 0) {

          $invtQuery = $this->db->table('current_inventory')->where('item_id',$item_id)->where('store_id',$store_id)->where('location_id',3)->get();
          $invtRow = $invtQuery->getRow();
          $invLbyID = '';
          if(empty($invtRow)) {
            $addLby = [
              'pos_id'=>$sessData['pos_id'],
              'item_id'=>$item_id,
              'store_id'=>$store_id,
              'location_id'=>3,
              'quantity'=>$qty
            ];

            $this->db->table('current_inventory')->insert($addLby);
            $invLbyID =  $this->db->insertID();
          } else {
            $invLbyID = $invtRow->id;
            $uQty = $qty + $invtRow->quantity;
            $invt = ['quantity'=>$uQty];
            $this->db->table('current_inventory')->where('id',$invtRow->id)->set($invt)->update();
          }

          foreach ($records as $row) {
              // Deduct quantity from the selected stock batch
              $deductedQty = min($row->qty, $qty);
              $qty -= $deductedQty;

              $uQty = (int) $row->qty - (int)$deductedQty;
              $uObj = ['qty'=>$uQty];

              $this->db->table('current_inventory_details')->where('id', $row->id)->set($uObj)->update();
              
              $add_detail = [
                'pos_id'=>$sessData['pos_id'],
                'current_inventory_id'=>$invLbyID,
                'qty'=>$deductedQty,
                'lot_no'=>$row->lot_no,
                'dom'=>$row->dom,
                'expiry_date'=>$row->expiry_date
              ];
              $this->db->table('current_inventory_details')->insert($add_detail);
              
              if ($qty === 0) {
                  break;
              }
          }
            
          return true;
        }
        
        return false;
    }
    public function adjustTransfer($data)
    {
        $this->table('store_items')->select('*');
        $this->where('item_id',$data['item_id']);
        $this->where('store_id',$data['store_id']);
        $this->where('location_id',$data['location_id']);
        $this->where("DATE_FORMAT(created_at,'%Y-%m-%d') =",$data['date']);
        $result = $this->first();

        if(!empty($result)) {
            $itemModel = new ItemModel();
            $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);
            $stock =  (int) $itemObj['stock'];
            $price =  (int) $itemObj['price'];
            
            $u_data = [
              'transfer_qty' => $result['transfer_qty'] + $data['qty'],
              'transfer_value' => ($result['transfer_qty'] + $data['qty']) * $price
            ];
          if($data['act'] == "remove") {
            $u_data = [
              'transfer_qty' => $result['transfer_qty'] - $data['qty'],
              'transfer_value' => ($result['transfer_qty'] - $data['qty']) * $price
            ];
          }

          $this->db
                ->table('store_items')
                ->where(["id" => $result['id']])
                ->set($u_data)
                ->update();

            $this->table('store_items')->select('*');
            $this->where(["id" => $result['id']]);
            $result = $this->first();

            $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
            $add_qty = $result['open_qty'] + $result['received_qty'];
            $close_qty = ($add_qty) - ($remove_qty);
            
            $close_value = $close_qty * $price;
                
            $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);
          }
            return true;   
    }

    public function adjustedItem($data)
    {
        $result = $this->getStoreItems($data['item_id'],$data['store_id'],$data['location_id']);

        $itemModel = new ItemModel();
        $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);
        // $stock =  (int) $itemObj['stock'];
        $price =  (int) $itemObj['price'];

        $invtQuery = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
        $invtRow = $invtQuery->getRow();
        $stock = isset($invtRow->quantity)?$invtRow->quantity:0;

        if(empty($result)) {
          $close_qty = $stock > 0 ? $stock - $data['qty'] : $data['qty'];
          $add_data = [
            'open_qty' => $stock,
            'open_value' => $stock * $price,   
            'item_id' => $data['item_id'],
            'location_id'=>$data['location_id'],
            'store_id' => $data['store_id'],
            'adjustment_qty' => $data['qty'],
            'adjustment_value' => $data['qty'] * $price,
            'close_qty' => $close_qty,
            'close_value' => $close_qty * $price
          ];

          $this->db->table('store_items')->insert($add_data);
          $query =  $this->db->insertID();

          $invtID = "";

          if(!empty($invtRow)) {
            $invtID = $invtRow->id;

            $deduct = $this->deductStock($data['item_id'], $data['qty'],$invtID);

            $qDetail = $this->db->table('current_inventory_details')->where('current_inventory_id',$invtID)->selectSum('qty')->get();
            $qDetailRes = $qDetail->getRow();

            $uQty = ['quantity'=>$qDetailRes->qty];
            $this->db->table('current_inventory')->where('id',$invtID)->set($uQty)->update();

            $qStoreQty = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->selectSum('quantity')->get();
            $qStoreQtyRes = $qStoreQty->getRow();

            $qPrice = $this->db->table('items_price')->where('items_id',$data['item_id'])->where('store_id',$data['store_id'])->get();
            $qPriceRes = $qPrice->getRow();

            $uPriceData = [
                'current_inventory'=>$qStoreQtyRes->quantity,
                'inventory_value'=>$qStoreQtyRes->quantity*$qPriceRes->retail_price
            ];
            $this->db->table('items_price')->where('id',$qPriceRes->id)->set($uPriceData)->update();
               
            
          }

        } else {

          $add_data = [
            'item_id' => $data['item_id'],
            'store_id' => $data['store_id'],
            'adjustment_qty' => $result['sold_qty']  +  $data['qty'],
            'adjustment_value' => ($result['sold_qty']  +  $data['qty']) * $price
          ];

          $this->db
                ->table('store_items')
                ->where(["id" => $result['id']])
                ->set($add_data)
                ->update();

          $this->table('store_items')->select('*');
          $this->where(["id" => $result['id']]);
          $result = $this->first();

          if(!empty($invtRow)) {
            $invtID = $invtRow->id;

            $deduct = $this->deductStock($data['item_id'], $data['qty'],$invtID);
 

              $qDetail = $this->db->table('current_inventory_details')->where('current_inventory_id',$invtID)->selectSum('qty')->get();
              $qDetailRes = $qDetail->getRow();

              $uQty = ['quantity'=>$qDetailRes->qty];
              $this->db->table('current_inventory')->where('id',$invtID)->set($uQty)->update();

              $qStoreQty = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->selectSum('quantity')->get();
              $qStoreQtyRes = $qStoreQty->getRow();

              $qPrice = $this->db->table('items_price')->where('items_id',$data['item_id'])->where('store_id',$data['store_id'])->get();
              $qPriceRes = $qPrice->getRow();

              $uPriceData = [
                  'current_inventory'=>$qStoreQtyRes->quantity,
                  'inventory_value'=>$qStoreQtyRes->quantity*$qPriceRes->retail_price
              ];
              $this->db->table('items_price')->where('id',$qPriceRes->id)->set($uPriceData)->update();
 
          }

            $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
            $add_qty = $result['open_qty'] + $result['received_qty'];
            $close_qty = ($add_qty) - ($remove_qty);
            
            $close_value = $close_qty * $price;
            
            $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);
            return true;
        }
    }
    public function productionItem($data)
    {
        $result = $this->getStoreItems($data['item_id'],$data['store_id'],$data['location_id']);

        $itemModel = new ItemModel();
        $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);

        // $stock =  (int) $itemObj['stock'];
        $price =  (int) $itemObj['price'];

        $invtQuery = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
        $invtRow = $invtQuery->getRow();

        $stock = isset($invtRow->quantity)?$invtRow->quantity:$data['qty'];

        if(empty($result)) {
          $close_qty = $stock > 0 ? $stock + $data['qty'] : $data['qty'];
          $add_data = [
            'open_qty' => $stock,
            'open_value' => $stock * $price,   
            'item_id' => $data['item_id'],
            'location_id'=>$data['location_id'],
            'store_id' => $data['store_id'],
            'production_qty' => $data['qty'],
            'production_value' => $data['qty'] * $price,
            'close_qty' => $close_qty,
            'close_value' => $close_qty * $price
          ];

          $this->db->table('store_items')->insert($add_data);
          $query =  $this->db->insertID();

          $locationQty = $data['qty'];

          $invtID = $invtRow->id;
          $locationQty = isset($invtRow->quantity)?$locationQty + $invtRow->quantity:$locationQty;
          $updateCurrInventory = [
            'quantity'=>$locationQty
          ];
          $this->db->table('current_inventory')->where('id',$invtRow->id)
          ->set($updateCurrInventory)
          ->update();

          $detail_data = [
            'pos_id'=>$invtRow->pos_id,
            'current_inventory_id'=>$invtID,
            'qty'=>$data['qty'],
            'lot_no'=>'',
            'dom'=>'',
            'expiry_date'=>''
          ];

          $this->db->table('current_inventory_details')->insert($detail_data);

          $updateStock = array('current_inventory'=>$add_data['close_qty']);
          $updateStockValue = array('inventory_value'=>$price*$close_qty);
          $this->db->table('items_price')->where('store_id',$data['store_id'])->where('items_id',$data['item_id'])
            ->set($updateStock)
            ->set($updateStockValue)
            ->update();

          return $query;

        } else {
          $add_data = [
            'item_id' => $data['item_id'],
            'store_id' => $data['store_id'],
            'production_qty' => $result['production_qty'] + $data['qty'],
            'production_value' => ($result['production_qty'] + $data['qty']) * $price
          ];

          $this->db
                ->table('store_items')
                ->where(["id" => $result['id']])
                ->set($add_data)
                ->update();

          $this->table('store_items')->select('*');
          $this->where(["id" => $result['id']]);
          $result = $this->first();
          $locationQty = $data['qty'];
          $locationQty = isset($invtRow->quantity)?abs($locationQty + $invtRow->quantity):$locationQty;
          $updateCurrInventory = [
            'quantity'=>$locationQty
          ];

          $this->db->table('current_inventory')->where('id',$invtRow->id)
          ->set($updateCurrInventory)
          ->update();

          $detail_data = [
            'pos_id'=>$invtRow->pos_id,
            'current_inventory_id'=>$invtRow->id,
            'qty'=>$data['qty'],
            'lot_no'=>'',
            'dom'=>'',
            'expiry_date'=>''
          ];

          $this->db->table('current_inventory_details')->insert($detail_data);
            
          $qPrice = $this->db->table('items_price')->where('items_id',$data['item_id'])->where('store_id',$data['store_id'])->get();
          $qPriceRes = $qPrice->getRow();

          $qStoreQty = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->selectSum('quantity')->get();
          $qStoreQtyRes = $qStoreQty->getRow();

          $uPriceData = [
              'current_inventory'=>$qStoreQtyRes->quantity,
              'inventory_value'=>$qStoreQtyRes->quantity*$qPriceRes->retail_price
          ];
          $this->db->table('items_price')->where('id',$qPriceRes->id)->set($uPriceData)->update();

            $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
            $add_qty = $result['open_qty'] + $result['received_qty'] + $result['production_qty'];
            $close_qty = ($add_qty) - ($remove_qty);
            $close_value = $close_qty * $price;
                
            $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);

            return true;
        }
    }
    public function GetStoreItemId($data,$lot_data = [])
    {
           $this->table('store_items')->select('*');
           $this->where('item_id',$data['item_id']);
           $this->where('store_id',$data['store_id']);
           $this->where('location_id',$data['location_id']);
           $this->where("DATE_FORMAT(created_at,'%Y-%m-%d') =",date('Y-m-d'));
           $result = $this->first();
           
           $itemModel = new ItemModel();
           $itemObj = $itemModel->getItemStock($data['item_id'],$data['store_id']);
           $stock = (int) $itemObj['stock'];
           $price = (int) $itemObj['price'];

           if(empty($result)){
        
              switch($data['type']){
                  case 'received':
                    $close_qty = $stock + $data['qty'];

                    $add_data = [
                      'open_qty' => $stock,
                      'open_value' => $stock * $price,
                      'item_id' => $data['item_id'],
                      'store_id' => $data['store_id'],
                      'location_id' => $data['location_id'],
                      'received_qty' => $data['qty'],
                      'received_value' => $data['qty'] * $price,
                      'close_qty' =>  $close_qty,
                      'close_value' => $close_qty * $price
                    ];
                  break;
                  case 'returned':
                    $close_qty = $stock > 0 ? $stock - $data['qty'] : 0;
                    $add_data = [
                      'open_qty' => $stock,
                      'open_value' => $stock * $price,   
                      'item_id' => $data['item_id'],
                      'store_id' => $data['store_id'],
                      'location_id' => $data['location_id'],
                      'return_qty' => $data['qty'],
                      'return_value' => $data['qty'] * $price,
                      'close_qty' => $close_qty,
                      'close_value' => $close_qty * $price
                    ];
                  break;
                  case 'adjustment':
                    $close_qty = $stock > 0 ? $stock - $data['qty'] : 0;
                    $add_data = [
                      'open_qty' => $stock,
                      'open_value' => $stock * $price,
                      'item_id' => $data['item_id'],
                      'store_id' => $data['store_id'],
                      'adjustment_qty' => $data['qty'],
                      'adjustment_value' => $data['qty'] * $price,
                      'close_qty' => $close_qty,
                      'close_value' => $close_qty * $price
                    ]; 
                  break;
                  case 'production':
                    $close_qty = $stock + $data['qty'];
                    $add_data = [
                      'open_qty' => $stock,
                      'open_value' => $stock * $price,
                      'item_id' => $data['item_id'],
                      'store_id' => $data['store_id'],
                      'production_qty' => $data['qty'],
                      'production_value' => $data['qty'] * $price,
                      'close_qty' =>  $close_qty,
                      'close_value' => $close_qty * $price
                    ];
                  break;
                  case 'transfer':
                    $close_qty = $stock > 0 ? $stock - $data['qty'] : 0;
                    $add_data = [
                      'open_qty' => $stock,
                      'open_value' => $stock * $price,   
                      'item_id' => $data['item_id'],
                      'store_id' => $data['store_id'],
                      'transfer_qty' => $data['qty'],
                      'transfer_value' => $data['qty'] * $price,
                      'close_qty' => $close_qty,
                      'close_value' => $close_qty * $price
                    ];
                  break;  
                  case 'rejected':
                    $close_qty = $stock > 0 ? $stock - $data['qty'] : 0;
                    $add_data = [
                      'open_qty' => $stock,
                      'open_value' => $stock * $price,                        
                      'item_id' => $data['item_id'],
                      'store_id' => $data['store_id'],
                      'rejected_qty' => $data['qty'],
                      'rejected_value' => $data['qty'] * $price,
                      'close_qty' => $close_qty,
                      'close_value' => $close_qty * $price
                    ];
                  break;
                  case 'sold':
                    $close_qty = $stock > 0 ? $stock - $data['qty'] : 0;
                    $add_data = [
                      'open_qty' => $stock,
                      'open_value' => $stock * $price,                        
                      'item_id' => $data['item_id'],
                      'store_id' => $data['store_id'],
                      'sold_qty' => $data['qty'],
                      'sold_value' => $data['qty'] * $price,
                      'close_qty' => $close_qty,
                      'close_value' => $close_qty * $price
                    ];
                  break;
              }

              // $close_qty = $data['qty'];
              $this->db->table('store_items')->insert($add_data);
              $query =  $this->db->insertID();

              /*$locationQty = $data['qty'];
              
              $invtQuery = $this->db->table('current_inventory')->where('pos_id',$data['pos_id'])->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
              $invtRow = $invtQuery->getRow();*/

              $updateStock = array('current_inventory'=>$add_data['close_qty']);
              $updateStockValue = array('inventory_value'=>$price*$close_qty);
              $this->db->table('items_price')->where('store_id',$data['store_id'])->where('items_id',$data['item_id'])
                ->set($updateStock)
                ->set($updateStockValue)
                ->update();

              /*if(!empty($query)){
                $this->getUpdateCloseQty($close_qty,$query);
              }*/

              return $query;    

          } else {

            switch($data['type']){ 
                case 'received':
                 $add_data = [
                    'item_id' => $data['item_id'],
                    'store_id' => $data['store_id'],
                    'received_qty' => $result['received_qty'] + $data['qty'],
                    'received_value' => ($result['received_qty'] + $data['qty']) * $price
                  ];
                break;
                case 'returned':
                    $add_data = [
                    'item_id' => $data['item_id'],
                    'store_id' => $data['store_id'],
                    'return_qty' => $result['return_qty'] + $data['qty'],
                    'return_value' => ($result['return_qty'] + $data['qty']) * $price
                  ];
                break;
                case 'adjustment':
                    $add_data = [
                    'item_id' => $data['item_id'],
                    'store_id' => $data['store_id'],
                    'adjustment_qty' => $result['adjustment_qty'] + $data['qty'],
                    'adjustment_value' => ($result['adjustment_qty'] + $data['qty']) * $price
                  ];  
                break;
                case 'production':
                  $add_data = [
                    'item_id' => $data['item_id'],
                    'store_id' => $data['store_id'],
                    'received_qty' => $result['received_qty'] + $data['qty'],
                    'received_value' => ($result['received_qty'] + $data['qty']) * $price
                  ];
                break;
                case 'transfer':
                    $add_data = [
                    'item_id' => $data['item_id'],
                    'store_id' => $data['store_id'],
                    'transfer_qty' => $result['transfer_qty'] + $data['qty'],
                    'transfer_value' => ($result['transfer_qty'] + $data['qty']) * $price
                  ];
                break;  
                case 'rejected':
                    $add_data = [
                    'item_id' => $data['item_id'],
                    'store_id' => $data['store_id'],
                    'rejected_qty' => (float)$result['rejected_qty'] +  (float)$data['qty'],
                    'rejected_value' => ((float)$result['rejected_qty'] +  (float)$data['qty']) * $price
                  ];
                break;
                case 'sold':
                  $add_data = [
                    'item_id' => $data['item_id'],
                    'store_id' => $data['store_id'],
                    'sold_qty' => $result['sold_qty']  +  $data['qty'],
                    'sold_value' => ($result['sold_qty']  +  $data['qty']) * $price
                  ];
                break;
            }

            $this->db
                ->table('store_items')
                ->where(["id" => $result['id']])
                ->set($add_data)
                ->update();

            $this->table('store_items')->select('*');
            $this->where(["id" => $result['id']]);
            $result = $this->first();

            /*$locationQty = $data['qty'];
            
            $invtQuery = $this->db->table('current_inventory')->where('item_id',$data['item_id'])->where('store_id',$data['store_id'])->where('location_id',$data['location_id'])->get();
            $invtRow = $invtQuery->getRow();
            if(!empty($invtRow)) {

              $locationQty = isset($invtRow->quantity)?abs($locationQty - $invtRow->quantity):$locationQty;
              $updateCurrInventory = [
                'quantity'=>$locationQty
              ];
              $this->db->table('current_inventory')->where('id',$invtRow->id)
              ->set($updateCurrInventory)
              ->update();
            }  */

            $remove_qty = $result['return_qty'] + $result['adjustment_qty'] + $result['transfer_qty'] + $result['sold_qty'];   
            $add_qty = $result['open_qty'] + $result['received_qty'];
            $close_qty = ($add_qty) - ($remove_qty);
            
            $close_value = $close_qty * $price;
            $updateStock = array('current_inventory'=>$close_qty);
            $updateStockValue = array('inventory_value'=>$price*$close_qty);
              $this->db->table('items_price')->where('store_id',$data['store_id'])->where('items_id',$data['item_id'])
                ->set($updateStock)
                ->set($updateStockValue)
                ->update();
                
            // if(!empty($close_qty)){
                $this->getUpdateCloseQty($close_qty,$close_value,$result['id']);
            // }

            /*$update_data = [
                    'close_qty' => $close_qty,
                  ];
           $this->db
                ->table('store_items')
                ->where(["id" => $result['id']])
                ->set($update_data)
                ->update();
                return true;    
            */
            return true;   
          }
           
    }
    public function getUpdateCloseQty($close_qty,$close_value,$id){
      $update_data = [
                    'close_qty' => $close_qty,
                    'close_value' => $close_value
                  ];
                 
      $this->db
            ->table('store_items')
            ->where(["id" => $id])
            ->set($update_data)
            ->update();
            return true;
    }
}
