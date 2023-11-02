<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupplierModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseOrderModel;
use App\Models\CustomersModel;
use App\Models\CategoryModel;
use App\Models\ItemModel;
use App\Models\GoodsReceivedModel;
use App\Models\GoodsReturnedModel;
use App\Models\DirectGoodsReceived;
use App\Models\DirectGoodsReceivedItem;
use App\Models\CurrencyModel;
use App\Models\CurrentInventory;
use App\Models\CurrentInventoryDetails;
use App\Models\BackOrderModel;
use App\Models\Location;
use App\Models\CommonModel;
use App\Models\StoreModel;
use App\Models\StoreItemsModel;
use App\Models\GoodsReceivedItemModel;
use App\Models\GoodsReturnedItemModel;
use App\Models\EmployeeModel;
use App\Models\TaxesModel;
use App\Models\GeneralModel;

class PurchasesController extends BaseController
{
    public function index()
    {   
        $data = [];
        $data['title'] = 'Purchases';
        $sessData = getSessionData();

        $supplierModel = new SupplierModel();
        $data['supplier'] = $supplierModel->findAll();

        $customerModel = new CustomersModel();
        $data['customer'] = $customerModel->findAll();

        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->findAll();

        $Location = new Location();
        $data['location'] = $Location->where('status',1)->findAll();
        
        $storeModel = new StoreModel();
        if($sessData['role_name'] == "Staff") {
            $storeModel->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $storeModel->where('pos_id',$sessData['pos_id']);
        }
        $data['stores'] = $storeModel->findAll();
        
        return $this->template->render('pages/purchases/purchase_order', $data); 
    }
    
    public function Add_Supplier()
    {
        $data = [];
        $data['title'] = 'Add Supplier'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases'); 
        return $this->template->render('pages/purchases/supplier_order_add', $data);
    }

    public function Edit_Supplier($id)
    {
        $data = [];
        $data['title'] = 'Edit Supplier'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $supplierModel = new SupplierModel();
        $data['supplier'] = $supplierModel->where("id",$id)->first(); 
        return $this->template->render('pages/purchases/supplier_order_add', $data);
    }

    public function Add_Purchase_Order()
    {
        $data = [];
        $data['title'] = 'Add Purchase Order'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string(); 
        
        $sessData = getSessionData();
      
        $customer = new CustomersModel();
        $data['customers'] = $customer->where('status',1)->findAll();

        $supplier = new SupplierModel();
        $data['supplier'] = $supplier->where('status',1)->findAll();

        $category = new CategoryModel();
        $data['category'] = $category->where('status',1)->findAll();
        
        $store = new StoreModel();
        $items = new ItemModel();
        $currencyModel = new CurrencyModel();

        $store->where('pos_id',$sessData['pos_id']);
        $currencyModel->where('pos_id',$sessData['pos_id']);

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $data['stores'] = $store->findAll();
        
        $itemlist = $items->getCanPurchaseItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        $purchaseModel = new PurchaseModel();
        $purchaseModel->where('pos_id',$sessData['pos_id']);
        $orderNo = $purchaseModel->findAll();
        $data['order_number'] = count($orderNo) + 1;

        $data['s_name'] = $store->select('store_name')->where('id',$sessData['store_id'])->first();
        $currencyModel->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        $tax = new TaxesModel();
        $taxes = $tax->GetTaxMasterData();
        $data['taxlist'] = json_encode($taxes);

        $location = new Location();
        $data['location'] = $location->select('id, location_description')->whereIn('pos_id',[0,$sessData['pos_id']])->where('status',1)->findAll();

        return $this->template->render('pages/purchases/purchase_order_add', $data);
    }
    
    public function Edit_Purchase_Order($id)
    {
        $data = [];
        $data['title'] = 'Edit Purchase Order'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string(); 
        
        $sessData = getSessionData();
        
        $purchaseModel = new PurchaseModel();
        $data['purchase'] = $purchaseModel->select('purchaseorders.*, c.currency_code')->join('currencies c','purchaseorders.currency_id = c.id','left')->where("purchaseorders.id",$id)->first();

        $purchaseitems = new PurchaseOrderModel();
        $data['purchaseitems'] = $purchaseitems->select('purchase_order_item.*, items.item_options')->join('items','purchase_order_item.item_id = items.id','left')->where('p_o_id',$id)->findAll();

        $customer = new CustomersModel();
        $data['customers'] = $customer->findAll();
        
        $store = new StoreModel();
        $currencyModel = new CurrencyModel();
        $store->where('pos_id',$sessData['pos_id']);
        $currencyModel->where('pos_id',$sessData['pos_id']);

        $data['stores'] = $store->findAll();
        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $data['s_name'] = $store->select('store_name')->where('id',$sessData['store_id'])->first();
        $currencyModel->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();
        
        $supplier = new SupplierModel();
        $data['supplier'] = $supplier->findAll();

        $category = new CategoryModel();
        $data['category'] = $category->findAll();

        $items = new ItemModel();
        $itemlist = $items->getCanPurchaseItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);
        
        $tax = new TaxesModel();
        $taxes = $tax->GetTaxMasterData();
        $data['taxlist'] = json_encode($taxes);

        $location = new Location();
        $data['location'] = $location->select('id, location_description')->whereIn('pos_id',[0,$sessData['pos_id']])->where('status',1)->findAll();

        return $this->template->render('pages/purchases/purchase_order_add', $data);
    }
    public function ViewPurchaseOrder($id)
    {
        $data = [];
        $data['title'] = 'View Purchase Order'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();

        $sessData = getSessionData();
        
        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }
        
        $purchaseOrderModel = new PurchaseModel();
        $data['goods_purchase'] = $purchaseOrderModel->GetPurchaseDataByOrderId($id);
        $order_id = $data['goods_purchase']['id'];
        $currModel = new CurrencyModel();
        $data['currency'] = $currModel->where('id',$data['goods_purchase']['currency_id'])->first();
        $PurchaseItemsModel = new PurchaseOrderModel();
        $data['purchase_items'] = $PurchaseItemsModel->GetPurchaseItemsData($order_id);
        
        // return $this->template->render('pages/purchases/purchase_order_view', $data);
        return json_encode([
            "status" => "true",
            "data" => $data
        ]);
    }
    public function Add_Goods_Received()
    {
        $data = [];
        $data['title'] = 'Add Goods Received';
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();
        
        $sessData = getSessionData();

        $store = new StoreModel();
        if($sessData['role_name'] == "Staff") {
            $store->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $store->where('pos_id',$sessData['pos_id']);
        }
        $data['stores'] = $store->findAll();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $currencyModel = new CurrencyModel();
        $currencyModel->where('pos_id',$sessData['pos_id'])->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        $customer = new CustomersModel();
        $data['customers'] = $customer->findAll();

        $supplier = new SupplierModel();
        $data['supplier'] = $supplier->findAll();
        
        $location = new Location();
        $data['location'] = $location->where('status',1)->findAll();
        
        $purchase = new PurchaseModel();
        $data['order_number'] = $purchase->GetReceivedOrderStatus($sessData['store_id']);

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['store_id']);
        $data['items'] = json_encode($itemlist);
        
        return $this->template->render('pages/purchases/goods_received_add', $data);
    }

    public function Edit_Goods_Received($id)
    {
        $data = [];
        $data['title'] = 'Edit Goods Received'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();

        $sessData = getSessionData();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $store = new StoreModel();
        if($sessData['role_name'] == "Staff") {
            $store->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $store->where('pos_id',$sessData['pos_id']);
        }
        $data['stores'] = $store->findAll();

        $currencyModel = new CurrencyModel();
        $currencyModel->where('pos_id',$sessData['pos_id'])->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        $goodsreceivedModel = new GoodsReceivedModel();
        $data['goods_received'] = $goodsreceivedModel->getGoodsReceivedDataById($id);
        $order_id = $data['goods_received']['p_o_id'];

        $PurchaseItemsModel = new PurchaseOrderModel();
        $data['goods_received_items'] = $PurchaseItemsModel->GetPurchaseItemsData($order_id);
       
        $customer = new CustomersModel();
        $data['customers'] = $customer->findAll();

        $supplier = new SupplierModel();
        $data['supplier'] = $supplier->findAll();
        
        $location = new Location();
        $data['location'] = $location->where('status',1)->findAll();

        $purchase = new PurchaseModel();
        $data['order_number'] = $purchase->GetPurchaseOrderStatus();

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        return $this->template->render('pages/purchases/goods_received_add', $data);
    }

    public function Add_Goods_Rec($id)
    {
        $data = [];
        $data['title'] = 'Add Goods Received';
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();
        
        $sessData = getSessionData();

        $store = new StoreModel();
        if($sessData['role_name'] == "Staff") {
            $store->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $store->where('pos_id',$sessData['pos_id']);
        }
        $data['stores'] = $store->findAll();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $currencyModel = new CurrencyModel();
        $currencyModel->where('pos_id',$sessData['pos_id'])->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        $customer = new CustomersModel();
        $data['customers'] = $customer->findAll();

        $supplier = new SupplierModel();
        $data['supplier'] = $supplier->findAll();
        
        $location = new Location();
        $data['location'] = $location->where('status',1)->findAll();
        
        $purchase = new PurchaseModel();
        $data['purchase'] = $purchase->where('id',$id)->first();
        $data['goods_received'] = [
            'id' => '',
            'p_o_id' => $data['purchase']['id'],
            'store_id' => $data['purchase']['store_id'],
            'location_id' => $data['purchase']['location_id'],
            'supplier_id' => $data['purchase']['supplier_id'],
            'date' => $data['purchase']['date'],
            'terms' => $data['purchase']['terms'],
            'due_date' => $data['purchase']['due_date'],
            'currency_id' => $data['purchase']['currency_id'],
            'currency_rate' => $data['purchase']['currency_rate'],
            'total_tax' => $data['purchase']['total_tax'],
            'total_discount' => $data['purchase']['total_discount'],
            'sub_total' => $data['purchase']['sub_total'],
            'adjustment_value' => $data['purchase']['adjustment_value'],
            'total_amount' => $data['purchase']['total_amount']
        ];
        $data['order_number'] = $purchase->select('id, order_number')->where('id',$id)->findAll();

        $purchaseItem = new PurchaseOrderModel();
        $data['goods_received_items'] = $purchaseItem->where('p_o_id',$id)->findAll();
        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['store_id']);
        $data['items'] = json_encode($itemlist);
        
        return $this->template->render('pages/purchases/goods_received_add', $data);
    }
    public function View_Goods_Received($id)
    {
        $data = [];
        $data['title'] = 'View Goods Received'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();

        $goodsreceivedModel = new GoodsReceivedModel();
        $data['goods_received'] = $goodsreceivedModel->getGoodsReceivedDataById($id);

        $order_id = $data['goods_received']['p_o_id'];
        $PurchaseItemsModel = new PurchaseOrderModel();
        $data['goods_received_items'] = $PurchaseItemsModel->GetPurchaseItemsData($order_id);
        
        return $this->template->render('pages/purchases/goods_received_view', $data);
    }
    public function Add_Direct_Goods_Received()
    {
        $data = [];
        $data['title'] = 'Direct Goods Received';
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();
        
        $sessData = getSessionData();

        $store = new StoreModel();
        if($sessData['role_name'] == "Staff") {
            $store->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $store->where('pos_id',$sessData['pos_id']);
        }
        $data['stores'] = $store->findAll();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $supplier = new SupplierModel();
        $data['supplier'] = $supplier->findAll();
        
        $location = new Location();
        $data['location'] = $location->where('status',1)->findAll();

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['store_id']);
        $data['items'] = json_encode($itemlist);
        
        return $this->template->render('pages/purchases/direct_goods_received_add', $data);
    }
    public function View_Direct_Goods_Received($id)
    {
        $data = [];
        $data['title'] = 'View Direct Goods Received'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();

        $receivedMdl = new DirectGoodsReceived();
        $data['goods_received'] = $receivedMdl->getGoodsReceivedDataById($id);

        $itemsMdl = new DirectGoodsReceivedItem();
        $data['goods_received_items'] = $itemsMdl->GetReceivedItemsData($id);
        
        return $this->template->render('pages/purchases/direct_goods_received_view', $data);
    }
    public function Add_Goods_Returned()
    {
        $data = [];
        $data['title'] = 'Add Goods Returned'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();
        
        $sessData = getSessionData();

        $store = new StoreModel();
        if($sessData['role_name'] == "Staff") {
            $store->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $store->where('pos_id',$sessData['pos_id']);
        }
        
        $data['stores'] = $store->findAll();
        
        $customer = new CustomersModel();
        $data['customers'] = $customer->findAll();

        $category = new CategoryModel();
        $data['category'] = $category->findAll();

        $supplier = new SupplierModel();
        $data['supplier'] = $supplier->findAll();
        
        $purchase = new PurchaseModel();
        $data['purchase'] = $purchase->select('id,order_number')->where('order_status',3)->findAll();

        $location = new Location();
        $data['location'] = $location->where('status',1)->findAll();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $currencyModel = new CurrencyModel();
        $currencyModel->where('pos_id',$sessData['pos_id'])->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        return $this->template->render('pages/purchases/goods_returned_add', $data);
    
    }

    public function Edit_Goods_Returned($id)
    {
        $data = [];
        $data['title'] = 'Edit Goods Returned'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();

        $session = session();
        $user_id = $session->get('id');
        $empModel = new EmployeeModel();
        $data['emp'] = $empModel->GetEmployeeData($user_id);
        $data['store_id'] = "";

        $store = new StoreModel();
        if(!empty($data['emp']['stores'])){
            $data['store_id'] = $data['emp']['stores'][0]['store_id'];
            $data['stores'] = $store->where('id',$data['store_id']);
        }
        $data['stores'] = $store->findAll();
        
        $goodsreturnedModel = new GoodsReturnedModel();
        $data['goods_returned'] = $goodsreturnedModel->where('id',$id)->first();

        $category = new CategoryModel();
        $data['category'] = $category->findAll();

        $customer = new CustomersModel();
        $data['customers'] = $customer->findAll();
        
        $supplier = new SupplierModel();
        $data['supplier'] = $supplier->findAll();
        
        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $currencyModel = new CurrencyModel();
        $currencyModel->where('pos_id',$sessData['pos_id'])->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        return $this->template->render('pages/purchases/goods_returned_add', $data);
    }

    public function Add_Back_Order()
    {
        $data = [];
        $data['title'] = 'Add Back Order'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();
        $sessData = getSessionData();

        $category = new CategoryModel();
        $data['category'] = $category->findAll();

        $customer = new CustomersModel();
        $data['customers'] = $customer->findAll();

        $supplier = new SupplierModel();
        $data['supplier'] = $supplier->findAll();
        
        $store = new StoreModel();
        $data['stores'] = $store->findAll();

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $items = new ItemModel();
        $itemlist = $items->getCanPurchaseItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);
        
        $currency = new CurrencyModel();
        $data['currency'] = $currency->findAll();
        return $this->template->render('pages/purchases/back_order_add', $data);
    }

    public function Edit_Back_Order($id)
    {
        $data = [];
        $data['title'] = 'Edit Back Order'; 
        $data['main_menu'] = 'Purchases'; 
        $data['main_menu_url'] = base_url('purchases');
        $data['url'] = uri_string();
        $sessData = getSessionData();

        $backorderModel = new BackOrderModel();
        $data['back_order'] = $backorderModel->where('id',$id)->first();

        $category = new CategoryModel();
        $data['category'] = $category->findAll();

        $customer = new CustomersModel();
        $data['customers'] = $customer->findAll();
        
        $store = new StoreModel();
        $data['stores'] = $store->findAll();
        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $supplier = new SupplierModel();
        $data['supplier'] = $supplier->findAll();

        $items = new ItemModel();
        $itemlist = $items->getCanPurchaseItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);
        
        $currency = new CurrencyModel();
        $data['currency'] = $currency->findAll();

        $db = db_connect();
        $builder = $db->table('back_order_item');
        $data['backorder_items'] = $builder->where('b_o_id',$id)->get();
        p($data);
        return $this->template->render('pages/purchases/back_order_add', $data);
    }
    
    public function get_Item_Detail()
    {
        $post = $this->request->getVar();
        $sessData = getSessionData();

        $item = new ItemModel();
        $check = $item->where('id',$post['id'])->first();
        if($check['item_type'] == 4) {
            $items = $item->select('items.sku_barcode,items_price.supply_price,items.current_inventory,items_price.retail_price, i.uom_id, i.tax_id,u.uom,t.id, t.tax_rate, tm.tax_type,items.item_options')
             ->join('items_price', 'items.id = items_price.items_id')
             ->join('items i','items.item_master_id = i.id')
             ->join('uom_master u', 'i.uom_id = u.id','left')
             ->join('taxes t', 'i.tax_id = t.id')
             ->join('tax_master tm', 't.tax_type_id = tm.id')
             ->where('items_price.store_id',$sessData['store_id'])
             ->where('items.id', $post['id'])->first();
         } else {
            $items = $item->select('items.sku_barcode,items_price.supply_price,items.current_inventory,items_price.retail_price, items.uom_id, items.tax_id,u.uom,t.id, t.tax_rate, tm.tax_type,items.item_options')
                 ->join('items_price', 'items.id = items_price.items_id')
                 ->join('uom_master u', 'items.uom_id = u.id','left')
                 ->join('taxes t', 'items.tax_id = t.id')
                 ->join('tax_master tm', 't.tax_type_id = tm.id')
                 ->where('items_price.store_id',$sessData['store_id'])
                 ->where('items.id', $post['id'])->first();
        }

        $qty = 0;
        $detailData = [];
        if(isset($post['location_id']) && isset($post['supply_store_id'])) {
            $inventory = new CurrentInventory();
            $inventoryData = $inventory->where('item_id',$post['id'])->where('store_id',$post['supply_store_id'])->where('location_id',$post['location_id'])->first();
            if(!empty($inventoryData)) {
                $qty = $inventoryData['quantity'];

                $details = new CurrentInventoryDetails();
                $detailData = $details->where('current_inventory_id',$inventoryData['id'])->where('qty >',0)->findAll();
            }
        }
        return json_encode([
            "status" => "true",
            "data" => $items,
            "qty"=> $qty,
            "details"=>$detailData
        ]);

    }

    public function Post_Data_Purchase()
    {
        if ($this->request->getMethod() == "post") 
        {
                $sessData = getSessionData();
                $id = $sessData['id'];

                $post = $this->request->getVar();

                switch($post['table_name']){
                    case 'suppliers':
                            $data = [
                                'pos_id' => $sessData['pos_id'],
                                'user_id' => $id,
                                'registered_name' => isset($post["registered_name"])?$post["registered_name"]:0,
                                'tax_amount_name' => isset($post["tax_amount_name"])?$post["tax_amount_name"]:0,
                                'operator' => isset($post["operator"])?$post["operator"]:0,
                                'payable' => isset($post["payable"])?$post["payable"]:0,
                                'email' => isset($post["email"])?$post["email"]:0,
                                'country_code' =>isset($post["country_code"])?$post["country_code"]:0,
                                'phone' => isset($post["phone"])?$post["phone"]:0,
                                'address' => isset($post["address"])?$post["address"]:0,
                                'date' => isset($post["date"])?$post["date"]:0,
                                // 'status_type' => isset($post["status_type"])?$post["status_type"]:2,
                                'status' => isset($post["status"])?$post["status"]:1
                            ];
                    break;
                    case 'purchaseorders':
                        $total_tax = 0;
                        if(isset($post["is_include_tax"]) && $post["is_include_tax"] == 1)
                        {
                            $total_tax = $post['total_tax'];
                        }
                        $data = [
                            'user_id' => $id,
                            'pos_id' => $sessData['pos_id'],
                            'store_id' => isset($post["store_id"])?$post["store_id"]:0,
                            'category_id' => isset($post["category_id"])?$post["category_id"]:0,
                            'supplier_id' => isset($post["supplier_id"])?$post["supplier_id"]:0,
                            'order_number' => isset($post["order_number"])?$post["order_number"]:0,
                            'is_include_tax' => isset($post["is_include_tax"])?$post["is_include_tax"]:0,
                            'terms' => isset($post["terms"])?$post["terms"]:"",
                            'due_date' => isset($post["due_date"])?$post["due_date"]:"0",
                            'base_currency_id' => $post['base_currency_id'],
                            'currency_id' => isset($post["currency_id"])?$post["currency_id"]:"0",
                            'currency_rate' => isset($post["currency_rate"])?$post["currency_rate"]:"0",
                            'location_id' => isset($post['location'])?$post['location']:"",
                            'order_status' => isset($post["order_status"])?$post["order_status"]:0,
                            'total_tax' => $post['total_tax'],
                            'currency_tax' => $post['currency_tax'],
                            'total_discount' => isset($post["total-discount"])?$post["total-discount"]:0,
                            'currency_discount' => isset($post['currency_discount'])?$post['currency_discount']:"0",
                            'sub_total'  => isset($post['sub_total'])?$post['sub_total']:"0",
                            'sub_curr_total' => isset($post['sub_curr_total'])?$post['sub_curr_total']:"0",
                            'total_amount' => $post['total_amount'],
                            'currency_total' => $post['conv_total_amount'],
                            'adjustment_value' => $post['adjustment_value'],
                            'customer_note' => $post['notes'],
                            'date' => isset($post['date'])?$post['date']:""
                        ];
                        if($post['is_received'] == "1") {
                            $data['order_status'] = 3;
                        }
                    break;
                    case 'goods_received': 
                     $total_tax = 0;
                       /* if(isset($post["is_include_tax"]) && $post["is_include_tax"] == 1){
                            $total_tax = $post['total_tax'];
                        }*/
                        $data = [
                            'user_id' => $id,
                            'p_o_id' => isset($post["order_number"])?$post["order_number"]:0,
                            'location_id' => isset($post["location"])?$post["location"]:0,
                            'received_note' => isset($post["received_note"])?$post["received_note"]:"",
                            'total_tax' => $post['total_tax'],
                            'sub_total' => $post['sub_total'],
                            'total_amount' => $post['total_amount'],
                            'adjustment_value' => $post['adjustment_value'],
                            'status' => isset($post['status_type'])?$post['status_type']:4
                        ];
                          
                    break;
                    case 'goods_returned':
                        $total_tax = 0;
                        if(isset($post["is_include_tax"]) && $post["is_include_tax"] == 1){
                            $total_tax = $post['total_tax'];
                        }
                        $data = [
                            'user_id' => $id,
                            'p_o_id' => isset($post["order_number"])?$post["order_number"]:0,
                            'returned_note' => isset($post["returned_note"])?$post["returned_note"]:"",
                            'total_tax' => $total_tax,
                            'sub_total' => $post['sub_total'],
                            'total_amount' => $post['total_amount'],
                            'adjustment_value' => $post['adjustment_value'],
                        ]; 
                    break;
                    case 'direct_goods_received':
                        $data = [
                            'pos_id'=>$sessData['pos_id'],
                            'store_id'=>$post['store_id'],
                            'location_id'=>$post['location'],
                            'supplier_id'=>$post['supplier_id'],
                            'total_tax' => $post['total_tax'],
                            'sub_total' => $post['sub_total'],
                            'adjustment_value' => $post['adjustment_value'],
                            'total_amount' => $post['total_amount'],
                            'received_note' => isset($post["notes"])?$post["notes"]:"",
                            'date'=>isset($post['received_date'])?$post['received_date']:date('Y-m-d')
                        ]; 
                    break;
                    case 'back_order':
                            $data = [
                                'customer_id' => isset($post["customer_id"])?$post["customer_id"]:0,
                                'category_id' => isset($post["category_id"])?$post["category_id"]:0,
                                'supplier_id' => isset($post["supplier_id"])?$post["supplier_id"]:0,
                                'order_number' => isset($post["order_number"])?$post["order_number"]:0,
                                'currency_id' => isset($post["currency_id"])?$post["currency_id"]:0,
                                'due_date' => isset($post["due_date"])?$post["due_date"]:0
                            ];
                          
                    break;
                }
                $db = db_connect();
                $commonModel = new CommonModel($db);

                if(isset($post['id']) && empty($post['id']))
                {
                    $result = $commonModel->AddData($post['table_name'],$data);

                    switch($post['table_name']){
                        case 'purchaseorders':
                            if($post['is_received'] == "1") {
                                $goodsRecData = [
                                    'user_id' => $id,
                                    'p_o_id' => isset($post["order_number"])?$post["order_number"]:0,
                                    'location_id' => isset($post["location"])?$post["location"]:0,
                                    'total_tax' => $post['total_tax'],
                                    'sub_total' => $post['sub_total'],
                                    'total_amount' => $post['total_amount'],
                                    'adjustment_value' => $post['adjustment_value'],
                                    'status' => 3
                                ];
                                $addGoodsRec = $commonModel->AddData('goods_received',$goodsRecData);

                                foreach($post['items'] as $item) {
                                    
                                    $items = array(
                                        'p_o_id' => $result,
                                        'item_id' => $item['item_id'],
                                        'serial_no' => isset($item['serial_no'])?$item['serial_no']:'',
                                        'uom_id' => $item['uomid'],
                                        'uom_value' => $item['uom'],
                                        'qty' => $item['quantity'],
                                        'received_qty' => $item['quantity'],
                                        'rate' => $item['rate'],
                                        'discount' => $item['discount'],
                                        'discount_type' => $item['discount_type'],
                                        'tax_value' => $item['tax'],
                                        'tax_name' => $item['tax_type'],
                                        'tax_amount' => isset($item['tax_amount'])?$item['tax_amount']:"",
                                        'lot_no' => isset($item['lot_no'])?$item['lot_no']:"",
                                        'dom' => isset($item['dom'])?$item['dom']:"",
                                        'expiry_date' => isset($item['expiry_date'])?$item['expiry_date']:"",
                                        'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                                        'discount_amount' => $item['discount_amount'],
                                        'total_amount' => $item['amount'] - $item['discount_amount'],
                                        'item_amount' => $item['amount'],
                                    );

                                    $addOrderItem = $commonModel->AddData('purchase_order_item',$items);

                                    $items2 = array(
                                        'p_o_id' => $post['order_number'],
                                        'goods_received_id'=>$addGoodsRec,
                                        'order_item_id' => $addOrderItem,
                                        'received_qty' => $item['quantity'],
                                        'rejected_qty' => 0,
                                    );

                                    $addgoodRecItem = $commonModel->AddData('goods_received_items',$items2);

                                    if($item['quantity'] != "" || $item['quantity'] != "0"){
                                      
                                        $storeItemModel = new StoreItemsModel();
                                        $store_data = [
                                            'pos_id'=>$sessData['pos_id'],
                                            'item_id'=>$item['item_id'],
                                            'store_id'=>$post['store_id'],
                                            'qty'=>$item['quantity'],
                                            'location_id'=>$post['location'],
                                            'type'=>'received'
                                        ];
                                        $lot_data = [
                                            'p_o_id'=>$result,
                                            'p_item_id'=>$addOrderItem,
                                            'lot_no' => isset($item['lot_no'])?$item['lot_no']:"",
                                            'dom' => isset($item['dom'])?$item['dom']:"",
                                            'expiry_date' => isset($item['expiry_date'])?$item['expiry_date']:"",
                                            'qty'=>$item['quantity']
                                        ];
                                        $store_item = $storeItemModel->receivedItem($store_data,$lot_data);
                                        // $this->updateItemStocks($item['received_qty'],$item['item_id'],1);
                                    }
                                }
                            } else {
                                foreach($post['items'] as $item) {
                                    $quantity = (int) $item['quantity'];
                                    $total_tax_mount = 0;
                                    if(isset($post["is_include_tax"]) && $post["is_include_tax"] == 1){
                                        $total_tax_mount = $item['tax_amount'];
                                    }
                                    $items = array(
                                        'p_o_id' => $result,
                                        'item_id' => $item['item_id'],
                                        'serial_no' => isset($item['serial_no'])?$item['serial_no']:'',
                                        'uom_id' => $item['uomid'],
                                        'uom_value' => $item['uom'],
                                        'qty' => $item['quantity'],
                                        'rate' => $item['rate'],
                                        'discount' => $item['discount'],
                                        'discount_type' => $item['discount_type'],
                                        'tax_value' => $item['tax'],
                                        'tax_name' => $item['tax_type'],
                                        'tax_amount' => isset($item['tax_amount'])?$item['tax_amount']:"",
                                        'lot_no' => isset($item['lot_no'])?$item['lot_no']:"",
                                        'dom' => isset($item['dom'])?$item['dom']:"",
                                        'expiry_date' => isset($item['expiry_date'])?$item['expiry_date']:"",
                                        'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                                        'discount_amount' => $item['discount_amount'],
                                        'total_amount' => $item['amount'] - $item['discount_amount'],
                                        'item_amount' => $item['amount'],
                                    );

                                    $addOrderItem = $commonModel->AddData('purchase_order_item',$items);
                                }
                            }
                            break;
                        case 'goods_received':
                            $flg = false;
                            $rec = false;
                            foreach($post['items'] as $item) {
                                
                                $poItems = new PurchaseOrderModel();
                                $items = $poItems->where('id',$item['order_item_id'])->first();

                                if($item['received_qty'] > 0 && ($item['qty'] == $item['received_qty'] || ((int)$items['received_qty']+(int)$item['received_qty']) == $item['qty'])) {
                                    $rec = true;
                                    $flg = true;
                                } else if($item['received_qty'] == 0) {
                                    $rec = true;
                                    $flg = true;
                                }

                                /*if($item['rejected_qty'] != "" || $item['rejected_qty'] > 0){
                                    $storeItemModel = new StoreItemsModel();
                                    $store_data = [
                                        'item_id'=>$item['item_id'],
                                        'store_id'=>$post['store_id'],
                                        'location_id'=>$post['location'],
                                        'qty'=>$item['rejected_qty'],
                                        'type'=>'rejected'
                                    ];
                                    $store_item = $storeItemModel->GetStoreItemId($store_data);
                                    // $this->updateItemStocks($item['rejected_qty'],$item['item_id'],2);
                                }*/

                                $items1 = array(
                                        'received_qty' => (int)$item['received_qty']+(int)$item['old_received_qty'],
                                        'rejected_qty' => (int)$item['rejected_qty'],
                                    );

                                $updateOrderItem = $commonModel->UpdateData('purchase_order_item',$item['order_item_id'],$items1);
                                
                                $items2 = array(
                                        'p_o_id' => $post['order_number'],
                                        'goods_received_id'=>$result,
                                        'order_item_id' => $item['order_item_id'],
                                        'received_qty' => $item['received_qty'],
                                        'rejected_qty' => $item['rejected_qty'],
                                    );

                                $addOrderItem = $commonModel->AddData('goods_received_items',$items2);

                                if($item['received_qty'] != "" || $item['received_qty'] != "0"){
                                      
                                    $storeItemModel = new StoreItemsModel();
                                    $store_data = [
                                        'pos_id'=>$sessData['pos_id'],
                                        'item_id'=>$item['item_id'],
                                        'store_id'=>$post['store_id'],
                                        'location_id'=>$post['location'],
                                        'qty'=>$item['received_qty'],
                                        'type'=>'received'
                                    ];
                                    $lot_data = [
                                        'p_o_id'=>$post["order_number"],
                                        'p_item_id'=>$item['order_item_id'],
                                        'lot_no' => isset($items['lot_no'])?$items['lot_no']:"",
                                        'dom' => isset($items['dom'])?$items['dom']:"",
                                        'expiry_date' => isset($items['expiry_date'])?$items['expiry_date']:"",
                                        'qty'=>$items1['received_qty']
                                    ];

                                    $store_item = $storeItemModel->receivedItem($store_data,$lot_data);
                                    // $this->updateItemStocks($item['received_qty'],$item['item_id'],1);
                                }
                              
                            }
                            $data = array();
                            if($rec) {
                                $data = array(
                                    'order_status' => 3
                                );
                                $grData = array(
                                    'status'=>3
                                );
                                $db->table('goods_received')->where('p_o_id',$post["order_number"])->set($grData)->update();
                            } else {
                                $data = array(
                                    'order_status' => 4
                                );
                            }
                            
                            $result = $commonModel->UpdateData('purchaseorders',$post['order_number'],$data);
                        break;
                        case 'direct_goods_received':
                            foreach($post['items'] as $item) {
                                
                                $items = array(
                                    'direct_received_id' => $result,
                                    'item_id' => $item['item_id'],
                                    'serial_no' => isset($item['serial_no'])?$item['serial_no']:'',
                                    'uom_id' => $item['uomid'],
                                    'uom_value' => $item['uom'],
                                    'qty' => $item['quantity'],
                                    'received_qty' => $item['quantity'],
                                    'rate' => $item['rate'],
                                    'discount' => $item['discount'],
                                    'discount_type' => $item['discount_type'],
                                    'tax_value' => $item['tax'],
                                    'tax_name' => $item['tax_type'],
                                    'tax_amount' => isset($item['tax_amount'])?$item['tax_amount']:"",
                                    'lot_no' => isset($item['lot_no'])?$item['lot_no']:"",
                                    'dom' => isset($item['dom'])?$item['dom']:"",
                                    'expiry_date' => isset($item['expiry_date'])?$item['expiry_date']:"",
                                    'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                                    'discount_amount' => $item['discount_amount'],
                                    'total_amount' => $item['amount'] - $item['discount_amount'],
                                    'item_amount' => $item['amount'],
                                );

                                $addOrderItem = $commonModel->AddData('direct_goods_received_item',$items);

                                if($item['quantity'] != "" || $item['quantity'] != "0"){
                                  
                                    $storeItemModel = new StoreItemsModel();
                                    $store_data = [
                                        'pos_id'=>$sessData['pos_id'],
                                        'item_id'=>$item['item_id'],
                                        'store_id'=>$post['store_id'],
                                        'qty'=>$item['quantity'],
                                        'location_id'=>$post['location'],
                                        'type'=>'received'
                                    ];
                                    $lot_data = [
                                        'p_o_id'=>"",
                                        'p_item_id'=>"",
                                        'lot_no' => isset($item['lot_no'])?$item['lot_no']:"",
                                        'dom' => isset($item['dom'])?$item['dom']:"",
                                        'expiry_date' => isset($item['expiry_date'])?$item['expiry_date']:"",
                                        'qty'=>$item['quantity']
                                    ];
                                    $store_item = $storeItemModel->directReceivedItem($store_data,$lot_data);
                                    // $this->updateItemStocks($item['received_qty'],$item['item_id'],1);
                                }
                            }
                        break;
                        case 'goods_returned':
                            foreach($post['items'] as $item) { 
                                if($item['returned_qty'] !== ""){
                                    $storeItemModel = new StoreItemsModel();
                                    $store_data = [
                                        'pos_id'=>$sessData['pos_id'],
                                        'item_id'=>$item['item_id'],
                                        'store_id'=>$post['store_id'],
                                        'location_id'=>$post['location'],
                                        'qty'=>$item['returned_qty'],
                                        'type'=>'returned'
                                    ];
                                    $lot_data = [
                                        'p_o_id'=>$post['order_number'],
                                        'p_item_id'=>$item['order_item_id'],
                                        'qty'=>abs($item['received_qty'] - ((int)$item['returned_qty'] + (int)$item['old_returned_qty']))
                                    ];
                                    $store_item = $storeItemModel->returnedItem($store_data,$lot_data);

                                    $items = array(
                                       'returned_qty' => (int)$item['returned_qty'] + (int)$item['old_returned_qty'],
                                    );
                                    
                                    $updateOrderItem = $commonModel->UpdateData('purchase_order_item',$item['order_item_id'],$items);
                                   
                                    $db = db_connect();
                                    $CommonModel = new CommonModel($db);
                                    $items2 = array(
                                            'p_o_id' => $post['order_number'],
                                            'order_item_id' => $item['order_item_id'],
                                            'qty' => $item['returned_qty'],
                                        );
                                   
                                    $addOrderItem = $commonModel->AddData('goods_returned_items',$items2);
                                    // $this->updateItemStocks($item['returned_qty'],$item['item_id'],2);
                                }
                            }
                        break;
                    }

                    return json_encode([
                        "status" => "true",
                        "message" => "New Data added successfully",
                    ]);
                }
                else{ 
                    $id = $post['id'];
                    if(isset($data) && !empty($data)){
                         $result = $commonModel->UpdateData($post['table_name'],$id,$data);
                    }

                    switch($post['table_name']){
                        case 'purchaseorders':
                             

                            foreach($post['items'] as $item) { 
                                $total_tax_mount = 0;
                                 if(isset($post["is_include_tax"]) && $post["is_include_tax"] == 1){
                                    $total_tax_mount = $item['tax_amount'];
                                }
                               
                                $items = array(
                                        'p_o_id' => $id,
                                        'item_id' => $item['item_id'],
                                        'serial_no' => isset($item['serial_no'])?$item['serial_no']:'',
                                        'uom_id' => $item['uomid'],
                                        'uom_value' => $item['uom'],
                                        'qty' => $item['quantity'],
                                        'rate' => $item['rate'],
                                        'discount' => $item['discount'],
                                        'discount_type' => $item['discount_type'],
                                        'tax_value' => $item['tax'],
                                        'tax_name' => $item['tax_type'],
                                        'tax_amount' => $item['tax_amount'],
                                        'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                                        'discount_amount' => $item['discount_amount'],
                                        'lot_no' => isset($item['lot_no'])?$item['lot_no']:"",
                                        'dom' => isset($item['dom'])?$item['dom']:"",
                                        'expiry_date' => isset($item['expiry_date'])?$item['expiry_date']:"",
                                        'total_amount' => $item['amount'] - $item['discount_amount'],
                                        'item_amount' => $item['amount'],
                                    );
                               
                                if(isset($item['id'])) {
                                    $updateOrderItem = $commonModel->UpdateData('purchase_order_item',$item['id'],$items);
                                } else {
                                    $addOrderItem = $commonModel->AddData('purchase_order_item',$items);
                                }
                            }
                            
                        break;
                    case 'goods_returned':
                    
                        foreach($post['items'] as $item) {
                            if($item['return_qty'] !== ""){
                            $items = array(
                                   'qty' => (int)$item['quantity'] - (int)$item['return_qty'],
                                   'returned_qty' => (int)$item['return_qty'] + (int)$item['returned_quantity'],
                                     );
                            $updateOrderItem = $commonModel->UpdateData('purchase_order_item',$item['order_item_id'],$items);
                           
                            $db = db_connect();
                            $CommonModel = new CommonModel($db);
                            $items2 = array(
                                    'order_number' => $post['order_number'],
                                    'order_item_id' => $item['order_item_id'],
                                    'qty' => $item['return_qty'],
                                );

                            $addOrderItem = $commonModel->AddData('goods_returned_items',$items2);
                          }
                        }
                    break;
                    case 'goods_received':
                       
                        foreach($post['items'] as $item) {
                            if($item['received_qty'] !== ""){
                            $items = array(
                                   //'qty' => (int)$item['qty'] - (int)$item['received_qty'],
                                           'received_qty' => (int)$item['received_qty'],
                                           'rejected_qty' => (int)$item['rejected_qty'],
                                             );

                            
                                $updateOrderItem = $commonModel->UpdateData('purchase_order_item',$item['item_id'],$items);
                           
                            $db = db_connect();
                            $CommonModel = new CommonModel($db);
                            $items2 = array(
                                      'p_o_id' => $post['order_number'],
                                            'order_item_id' => $item['order_item_id'],
                                            'received_qty' => $item['received_qty'],
                                            'rejected_qty' => $item['rejected_qty'],
                                             );

                            $addOrderItem = $commonModel->AddData('goods_received_items',$items2);
                          }
                        }
                    break;
                }
                    return json_encode([
                        "status" => "true",
                        "message" => "Data updated successfully",
                    ]);
                }
        }
    }
    public function getPurchase()
    {
        $post = $this->request->getVar();

        $purchase = new PurchaseModel();
        $data = $purchase->select('purchaseorders.id as p_o_id, purchase_order_item.*, items.item_name')
                              ->join('purchase_order_item','purchaseorders.id = purchase_order_item.p_o_id')
                              ->join('items','purchase_order_item.item_id = items.id')
                              ->where('purchaseorders.order_number', $post['order_number'])->findAll();
        return json_encode([
            "status" => "true",
            "data" => $data
        ]);

    }
    public function GetPurchaseDataByOrderId(){
       
        $post = $this->request->getVar();
        $db = db_connect();

        $sessData = getSessionData();

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['pos_id']);
        $purchaseModel = new PurchaseModel($db);
        $data['purchase_order'] = $purchaseModel->getOrderDataByOrderId($post['id']);
        
        $PurchaseItemsModel = new PurchaseOrderModel();
        $data['purchase_items'] = $PurchaseItemsModel->GetPurchaseItemsData($post['id']);
       
        $html = '';
        if(isset($post['type']) && $post['type'] == "received"){
            foreach($data['purchase_items'] as $k=>$value){
                $remaining = abs($value['qty'] - $value['received_qty']);
                $html .= '<tr class="new-row">';
                $html .= '<td ><span class="form-control">'.($k+1).'</span></td>';
                $html .= '<td><input class=" form-control" type="hidden" name="items['.$k.'][order_item_id]" value="'.$value['id'].'"><input class=" form-control" type="hidden" name="items['.$k.'][item_id]" value="'.$value['item_id'].'"><input class=" form-control" type="text" name="items['.$k.'][item_name]" value="'.$value['item_name'].'" readonly>';
                $html .= '</td>';
                $html .= '<td><input type="text" class="form-control" name="items['.$k.'][qty]" value="'.$value['qty'].'" readonly></td>';
                $html .= '<td>
                <input class="form-control rec_quantity" type="number" name="items['.$k.'][received_qty]"  value="'.$remaining.'">';
                $html .= '</td>';
                $html .= '<td><input type="text" class="form-control" name="items['.$k.'][old_received_qty]" value="'.$value['received_qty'].'" readonly>';
                $html .= '</td>';
                $html .= '<td><input class="form-control" type="text" name="items['.$k.'][rejected_qty]" value="">';
                $html .= '</td>';
                 $html .= '<td><input class="form-control" type="text" name="items['.$k.'][old_rejected_qty]" value="'.$value['rejected_qty'].'" readonly>';
                $html .= '</td>';
                $html .= '<td><input type="text" class="form-control rate" name="items['.$k.'][rate]" value="'.$value['rate'].'" readonly></td>';
                $disType = '-';
                if($value['discount'] > 0) {
                    $disType = $value['discount_type'];
                }
                $html .= '<td><input class="discount_amt form-control" type="text" name="items['.$k.'][discount]" value="'.$value['discount'].' '.$disType.'"></td>';
                $html .= '<td><input type="text" name="items['.$k.'][tax_amount]" value="'.$value['tax_amount'].'" class="form-control tax_amount" readonly><input class="form-control form-border tax" type="hidden" name="items['.$k.'][tax]" value="'.$value['tax_value'].'" readonly><input class="form-control form-border tax_type" type="hidden" name="items['.$k.'][tax_type]" value="'.$value['tax_name'].'" readonly></td>';
                $html .= '<td> <input class="tabledit-input form-control amount" type="text" name="items['.$k.'][amount]" value="'.$value['total_amount'].'" readonly>';
                $html .= '</td>';
                $html .= '';//'<td><span class="form-control"><a href="#" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a></span>';
                $html .= '</td>';
                $html .= '</tr>';
                /*<input type="checkbox" name="items['.$k.'][is_verify]">*/
            }
        }else{
            foreach($data['purchase_items'] as $k=>$value){
            
                $html .= '<tr class="new-row">';
                $html .= '<td><span class="form-control">'.($k+1).'</span></td>';
                $html .= '<td colspan="2"><input class=" form-control" type="hidden" name="items['.$k.'][order_item_id]" value="'.$value['id'].'"><input class=" form-control" type="hidden" name="items['.$k.'][item_id]" value="'.$value['item_id'].'"><input class=" form-control" type="text" name="items['.$k.'][item_name]" value="'.$value['item_name'].'">';
                $html .= '</td>';
                $html .= '<td><input class="uom form-control " type="text" name="items['.$k.'][uom]" value="'.$value['uom_value'].'"><input class="uomid form-control " type="hidden" name="items['.$k.'][uomid]" value="'.$value['uom_id'].'">';
                $html .= '</td>';
                $html .= '<td><input class="form-control" type="text" name="items['.$k.'][quantity]"  value="'.$value['qty'].'"></td>';
                $html .= '<td><input class="form-control quantity" type="text" name="items['.$k.'][returned_qty]" value=""><input class="form-control received_qty" type="hidden" name="items['.$k.'][received_qty]" value="'.$value['received_qty'].'">';
                $html .= '</td>';
                $html .= '<td><input class="form-control" type="text" name="items['.$k.'][old_returned_qty]" value="'.$value['returned_qty'].'" readonly>';
                $html .= '</td>';
                $html .= '<td><input class="form-control rate" type="text" name="items['.$k.'][rate]" value="'.$value['rate'].'">';
                $html .= '</td>';
                $disType = '-';
                if($value['discount'] > 0) {
                    $disType = $value['discount_type'];
                }
                $html .= '<td><input class="discount_amt form-control" type="text" name="items['.$k.'][discount]" value="'.$value['discount'].' '.$disType.'"></td>';
                 $html .= '<td><input type="text" name="items['.$k.'][tax_amount]" value="'.$value['tax_amount'].'" class="form-control tax_amount" readonly><input class="form-control form-border tax" type="hidden" name="items['.$k.'][tax]" value="'.$value['tax_value'].'" readonly><input class="form-control form-border tax_type" type="hidden" name="items['.$k.'][tax_type]" value="'.$value['tax_name'].'" readonly></td>';
                $html .= '</td>';
                 $html .= '<td> <input class="tabledit-input form-control amount" type="text" name="items['.$k.'][amount]" value="'.$value['total_amount'].'">';
                $html .= '</td>';
                 /*$html .= '<td><a href="#" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a>';
                $html .= '</td>';*/
                $html .= '</tr>';
            }
        }
        
        $data['purchase_items_pages'] =  $html; 
       
        if(!empty($data['purchase_order'])){
            return json_encode([
                "status" => "true",
                "message" => "Data fetch successfully",
                "data" => $data
            ]);
        }else{
            return json_encode([
                "status" => "false",
                "message" => "No Data Found",
            ]);
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

    public function getSupplier()
    {
        $postData = $this->request->getVar();
        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $filter = $postData['filter'];
        $sessData = getSessionData();

        $supplier = new SupplierModel();
        $totalRecords = $supplier->select('id')->countAllResults();

        $supplierF = new SupplierModel();
        $supplierF->select('id');

        $supplier->select('*');
        
        if($filter['status'] != "") {
            $supplier->where('status',$filter['status']);
            $supplierF->where('status',$filter['status']);
        }
        if($filter['search'] != "") {
            $supplier->Like('registered_name',$filter['search'])
                ->Like('tax_amount_name',$filter['search']);
            $supplierF->orLike('registered_name',$filter['search'])
                ->orLike('tax_amount_name',$filter['search']);
        }
        $supplier->where('pos_id',$sessData['pos_id']);
        $supplier->orderBy('id','desc');
        $records = $supplier->findAll($rowperpage, $start);
        $totalRecordwithFilter = $supplierF->countAllResults();

        $data = array();
        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "registered_name"=>$record['registered_name'],
               "tax_amount_name"=>$record['tax_amount_name'],
               "operator"=>$record['operator'],
               "email"=>$record['email'],
               "phone"=>$record['phone'],
               "payable"=>$record['payable'],
               "date"=>$record['date'],
               "status_type"=>$record['status_type'],
               "status"=>$record['status'],
               "created_at"=>dateFormat($record['created_at'])
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

    public function getPurchaseOrder()
    {
        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sessData = getSessionData();

        // $db = db_connect();
        $purchase = new PurchaseModel();
        $purchase->select('id');
        $totalRecords = $purchase->countAllResults();
         
        $purchaseF = new PurchaseModel();
        $purchaseF->select('id');

        // $purchaseF->join('stores', 'purchaseorders.store_id = stores.id');

        $purchase->select('purchaseorders.*,stores.store_name,suppliers.registered_name as supplier_name')
            ->join('stores', 'purchaseorders.store_id = stores.id')
            ->join('suppliers', 'purchaseorders.supplier_id = suppliers.id');
        
        if($sessData['role_name'] == "Staff") {
            $purchase->where('purchaseorders.store_id',$sessData['store_id']);
            $purchaseF->where('store_id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $purchase->where('stores.owner_id',$sessData['id']);
            // $purchaseF->where('owner_id',$sessData['id']);
        }

        if($filter['store'] != "") {
            $purchase->where('store_id',$filter['store']);
            $purchaseF->where('store_id',$filter['store']);
        }

        if($filter['supplier'] != "") {
            $purchase->where('purchaseorders.supplier_id',$filter['supplier']);
            $purchaseF->where('purchaseorders.supplier_id',$filter['supplier']);
        }
        if($filter['search'] != "") {
            $purchase->like('stores.store_name',$filter['search'])
            ->orLike('order_number',$filter['search'])
            ->orLike('registered_name',$filter['search']);
        }
        /*$purchase->where('order_status',0);
        $purchase->orWhere('order_status',1);
        $purchase->orWhere('order_status',3);
        $purchase->orWhere('order_status',4);*/
        $purchase->orderBy('id','desc');
        $records = $purchase->findAll($rowperpage, $start);

        // print_r($db->getLastQuery());die;

        $totalRecordwithFilter = $purchaseF->countAllResults();


        $data = array();

        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "order_number"=>$record['order_number'],
               "store_name"=>$record['store_name'],
               "supplier_name"=>$record['supplier_name'],
               "order_status"=>$record['order_status'],
               "date"=>dateFormat($record['date']),
               "due_date"=>dateFormat($record['due_date']),
               "total_amount"=>$record['total_amount']
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
    public function getPurchaseOrderReview()
    {
        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sessData = getSessionData();

        $purchase = new PurchaseModel();
        $totalRecords = $purchase->select('id')->where('order_status',0)->orWhere('order_status',2)->countAllResults();

        $purchaseF = new PurchaseModel();
        $purchaseF->select('id')->join('stores', 'purchaseorders.store_id = stores.id');

        $purchase->select('purchaseorders.*,stores.store_name,suppliers.registered_name as supplier_name')
            ->join('stores', 'purchaseorders.store_id = stores.id')
            ->join('suppliers', 'purchaseorders.supplier_id = suppliers.id');

        if($sessData['role_name'] == "Staff") {
            $purchase->where('purchaseorders.store_id',$sessData['store_id']);
            $purchaseF->where('store_id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $purchase->where('stores.owner_id',$sessData['id']);
            // $purchaseF->where('owner_id',$sessData['id']);
        }
        
        if($filter['supplier_id'] != "") {
            $purchase->where('supplier_id',$filter['supplier']);
            $purchaseF->where('supplier_id',$filter['supplier']);
        }
        if($filter['customer_id'] != 0 && $filter['customer_id'] != "") {
            $purchase->where('customer_id',$filter['customer_id']);
            $purchaseF->where('customer_id',$filter['customer_id']);
        }
        if($filter['search'] != "") {
            $purchase->orLike('stores.store_name',$filter['search'])
                ->orLike('order_number',$filter['search']);
        }

        $purchase->where('order_status',5);
        $purchase->orWhere('order_status',2);
        $purchase->orderBy('id','desc');
        $records = $purchase->findAll($rowperpage, $start);

        $purchaseF->where('order_status',5);
        $purchaseF->orWhere('order_status',2);
        $purchaseF->orderBy('id','desc');
        $totalRecordwithFilter = $purchaseF->countAllResults();

        $data = array();

        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "order_number"=>$record['order_number'],
               "store_name"=>$record['store_name'],
               "supplier_name"=>$record['supplier_name'],
               "order_status"=>$record['order_status'],
               "date"=>dateFormat($record['date']),
               "due_date"=>dateFormat($record['due_date']),
               "total_amount"=>$record['total_amount']
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
    
    public function getGoodsReceived()
    {
        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sessData = getSessionData();

        $goodsReceived = new GoodsReceivedModel();
        $totalRecords = $goodsReceived->select('id')->countAllResults();

        $goodsRecF = new GoodsReceivedModel();
        $goodsRecF->select('id');

        $goodsReceived->select('goods_received.*,stores.store_name,suppliers.registered_name as supplier_name,location_description as location_type,purchaseorders.order_number')
            ->join('purchaseorders', 'goods_received.p_o_id = purchaseorders.id')
            ->join('stores', 'purchaseorders.store_id = stores.id')
            ->join('location', 'goods_received.location_id = location.id','left')
            ->join('suppliers', 'purchaseorders.supplier_id = suppliers.id');
        
        if($filter['category'] != 0 && $filter['category'] != "") {
            $goodsReceived->where('purchaseorders.category_id',$filter['category']);
        }
        if($sessData['role_name'] == "Staff") {
            $goodsReceived->where('purchaseorders.store_id',$sessData['store_id']);
            $goodsRecF->where('store_id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $goodsReceived->where('stores.owner_id',$sessData['id']);
            // $purchaseF->where('owner_id',$sessData['id']);
        }
        if($filter['supplier'] != "" || $filter['location'] != "" || $filter['stores'] != ""){
            $goodsRecF->join('purchaseorders', 'goods_received.p_o_id = purchaseorders.id')->where('purchaseorders.supplier_id',$filter['supplier']);
        }
        if($filter['supplier'] != 0 && $filter['supplier'] != "") {
            $goodsReceived->where('purchaseorders.supplier_id',$filter['supplier']);
            $goodsRecF->where('purchaseorders.supplier_id',$filter['supplier']);
        }
        if($filter['location'] != 0 && $filter['location'] != "") { 
            $goodsReceived->where('goods_received.location_id',$filter['location']);
            $goodsRecF->where('goods_received.location_id',$filter['location']);
        }
        if($filter['stores'] != 0 && $filter['stores'] != "") {
            $goodsReceived->where('purchaseorders.store_id',$filter['stores']);
            $goodsRecF->where('purchaseorders.store_id',$filter['stores']);
        }
        if($filter['search'] != "") {
            $goodsReceived->orLike('stores.store_name',$filter['search'])
                ->orLike('order_number',$filter['search']);
        }
        $goodsReceived->orderBy('id','desc');
        $records = $goodsReceived->findAll($rowperpage, $start);
       
        $totalRecordwithFilter = count($records);

        $data = array();

        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "order_number"=>$record['order_number'],//$record['order_number'],
               "store_name"=>$record['store_name'],
               "supplier_name"=>$record['supplier_name'],
               "location_type"=>$record['location_type'],
               "date"=>dateFormat($record['date']),
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

    public function getGoodsReturned()
    {
        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sessData = getSessionData();

        $goodsReturn = new GoodsReturnedModel();
        $totalRecords = $goodsReturn->select('id')->countAllResults();

       // $purchaseF = new SupplierModel();
        $goodsReturn->select('goods_returned.*,purchaseorders.date,purchaseorders.due_date,purchaseorders.due_date, suppliers.registered_name as supplier_name,stores.store_name')
        ->join('purchaseorders', 'purchaseorders.id = goods_returned.p_o_id','left')
        ->join('suppliers', 'purchaseorders.supplier_id = suppliers.id','left')
        ->join('stores', 'purchaseorders.store_id = stores.id','left');

        if($sessData['role_name'] == "Staff") {
            $goodsReturn->where('purchaseorders.store_id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $goodsReturn->where('stores.owner_id',$sessData['id']);
        }

        if($filter['supplier'] != "") {
            $goodsReturn->where('supplier_id',$filter['supplier']);
        }
        if($filter['store'] != "") {
            $goodsReturn->where('purchaseorders.store_id',$filter['store']);
        }
        if($filter['category'] != 0 && $filter['category'] != "") {
            $goodsReturn->where('purchaseorders.category_id',$filter['category']);
        }
        if($filter['search'] != "") {
            $goodsReturn->orLike('suppliers.registered_name',$filter['search'])
                ->orLike('order_number',$filter['search']);
        }
        $goodsReturn->orderBy('goods_returned.id','desc');  
        $records = $goodsReturn->findAll($rowperpage, $start);
        $totalRecordwithFilter = $goodsReturn->countAllResults();
      
        $data = array();
        $goodsReturn = new GoodsReturnedItemModel();
        foreach($records as $record ){
            $qty = $goodsReturn->GetTotalReturnQty($record['p_o_id']);
            $data[] = array( 
               "id"=>$record['id'],
               "order_number"=>$record['p_o_id'],
               "store_name"=>$record['store_name'],
               "supplier_name"=>$record['supplier_name'],
               "status"=>1,
               "date"=>dateFormat($record['date']),
               "due_date"=>dateFormat($record['due_date']),
               "rate"=>0,
               "return_qty"=>$qty['qty']
            ); 
        }

        // echo "<pre>";print_r($data);die;

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash() // New token hash
         );

         return $this->response->setJSON($response);
    }

    public function getDirectGoodsReceived()
    {
        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sessData = getSessionData();

        $mdl = new DirectGoodsReceived();
        $totalRecords = $mdl->select('id')->countAllResults();

        $flt = new DirectGoodsReceived();
        $flt->select('id');

        $mdl->select('direct_goods_received.*,stores.store_name,suppliers.registered_name as supplier_name,location_description')
            ->join('stores', 'store_id = stores.id')
            ->join('location', 'direct_goods_received.location_id = location.id','left')
            ->join('suppliers', 'supplier_id = suppliers.id');
       
        if($sessData['role_name'] == "Staff") {
            $mdl->where('store_id',$sessData['store_id']);
            $flt->where('store_id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $mdl->where('direct_goods_received.pos_id',$sessData['pos_id']);
        }

        if($filter['supplier'] != 0 && $filter['supplier'] != "") {
            $mdl->where('supplier_id',$filter['supplier']);
            $flt->where('supplier_id',$filter['supplier']);
        }
        if($filter['location'] != 0 && $filter['location'] != "") { 
            $mdl->where('direct_goods_received.location_id',$filter['location']);
            $flt->where('direct_goods_received.location_id',$filter['location']);
        }
        if($filter['stores'] != 0 && $filter['stores'] != "") {
            $mdl->where('store_id',$filter['stores']);
            $flt->where('store_id',$filter['stores']);
        }
        if($filter['search'] != "") {
            $mdl->orLike('stores.store_name',$filter['search'])
                ->orLike('supplier_name',$filter['search']);
        }
        $mdl->orderBy('id','desc');
        $records = $mdl->findAll($rowperpage, $start);
       
        $totalRecordwithFilter = count($records);

        $data = array();

        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "store_name"=>$record['store_name'],
               "supplier_name"=>$record['supplier_name'],
               "location_type"=>$record['location_description'],
               "date"=>dateFormat($record['date'])
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

    public function getBackOrder()
    {
        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sessData = getSessionData();

        // $db = db_connect();
        $purchase = new BackOrderModel();
        $purchase->select('id');
        $totalRecords = $purchase->countAllResults();
         
        $purchaseF = new BackOrderModel();
        $purchaseF->select('id');

        // $purchaseF->join('stores', 'purchaseorders.store_id = stores.id');

        $purchase->select('back_order.*,stores.store_name,suppliers.registered_name as supplier_name')
            ->join('stores', 'back_order.store_id = stores.id')
            ->join('suppliers', 'back_order.supplier_id = suppliers.id');
        
        if($sessData['role_name'] == "Staff") {
            $purchase->where('back_order.store_id',$sessData['store_id']);
            $purchaseF->where('store_id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $purchase->where('stores.pos_id',$sessData['pos_id']);
            // $purchaseF->where('owner_id',$sessData['id']);
        }

        if($filter['store'] != "") {
            $purchase->where('store_id',$filter['store']);
            $purchaseF->where('store_id',$filter['store']);
        }

        if($filter['supplier'] != "") {
            $purchase->where('back_order.supplier_id',$filter['supplier']);
            $purchaseF->where('back_order.supplier_id',$filter['supplier']);
        }
        if($filter['search'] != "") {
            $purchase->like('stores.store_name',$filter['search'])
            ->orLike('order_number',$filter['search'])
            ->orLike('registered_name',$filter['search']);
        }
        /*$purchase->where('order_status',0);
        $purchase->orWhere('order_status',1);
        $purchase->orWhere('order_status',3);
        $purchase->orWhere('order_status',4);*/
        $purchase->orderBy('id','desc');
        $records = $purchase->findAll($rowperpage, $start);

        // print_r($db->getLastQuery());die;

        $totalRecordwithFilter = $purchaseF->countAllResults();


        $data = array();

        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "order_number"=>$record['order_number'],
               "store_name"=>$record['store_name'],
               "supplier_name"=>$record['supplier_name'],
               "date"=>dateFormat($record['date']),
               "due_date"=>dateFormat($record['due_date']),
               "total_amount"=>$record['total_amount']
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
    
}
