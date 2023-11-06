<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Models\StockMovementModel;
use App\Models\StockAdjustModel;
use App\Models\StoreModel;
use App\Models\CategoryModel;
use App\Models\TransferModel;
use App\Models\ItemModel;
use App\Models\ItemsPriceModel;
use App\Models\StockAdjustmentReasonModel;
use App\Models\CommonModel;
use App\Models\Location;
use App\Models\CurrentInventory;
use App\Models\CurrentInventoryDetails;
use App\Models\AdjustmentItemModel;
use App\Models\TransferItemsModel;
use App\Models\StoreItemsModel;
use App\Models\BrandMasterModel;
use App\Models\UomModel;
use App\Models\ModifiersModel;
use App\Models\TaxesModel;
use App\Models\VariantMatserModel;
use App\Models\CompositeMasterModel;
use App\Models\SubcategoryModel;
use App\Models\EmployeeModel;
use App\Models\ProductionModel;

class InventoryController extends BaseController
{
    public function index()
    {

        $data = [];
        $data['title'] = 'Inventory'; 

        $sessData = getSessionData();
        /*if($sessData['store_id']){
            $store->where('id',$sessData['store_id']);
        }*/

        $data['permission'] = $sessData['permissions'];
        $store = new StoreModel();
        /*if($sessData['role_name'] == "Staff") {
            $store->where('id',$sessData['store_id']);

        } else if ($sessData['role_name'] == "Owner") {
            $store->where('pos_id',$sessData['pos_id']);
        }*/
        $data['store'] = $store->findAll();
        
        $category = new CategoryModel();
        $data['category'] = $category->findAll();

        $stockReasonModel = new StockAdjustmentReasonModel();
        $data['reason'] = $stockReasonModel->select('id, reason')->where('status',1)->findAll();
       
        $location = new Location();
        $data['location'] = $location->whereIn('pos_id',[0,$sessData['pos_id']])->where('status',1)->findAll();

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['store_id']);
        $data['items'] = json_encode($itemlist);
        
        $brandmasterModel = new BrandMasterModel();
        $data['brand'] = $brandmasterModel->where("status",1)->findAll();
        
        return $this->template->render('pages/inventory/inventory', $data); 
    }

    public function AddStockAdjustment()
    {
        $data = [];
        $data['title'] = 'Add Stock Adjustments'; 
        $data['main_menu'] = 'Inventory'; 
        $data['main_menu_url'] = base_url('inventory');

        $sessData = getSessionData();

        $storeModel = new StoreModel();
        /*if($sessData['role_name'] == "Staff") {
            $storeModel->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $storeModel->where('owner_id',$sessData['id']);
        }*/
        $data['store'] = $storeModel->where('pos_id',$sessData['pos_id'])->findAll();

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        $stockReasonModel = new StockAdjustmentReasonModel();
        $data['reason'] = $stockReasonModel->select('id,reason')->where('status',1)->findAll();
       
        return $this->template->render('pages/inventory/stock_adjustment_add', $data); 
    }

    public function EditStockAdjustment($id)
    {
        $data = [];
        $data['title'] = 'Edit Stock Adjustments';
        $data['main_menu'] = 'Inventory';
        $data['main_menu_url'] = base_url('inventory'); 
        $sessData = getSessionData();
        
        $storeModel = new StoreModel();
        /*if($sessData['role_name'] == "Staff") {
            $storeModel->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $storeModel->where('pos_id',$sessData['pos_id']);
        }*/
        $data['store'] = $storeModel->findAll();

        $stockadjustModel = new StockAdjustModel();
        $data['stock_adjust'] = $stockadjustModel->where("id",$id)->first();

        $stockReasonModel = new StockAdjustmentReasonModel();
        $data['reason'] = $stockReasonModel->select('id,reason')->where('status',1)->findAll();

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        $aiModel = new AdjustmentItemModel();
        $data['stocks_item'] = $aiModel->GetStockSubItemData($id);
       
        return $this->template->render('pages/inventory/stock_adjustment_add', $data); 
    }

    public function ViewStockAdjustment($id)
    {
        $data = [];
        $data['title'] = 'View Stock Adjustments';
        $data['main_menu'] = 'Inventory';
        $data['main_menu_url'] = base_url('inventory'); 
        $sessData = getSessionData();

        $stockadjustModel = new StockAdjustModel();
        $data['stock_adjust'] = $stockadjustModel->select('stockadjusts.*,stores.store_name,location.location_description,stock_adjustments_reason.reason')
            ->join('stores','stockadjusts.store_id = stores.id')
            ->join('location','stockadjusts.location_id = location.id')
            ->join('stock_adjustments_reason','stockadjusts.reason_id = stock_adjustments_reason.id')
            ->where("stockadjusts.id",$id)->first();

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        $aiModel = new AdjustmentItemModel();
        $data['stocks_item'] = $aiModel->GetStockSubItemData($id);
       
        return $this->template->render('pages/inventory/stock_adjustment_view', $data);
    }

    public function AddTransfer()
    {
        $data = [];
        $data['title'] = 'Add Transfer';
        $data['main_menu'] = 'Inventory';
        $data['main_menu_url'] = base_url('inventory');
        $data['act'] = 'add';

        $sessData = getSessionData();
        $data['sess_store'] = $sessData['store_id'];

        $supStore = new StoreModel();
        $recStore = new StoreModel();
        /*if($sessData['role_name'] == "Staff") {
            $emp = new EmployeeModel();
            $staff = $emp->where('id',$sessData['id'])->first();

            $supStore->where('id',$sessData['store_id']);
            $recStore->where('owner_id',$staff['created_by']);

        } else if ($sessData['role_name'] == "Owner") {*/
            $supStore->where('pos_id',$sessData['pos_id']);
            $recStore->where('pos_id',$sessData['pos_id']);
        // }
        $data['supplyStore'] = $supStore->findAll();
        $data['receiveStore'] = $recStore->findAll();

        $Location = new Location();
        $data['location'] = $Location->where('status',1)->findAll();
        
        // $data['isReceiveStore'] = false;
        
        /*$storeModel = new StoreModel();
        if($sessData['role_name'] == "Staff") {
            $storeModel->where('id',$sessData['store_id']);
        } else if($sessData['role_name'] == "Owner") {
            $storeModel->where('owner_id',$sessData['id']);
        }
        $data['store'] = $storeModel->findAll();*/

        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->findAll();

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        return $this->template->render('pages/inventory/transfer_add', $data); 
    }

    public function EditTransfer($id)
    {
        $data = [];
        $data['title'] = 'Edit Transfer';
        $data['main_menu'] = 'Inventory'; 
        $data['main_menu_url'] = base_url('inventory');
        $data['act'] = 'edit'; 
        
        $sessData = getSessionData();
        $data['sess_store'] = $sessData['store_id'];
        
        /*$data['store_id'] = "";
        if(!empty($data['emp']['stores'])){
            $data['store_id'] = $data['emp']['stores'][0]['store_id'];
        }*/
        
        $supStore = new StoreModel();
        $recStore = new StoreModel();
        if($sessData['role_name'] == "Staff") {
            $emp = new EmployeeModel();
            $staff = $emp->where('id',$sessData['id'])->first();

            $supStore->where('id',$sessData['store_id']);
            $recStore->where('owner_id',$staff['created_by']);

        } else if ($sessData['role_name'] == "Owner") {
            $supStore->where('pos_id',$sessData['pos_id']);
            $recStore->where('pos_id',$sessData['pos_id']);
        }
        $data['supplyStore'] = $supStore->findAll();
        $data['receiveStore'] = $recStore->findAll();

        $transferModel = new TransferModel();
        $data['transfer'] = $transferModel->select('transfer.*,s.store_name as supply_store,r.store_name as receive_store,sl.location_description as supply_location,rl.location_description as rec_location')
                            ->join('stores s','transfer.supply_store_id = s.id')
                            ->join('stores r','transfer.receive_location_id = r.id')
                            ->join('location sl','transfer.location_id = sl.id')
                            ->join('location rl','transfer.receive_location_id = rl.id')
                            ->where("transfer.id",$id)->first();

        $location = new Location();
        $data['slocation'] = $location->where('store_id',$data['transfer']['supply_store_id'])->findAll();

        $data['rlocation'] = $location->where('store_id',$data['transfer']['receiver_store_id'])->findAll();

        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->findAll();

        $data['isReceiveStore'] = false;
        /*if($data['store_id'] != "" && $data['transfer']['receiver_store_id'] == $data['store_id']) {
            $data['isReceiveStore'] = true;
        }*/
        
        $tim = new TransferItemsModel();
        $data['transfer_items'] = $tim->GetTransferItemData($id);

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        return $this->template->render('pages/inventory/transfer_edit', $data); 
    }
    
    public function ViewTransfer($id)
    {
        $session = session();
        $empId = $session->get('id');
        $empModel = new EmployeeModel();
        $data['emp'] = $empModel->GetEmployeeData($empId);
        $store_id = "";
      
        if(!empty($data['emp']['stores'])){
            $store_id = $data['emp']['stores'][0]['store_id'];
        }

        $data = [];
        $data['title'] = 'View Transfer'; 
        $data['main_menu'] = 'inventory'; 
        $data['main_menu_url'] = base_url('inventory');
        $data['url'] = uri_string(); 
        
        // $storeModel = new StoreModel();
        // $data['store'] = $storeModel->findAll();

        // $categoryModel = new CategoryModel();
        // $data['category'] = $categoryModel->findAll();

        $transferModel = new TransferModel();
        $transferModel->select('transfer.*,sp.store_name as supply_store,sr.store_name as receiver_store,sloc.location_description as supply_loc, rloc.location_description as receive_loc');
        $transferModel->join('stores as sp', 'transfer.supply_store_id = sp.id','left');
        $transferModel->join('stores as sr', 'transfer.receiver_store_id = sr.id','left');
        $transferModel->join('location as sloc', 'transfer.location_id = sloc.id','left');
        $transferModel->join('location as rloc', 'transfer.receive_location_id = rloc.id','left');
        $data['transfer'] = $transferModel->where("transfer.id",$id)->first();

        $data['isReceiveStore'] = false;
        if($store_id != "" && $data['transfer']['receiver_store_id'] == $store_id) {
            $data['isReceiveStore'] = true;
        }
        
        $tim = new TransferItemsModel();
        $data['transfer_items'] = $tim->GetTransferItemData($id);

        return $this->template->render('pages/inventory/transfer_view', $data);
    }
     public function getInventoryDetailsByLocation()
    {
        $post = $this->request->getVar();

        $mdl = new CurrentInventory();
        $inventory = $mdl->where('item_id',$post['item_id'])->where('store_id',$post['store_id'])->where('location_id',$post['location_id'])->first();

        if(!empty($inventory)){
            $detail = new CurrentInventoryDetails();
            $detailData = $detail->where('current_inventory_id',$inventory['id'])->where('qty >',0)->findAll();

            if(!empty($detailData)){
                return json_encode([
                    "status" => "true",
                    "data" => [],
                    "details"=>$detailData
                ]);
            } else {
                return json_encode([
                    "status" => "false",
                    "message"=>"Inventory Data not found",
                    "data" => [],
                    "details"=>[]
                ]);
            }
        } else {
            return json_encode([
                "status" => "false",
                "message"=>"Inventory Data not found",
                "data" => [],
                "details"=>[]
            ]);
        }

    }
    public function AddProduction()
    {
        $data = [];
        $data['title'] = 'Add Production';
        $data['main_menu'] = 'Inventory';
        $data['main_menu_url'] = base_url('inventory');

        $sessData = getSessionData();

        $prodModel = new ProductionModel();
        $newID = $prodModel->where('pos_id',$sessData['pos_id'])->countAll();
        $data['production_no'] = $newID + 1;

        $store = new StoreModel();
        $data['store'] = $store->findAll();

        $items = new ItemModel();
        $itemsData = $items->getPreProductionItems($sessData['pos_id']);
        $data['items'] = json_encode($itemsData);

        $ingrData = $items->getIsIngredientItems($sessData['pos_id']);
        $data['ingredients'] = json_encode($ingrData);

        return $this->template->render('pages/inventory/production_add', $data);
    }
    public function Post_Data_Inventory()
    {
        if ($this->request->getMethod() == "post") 
        {
                $post = $this->request->getVar();
                $sessData = getSessionData();

                switch($post['table_name'])
                {
                    case 'stockadjusts':
                        $data = [
                            'pos_id'=>$sessData['pos_id'],
                            'store_id' => isset($post["store_id"])?$post["store_id"]:"0",
                            'location_id'=> isset($post['location_id'])?$post['location_id']:"",
                            'reason_id' => isset($post["reason"])?$post["reason"]:"",
                            'narration' => isset($post["narration"])?$post["narration"]:"",
                            'total_cost' => isset($post["total_cost"])?$post["total_cost"]:"0",
                            'total_quantity' => isset($post["total_quantity"])?$post["total_quantity"]:"0",
                            'status' => isset($post["status"])?$post["status"]:"0"
                        ];
                    break;
                    case 'stock_adjustments_reason':
                        $data = [
                            'pos_id'=>$sessData['pos_id'],
                            'reason' => $post['reason'],
                            'status' => $post['status']
                        ];
                    break;
                    case 'transfer':
                        $data = [
                            'pos_id'=>$sessData['pos_id'],
                            'location_id'=>isset($post["location_id"])?$post["location_id"]:"0",
                            'supply_store_id' => isset($post["supply_store_id"])?$post["supply_store_id"]:"0",
                            'receive_location_id'=>isset($post['rec_location_id'])?$post['rec_location_id']:"",
                            'receiver_store_id' => isset($post["receiver_store_id"])?$post["receiver_store_id"]:"0",
                            'category_id' => isset($post["category_id"])?$post["category_id"]:"0",
                            'order_number' => isset($post["order_number"])?$post["order_number"]:"0",
                            'due_date' => isset($post["due_date"])?$post["due_date"]:"0",
                            'date'=> isset($post['date'])?$post['date']:"",
                            'status' => isset($post["status"])?$post["status"]:"0"
                        ];
                    break;
                    case 'production':
                        $data = [
                            'pos_id' => $sessData['pos_id'],
                            'item_id' => isset($post["item_id"])?$post["item_id"]:"",
                            'quantity' => isset($post["quantity"])?$post["quantity"]:"",
                            'store_id' => isset($post["store_id"])?$post["store_id"]:"",
                            'location_id' => isset($post["location_id"])?$post["location_id"]:"",
                            'date' => isset($post["date"])?$post["date"]:"",
                            'narration' => isset($post["narration"])?$post["narration"]:""
                        ];
                    break;
                }
        }
            $db = db_connect();
            $commonModel = new CommonModel($db);
            $common = new CommonModel($db);
            if(isset($post['id']) && empty($post['id']))
            {
                $result = $commonModel->AddData($post['table_name'],$data);
                switch($post['table_name'])
                {
                    case 'stockadjusts':
                        foreach($post['item'] as $row){
                            $storeItemModel = new StoreItemsModel();
                            $store_data = [
                                'pos_id'=>$sessData['pos_id'],
                                'item_id'=>$row['item_id'],
                                'store_id'=>$post['store_id'],
                                'qty'=>$row['quantity'],
                                'location_id'=>$post['location_id'],
                                'type'=>'adjustment'
                            ];
                            $store_item = $storeItemModel->adjustedItem($store_data);

                            $new_data = array(
                                'stock_adjust_id'=>$result,
                                'item_id'=>$row['item_id'],
                                'quantity'=>$row['quantity'],
                                'item_per_cost'=>$row['item_per_cost'],
                                'cost'=>$row['cost']
                            );
                            $commonModel->AddData('stock_adjustments_items',$new_data);
                            // $this->updateItemStocks($row['quantity'],$row['item_id'],2);
                        }
                    break;
                    case 'transfer':
                        $location = $post['location_id'];
                        $recLocation = $post['rec_location_id'];
                        if($post['rec_location_id'] == "") {
                            $recLocation = $location;
                        }
                        foreach($post['items'] as $row){
                            $storeItemModel = new StoreItemsModel();

                            if($post["status"] == 0) {
                                //Pending
                                $store_data = [
                                    'item_id'=>$row['item_id'],
                                    'store_id'=>$post['supply_store_id'],
                                    'location_id'=>$location,
                                    'qty'=>$row['quantity'],
                                    'type'=>'transfer',
                                    'invt_detail_id'=>$row['manufacture_date']
                                ];
                                $store_item = $storeItemModel->supplyTransfer($store_data);
                            } elseif($post['status'] == 1) {
                                //Approved

                                $supply_data = [
                                    'item_id'=>$row['item_id'],
                                    'store_id'=>$post['supply_store_id'],
                                    'location_id'=>$location,
                                    'qty'=>$row['received_qty'],//$row['received_qty'],
                                    'type'=>'transfer',
                                    'invt_detail_id'=>$row['manufacture_date']
                                ];
                                $storeItemModel->supplyTransfer($supply_data);
                           
                                $receive_data = [
                                    'item_id'=>$row['item_id'],
                                    'store_id'=>$post['receiver_store_id'],
                                    'location_id'=>$recLocation,
                                    'qty'=>$row['received_qty'],//$row['received_qty'],
                                    'type'=>'received',
                                    'invt_detail_id'=>$row['manufacture_date']
                                ];
                                
                                $storeItemModel->receiveTransfer($receive_data);
                                // $this->updateItemStocks($row['variance'],$row['item_id'],1);
                            }
                            $detail = new CurrentInventoryDetails();
                            $detailDt = $detail->select('lot_no, dom, expiry_date')->where('id',$row['manufacture_date'])->first();
                            $new_data = array(
                                'transfer_id'=>$result,
                                'item_id'=>$row['item_id'],
                                'cost_price'=>$row['cost_price'],
                                'selling_price'=>$row['selling_price'],
                                'inventory_detail_id'=>$row['manufacture_date'],
                                'manufacture_expiry_date'=>isset($detailDt)?$detailDt['dom'].'-'.$detailDt['expiry_date'].' ('.$detailDt['lot_no'].')':'-' ,
                                'inventory_quantity'=>$row['inventory_qty'],
                                'quantity'=>$row['quantity'],
                                'received_quantity'=>isset($row['received_qty'])?$row['received_qty']:0,
                                'variance'=>isset($row['variance'])?$row['variance']:''
                            );
                            $commonModel->AddData('transfer_items',$new_data);
                        }
                    break;
                    case 'production':
                        $storeItemModel = new StoreItemsModel();
                        $store_data = [
                            'item_id'=>$post['item_id'],
                            'store_id'=>$post['store_id'],
                            'location_id'=>$post['location_id'],
                            'qty'=>$post['quantity'],
                            'type'=>'production'
                        ];
                        $storeItemModel->productionItem($store_data);
                        
                        foreach($post['items'] as $row){

                            $new_data = array(
                                'production_id'=>$result,
                                'item_id'=>$row['item_id'],
                                'price'=>$row['selling_price'],
                                'quantity'=>$row['quantity'],
                            );
                            $commonModel->AddData('production_items',$new_data);
                         }
                     break;
                }
                return json_encode([
                    "status" => "true",
                    "message" => "New Data added successfully",
                ]);
            }
            else
            {
                $id = $post['id'];
                $result = $commonModel->UpdateData($post['table_name'],$id,$data);

                switch($post['table_name'])
                {
                     case 'stockadjusts':
                        foreach($post['item'] as $row){
                            if(isset($row['stock_item_id'])){
                                    $new_data = array(
                                    'stock_adjust_id'=>$id,
                                    'item_id'=>$row['item_id'],
                                    'quantity'=>$row['quantity'],
                                    'item_per_cost'=>$row['item_per_cost'],
                                    'cost'=>$row['cost']
                                );
                               $commonModel->UpdateData('stock_adjustments_items',$row['stock_item_id'],$new_data);
                            }else{
                                if(!empty($row['item_id'])){
                                $new_data = array(
                                    'stock_adjust_id'=>$id,
                                    'item_id'=>$row['item_id'],
                                    'quantity'=>$row['quantity'],
                                    'item_per_cost'=>$row['item_per_cost'],
                                    'cost'=>$row['cost']
                                );
                                $commonModel->AddData('stock_adjustments_items',$new_data);
                                }
                            }
                            // $this->updateItemStocks($row['quantity'],$row['item_id'],2);
                        }
                     break;
                     case 'transfer':
                        foreach($post['items'] as $row){
                            $storeItemModel = new StoreItemsModel();
                            /*if(isset($row['transfer_item_id'])){

                                $new_data = array(
                                    'inventory_quantity'=>0,
                                    'quantity'=>$row['quantity'],
                                    'received_quantity'=>isset($row['received_qty'])?$row['received_qty']:'',
                                    'variance'=>isset($row['variance'])?$row['variance']:''
                                );
                                $commonModel->UpdateData('transfer_items',$row['transfer_item_id'],$new_data);
                               // $this->updateItemStocks($row['quantity'],$row['item_id'],2);
                            }else{
                                if(!empty($row['item_id'])){
                                    $new_data = array(
                                        'transfer_id'=>$result,
                                        'item_id'=>$row['item_id'],
                                        'cost_price'=>$row['cost_price'],
                                        'selling_price'=>$row['selling_price'],
                                        'inventory_quantity'=>0,
                                        'quantity'=>$row['quantity'],
                                        'received_quantity'=>isset($row['received_qty'])?$row['received_qty']:'',
                                        'variance'=>isset($row['variance'])?$row['variance']:''
                                    );
                                    $commonModel->AddData('transfer_items',$new_data);
                                }
                            }*/
                            $received = 0;
                            $qty = 0;
                            $quantity = $row['quantity'];
                            $old = $row['old_quantity'];
                            if($post['status'] == 0) {
                                $c = abs($quantity - $old);
                                if($c == 0) {
                                    $qty = $quantity;
                                } else {
                                    if($quantity > $old) {
                                        $qty = $c + $old;
                                        $store_data = [
                                            'item_id'=>$row['item_id'],
                                            'store_id'=>$post['supply_store_id'],
                                            'location_id'=>$post['location_id'],
                                            'qty'=>$c,
                                            'type'=>'transfer',
                                            'invt_detail_id'=>$row['manufacture_date']
                                        ];
                                        $store_item = $storeItemModel->supplyTransfer($store_data);
                                    } else if($quantity < $old){
                                        $qty = $old - $c;
                                        $detail = new CurrentInventoryDetails();
                                        $detailDt = $detail->select('current_inventory_id, qty')->where('id',$row['manufacture_date'])->first();

                                        $uDetailInvt = [
                                            'qty'=>(int)$detailDt['qty']+$c
                                        ];
                                        $commonModel->UpdateData('current_inventory_details',$row['manufacture_date'],$uDetailInvt);

                                        $invt = new CurrentInventory();
                                        $invtDt = $invt->where('id',$detailDt['current_inventory_id'])->first();
                                        $uInvt = [
                                            'quantity'=>(int)$invtDt['quantity']+$c
                                        ];
                                        $commonModel->UpdateData('current_inventory',$detailDt['current_inventory_id'],$uInvt);

                                        $itemPr = new ItemsPriceModel();
                                        $itemPrDt = $itemPr->where('items_id',$row['item_id'])->where('store_id',$post['supply_store_id'])->first();

                                        $uTotalStk = [
                                            'current_inventory'=>(int)$itemPrDt['current_inventory']+$c,
                                            'inventory_value'=>$itemPrDt['inventory_value']+($itemPrDt['retail_price']*$c)
                                        ];

                                        $commonModel->UpdateData('items_price',$itemPrDt['id'],$uTotalStk);

                                        $adjust_data = [
                                            'item_id'=>$row['item_id'],
                                            'store_id'=>$post['supply_store_id'],
                                            'location_id'=>$post['location_id'],
                                            'qty'=>$c,
                                            'act'=>'remove',
                                            'date'=>$post['date']
                                        ];
                                        $storeItemModel->adjustTransfer($adjust_data);
                                    }
                                }
                            }
                            else if($post['status'] == 1) {
                                $received = $row['received_qty'];
                                $c = abs($quantity - $received);
                                $qty = isset($row['quantity'])?$row['quantity']:0;
                                $receive_data = [
                                    'item_id'=>$row['item_id'],
                                    'store_id'=>$post['receiver_store_id'],
                                    'location_id'=>$post['rec_location_id'],
                                    'qty'=>$row['received_qty'],//$row['received_qty'],
                                    'type'=>'received',
                                    'invt_detail_id'=>$row['manufacture_date']
                                ];
                                
                                $storeItemModel->receiveTransfer($receive_data);

                            } /*else if($post['status'] == 2) {
                                //Cancelled
                                $items = new ItemModel();
                                $getData = $items->where('id',$row['item_id'])->first();
                                $value = (int) $getData['current_inventory'] + (int) $row['quantity'];

                                $setData = array('current_inventory'=>$value);
                                $items->where("id", $row['item_id'])->set($setData)->update();
                            }*/

                            $new_data = array(
                                'quantity'=>$qty,
                                'received_quantity'=>$received,
                                'variance'=>isset($row['variance'])?$row['variance']:''
                            );
                            $commonModel->UpdateData('transfer_items',$row['transfer_item_id'],$new_data);
                        
                        }
                     break;
                }
                return json_encode([
                    "status" => "true",
                    "message" => "Data updated successfully",
                ]);
            } 

    }
    function getCurrentStock()
    {
        $sessData = getSessionData();

        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $mdl = new CurrentInventory();
        $flt = new CurrentInventory();
        $totalRecords = $mdl->select('id')->where('current_inventory.quantity >',0)
                ->countAllResults();

        $mdl->select('current_inventory.id,current_inventory.quantity, items.id as item_code,items.item_name,items.sku_barcode,p.retail_price,stores.store_name,uom_master.uom,location.location_description as location_type');
        $mdl->join('items', 'current_inventory.item_id = items.id','left');
        $mdl->join('stores', 'current_inventory.store_id = stores.id','left');
        $mdl->join('location', 'current_inventory.location_id = location.id','left');
        $mdl->join('items_price p','items.id = p.items_id','left');
        $mdl->join('uom_master', 'items.uom_id = uom_master.id','left');

        /*if($sessData['role_name'] == "Staff") {
            $mdl->where('store_items.store_id',$sessData['store_id']);
        }else if($sessData['role_name'] == "Owner") {
            $mdl->where('items.pos_id',$sessData['pos_id']);
        }*/
        
        if($filter['store_id'] != "") {
            $mdl->where('current_inventory.store_id',$filter['store_id']);
            $flt->where('current_inventory.store_id',$filter['store_id']);
        }
        if($filter['location_id'] != "") {
            $mdl->where('current_inventory.location_id',$filter['location_id']);
            $flt->where('current_inventory.location_id',$filter['location_id']);
        }
        if($filter['category_id'] != "") {
            $mdl->where('items.category_id',$filter['category_id']);
            $flt->where('items.category_id',$filter['category_id']);
        }
        if($filter['search'] != "") {
            $mdl->orLike('stores.store_name',$filter['search'])
                ->orLike('items.item_name',$filter['search']);
        }
        $mdl->where('current_inventory.quantity >',0);
        $mdl->groupBy('current_inventory.item_id');
        $mdl->groupBy('current_inventory.store_id');
        $mdl->groupBy('current_inventory.location_id');
        $mdl->orderBy('current_inventory.id','desc');
        $records = $mdl->findAll($rowperpage, $start);
        $flt->where('current_inventory.quantity >',0);
        $totalRecordwithFilter = $flt->countAllResults();//count($records);
        $data = array();
        
        foreach($records as $record ){
            /*$add_qty = $record['open_qty'] + $record['received_qty'];
            $remove_qty = $record['sold_qty'] + $record['adjustment_qty'] + $record['transfer_qty'];
            $total_qty = $add_qty - $remove_qty; */
            $data[] = [ 
               "id"=>$record['id'],
               "store_name"=>$record['store_name'],
               "location_type"=>$record['location_type'],
               "item_code"=>$record['item_code'],
               "item_name"=>$record['item_name'],
               "barcode"=>$record['sku_barcode'],
               "current_inventory"=>$record['quantity'],
               "unit"=>$record['uom'],
               "inventory_amount"=>(int)$record['quantity']*(int)$record['retail_price'],
               "cost_price"=>$record['retail_price'],
            ]; 
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash() // New token hash
         );

         return $this->response->setJSON($response);
    }
    function getInventoryDetails()
    {
        $post = $this->request->getVar();

        $detailData = new CurrentInventoryDetails();
        $data = $detailData->where('current_inventory_id',$post['id'])->findAll();

        if(!empty($data)) {
            $res = [
                'status'=> 'true',
                'message'=>'Get Inventory Details successfully',
                'data'=>$data
            ];
        } else {
            $res = [
                'status'=> 'false',
                'message'=>'No Data Found',
                'data'=>[]
            ];
        }
        return $this->response->setJSON($res);
    }
    function submitInventoryDetails()
    {
        $post = $this->request->getVar();
        $db = db_connect();
        $common = new CommonModel($db);

        $invt = new CurrentInventory();
        $cInventory = $invt->where('id',$post['current_inventory_id'])->first();

        $qty = 0;
        foreach($post['details'] as $d) {
            $data = [
                'lot_no'=>$d['lot_no'],
                'dom'=>$d['dom'],
                'expiry_date'=>$d['expiry_date'],
                'qty'=>$d['qty']
            ];
            $qty += $d['qty'];
            $uDetails = $common->UpdateData('current_inventory_details',$d['id'],$data);
        }

        $uQty = ['quantity'=>$qty];
        $uInventory = $common->UpdateData('current_inventory',$post['current_inventory_id'],$uQty);

        $invtData = $invt->where('item_id',$cInventory['item_id'])->where('store_id',$cInventory['store_id'])->selectSum('quantity')->first(); 


        $iPrice = new ItemsPriceModel();
        $getPriceData = $iPrice->where('items_id',$cInventory['item_id'])->where('store_id',$cInventory['store_id'])->first();

        $uPriceData = [
            'current_inventory'=>$invtData['quantity'],
            'inventory_value'=>$invtData['quantity']*$getPriceData['retail_price']
        ];
        $uPrice = $common->UpdateData('items_price',$getPriceData['id'],$uPriceData);

        $res = [
            'status'=> 'true',
            'message'=>'Inventory Data Updated successfully',
        ];
        
        return $this->response->setJSON($res);
    }
    function getTransferStock()
    {
        $sessData = getSessionData();

        $postData = $this->request->getVar();
        
        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        
        $tm = new TransferModel();
        $tmF = new TransferModel();
        $totalRecords = $tm->select('id')
                ->countAllResults();
  
        $tm->select('transfer.*,st.store_name as supply_store,rst.store_name as receiver_store');
        $tm->join('stores as st', 'st.id = transfer.supply_store_id');
        $tm->join('stores rst', 'rst.id = transfer.receiver_store_id');

        if($sessData['role_name'] == "Staff") {
            $tm->where('transfer.supply_store_id',$sessData['store_id']);
            $tm->orWhere('transfer.receiver_store_id',$sessData['store_id']);
        } else if($sessData['role_name'] == "Owner") {
            $tm->where('st.owner_id',$sessData['id']);
            $tm->orWhere('rst.owner_id',$sessData['id']);
        }
      
        if($filter['receiver_store'] != "") {
            $tm->where('receiver_store_id',$filter['receiver_store']);
            $tmF->where('receiver_store_id',$filter['receiver_store']);
        }
        
        if($filter['supply_store'] != "") {
            $tm->where('supply_store_id',$filter['supply_store']);
            $tmF->where('supply_store_id',$filter['supply_store']);
        }
        /*if($filter['search'] != "") {
            $purchase->orLike('stores.store_name',$filter['search'])
                ->orLike('order_number',$filter['search']);
        }*/
        
        /*$tm->where('receiver_store_id',$store_id); 
        $tm->orWhere('supply_store_id',$store_id); */
        $tm->orderBy('transfer.id','desc');
        $records = $tm->findAll($rowperpage, $start);
        $totalRecordwithFilter = $tmF->countAllResults();

        $data = array();
        $tim = new TransferItemsModel();
        foreach($records as $record ){
            $qty = $tim->GetTotalQty($record['id']);

            $data[] = array( 
               "session_store"=>$sessData['store_id'],
               "supply_store"=>$record['supply_store'],
               "receiver_store"=>$record['receiver_store'],
               "id"=>$record['id'],
               "date"=>dateFormat($record['created_at']),
               "quantity"=>$qty['qty'],
               "amount"=>$record['amount'],
               "status"=>$record['status'],
            ); 
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response);
    }
    function getProductionStock()
    {
        $sessData = getSessionData();

        $postData = $this->request->getVar();
        
        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $db = db_connect();
        
        $tm = new ProductionModel();
        $tmF = new ProductionModel();
        $totalRecords = $tmF->select('id')
                ->countAllResults();
  
        $tm->select('production.*,stores.store_name,items.item_name');
        $tm->join('stores', 'production.store_id = stores.id','left');
        $tm->join('items', 'production.item_id = items.id','left');
  
        if($filter['search'] != "") {
            $tm->orLike('stores.store_name',$filter['search'])
                ->orLike('items.item_name',$filter['search']);
        }
        
        $tm->orderBy('production.id','desc');
        $records = $tm->findAll($rowperpage, $start);
        
        $totalRecordwithFilter = $tmF->countAllResults();
        $data = array();

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $records,
            "token" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response);
    }
    function getStockAdjustmentReason()
    {
        $sessData = getSessionData();

        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sim = new StockAdjustmentReasonModel();
        $totalRecords = $sim->select('id')
                ->countAllResults();

        $sim->select('stock_adjustments_reason.*');
   
        if($filter['search'] != "") {
            $sim->orLike('reason',$filter['search']);
        }

        $sim->orderBy('id','desc');
        $records = $sim->findAll($rowperpage, $start);

        $totalRecordwithFilter = count($records);//$simF->countAllResults();
        $data = array();

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $records,
            "token" => csrf_hash() // New token hash
         );

         return $this->response->setJSON($response);
    }
    function getStockAdjustment()
    {
        $sessData = getSessionData();

        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $stockadjustModel = new StockAdjustModel();
        $aiModel = new AdjustmentItemModel();
        $data['stock_adjust'] = $stockadjustModel->GetStockData();
      
        $stockadjustModel = new StockAdjustModel();
        $samF = new StockAdjustModel();
        $totalRecords = $stockadjustModel->select('id')
                ->countAllResults();
        $stockadjustModel->select('stockadjusts.*,stores.store_name,stock_adjustments_reason.reason,location.location_description');
        $stockadjustModel->join('stores', 'stockadjusts.store_id = stores.id');
        $stockadjustModel->join('location', 'stockadjusts.location_id = location.id');
        $stockadjustModel->join('stock_adjustments_reason', 'stock_adjustments_reason.id = stockadjusts.reason_id');

        /*if($sessData['role_name'] == "Staff") {
            $stockadjustModel->where('stockadjusts.store_id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $stockadjustModel->where('stores.owner_id',$sessData['id']);
        }*/
      
        if($filter['reason_id'] != "") {
            $stockadjustModel->where('reason_id',$filter['reason_id']);
            $samF->where('reason_id',$filter['reason_id']);
        }
       
        if($filter['store_id'] != "") {
            $stockadjustModel->where('store_id',$filter['store_id']);
            $samF->where('store_id',$filter['store_id']);
        }
        $stockadjustModel->orderBy('stockadjusts.id','desc');
        $records = $stockadjustModel->findAll($rowperpage, $start);
        $totalRecordwithFilter = $samF->countAllResults();

        $data = array();
        
        foreach($records as $record ){

            $data[] = array( 
               "reason"=>$record['reason'],
               "store_name"=>$record['store_name'],
               "location_description"=>$record['location_description'],
               "narration"=>$record['narration'],
               "date"=>dateFormat($record['created_at']),
               "id"=>$record['id'],
               "status"=>$record['status'],
            ); 
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash() // New token hash
         );

        return $this->response->setJSON($response);
    }
    public function getAdjustmentDataById()
    {
        $id = $this->request->getVar('id');
        $aiModel = new AdjustmentItemModel();
        $data = $aiModel->GetStockSubItemData($id);
        if(!empty($data)){
            return json_encode(['status'=>"true",'message'=>'Fetch Data','data'=>$data]); 
        }else{
            return json_encode(['status'=>"false",'message'=>'No Data Found']); 
        }
    }
    function updateItemStocks($quantity,$item_id,$type){
        $itemModel = new ItemModel();
        $itemObj =  $itemModel->getItemStock($item_id); 
        if($type == 1){
            $total_qty = (int) $itemObj['stock'] + $quantity;
        }else{
            $total_qty = (int) $itemObj['stock'] - $quantity;
        }
        $items_data = array(
            'current_inventory'=>$total_qty,
        );
                            
        $db = db_connect();
        $commonModel = new CommonModel($db);
        $commonModel->UpdateData('items',$item_id,$items_data);

        return true;
                            
    }
    function getStockMovement(){

        $sessData = getSessionData();

        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sim = new StoreItemsModel();
        $simF = new StoreItemsModel();
        $totalRecords = $sim->select('id')->countAllResults();

        $sim->select('store_items.*,items.item_name,stores.store_name,location.location_description as location_type');
        $sim->join('items', 'store_items.item_id = items.id','left');
        $sim->join('stores', 'store_items.store_id = stores.id','left');
        $sim->join('location', 'store_items.location_id = location.id','left');

        if($sessData['role_name'] == "Staff") {
            $sim->where('store_items.store_id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $sim->where('stores.owner_id',$sessData['id']);
        }
      
        if($filter['store_id'] != "") {
            $sim->where('store_items.store_id',$filter['store_id']);
            $simF->where('store_items.store_id',$filter['store_id']);
        }
         if($filter['item_id'] != 0 && $filter['item_id'] != "") {
            $sim->where('item_id',$filter['item_id']);
            $simF->where('item_id',$filter['item_id']);
        } 
        if($filter['date'] != 0 && $filter['date'] != "") {
            $sim->where('DATE_FORMAT(store_items.created_at,"%Y-%m-%d")',$filter['date']);
            $simF->where('DATE_FORMAT(store_items.created_at,"%Y-%m-%d")',$filter['date']);
        }
        if($filter['search'] != "") {
            $sim->orLike('stores.store_name',$filter['search'])
                ->orLike('items.item_name',$filter['search']);
          }
        $sim->orderBy('id','desc');
        $records = $sim->findAll($rowperpage, $start);
        $totalRecordwithFilter = $simF->countAllResults();

        $data = array();
       
        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "store_name"=>$record['store_name'],
               "location_type"=>$record['location_type'],
               "item_name"=>$record['item_name'],
               "date"=>dateFormat($record['created_at'],'d-m-Y'),
               "open_qty" => $record['open_qty'],
               "open_value" => $record['open_value'],
               "received_qty" => $record['received_qty'],
               "received_value" => $record['received_value'],
               "sold_qty" => $record['sold_qty'],
               "sold_value" => $record['sold_value'],
               "adjustment_qty" => $record['adjustment_qty'],
               "adjustment_value" => $record['adjustment_value'],
               "transfer_qty" => $record['transfer_qty'],
               "transfer_value" => $record['transfer_value'],
               "production_qty" => $record['production_qty'],
               "production_value" => $record['production_value'],
               "close_qty" => $record['close_qty'],
               "close_value" => $record['close_value'],
            ); 
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response);
    
    }
   
    public function ViewCurrentStock($id)
    {
        $data = [];
        $data['title'] = 'Edit Item'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items'); 

        $uomModel = new UomModel();
        $data['uom'] = $uomModel->findAll();

        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->GetCategoryData();
        
        $brandmatserModel = new BrandMasterModel();
        $data['brand'] = $brandmatserModel->GetBrandData();

        $modifiersModel = new ModifiersModel();
        $data['modifier'] = $modifiersModel->findAll();

        $taxModel = new TaxesModel();
        $data['tax'] = $taxModel->getTaxData();

        $vmModel = new VariantMatserModel();
        $data['variant'] = $vmModel->findAll();

        $cmModel = new CompositeMasterModel();
        $data['composite'] = $cmModel->findAll();

        $itemModel = new ItemModel();
        $subcategoryModel = new SubcategoryModel();
        $data['item'] = $itemModel->where("id",$id)->first();
        $subcat = $subcategoryModel->GetSubCategoryData($data['item']['category_id']);
        $data['item']['sub_category'] = $subcat;
       
        return $this->template->render('pages/inventory/view_current_stock', $data); 
    }
}
