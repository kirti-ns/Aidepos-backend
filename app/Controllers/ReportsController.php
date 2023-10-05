<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Models\StockMovementModel;
use App\Models\StockAdjustModel;
use App\Models\StoreModel;
use App\Models\CustomersModel;
use App\Models\CategoryModel;
use App\Models\TransferModel;
use App\Models\ItemModel;
use App\Models\ItemsPriceModel;
use App\Models\SellordersModel;
use App\Models\SellItemsModel;
use App\Models\CreditNote;
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
use App\Models\ContractModel;
use App\Models\ContractItemsModel;
use App\Models\ContractTransactionModel;

class ReportsController extends BaseController
{
    public function reports($report)
    {
        $data = [];
        $data['title'] = 'Reports';
        $page = '';
        $sessData = getSessionData();

        $store = new StoreModel();
        if($sessData['role_name'] == "Staff") {
            $store->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $store->where('pos_id',$sessData['pos_id']);
        }
        $data['store'] = $store->findAll();

        $customer = new CustomersModel();
        $data['customers'] = $customer->findAll();

        $category = new CategoryModel();
        $data['category'] = $category->findAll();

        $location = new Location();
        $data['location'] = $location->where('store_id',$sessData['store_id'])->where('status',1)->findAll();

        switch ($report) {
            case 'sales-by-item':
                $page = 'pages/reports/sales-by-item';
            break;
            case 'sales-by-terminal':
                $page = 'pages/reports/sales-by-terminal';
            break;
            case 'cancelled-invoices':
                $page = 'pages/reports/cancelled-invoices';
            break;
            case 'credit-notes':
                $page = 'pages/reports/credit-notes';
            break;
            case 'stock-on-hand':
                $page = 'pages/reports/stock-on-hand';
            break;
            case 'stock-valuation':
                $page = 'pages/reports/stock-valuation';
            break;
            case 'stock-price':
                $page = 'pages/reports/stock-price';
            break;
            case 'stock-take-with-qty':
                $page = 'pages/reports/stock-take-with-qty';
            break;
            case 'layby-sales':
                $page = 'pages/reports/layby-sales';
            break;
        }
        
        return $this->template->render($page, $data); 
    }

    public function salesByItem()
    {
        $post = $this->request->getVar();
        
        $dtpost = $post['data'];
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpost['order'][0]['column']; // Column index
        $columnName = $dtpost['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpost['order'][0]['dir']; // asc or desc
        $filter = $post['filter'];
        $sessData = getSessionData();

        $mdl = new SellItemsModel();
        $flt = new SellItemsModel();
        $flt->select('SUM(qty) as total_qty, rate, i.sku_barcode, item_id, i.item_name');
        // $totalRecords = $mdl->select('SUM(qty) as total_qty, SUM(total_amount) as total_amount, i.sku_barcode, item_id, i.item_name')->countAllResults();

        $mdl->select('SUM(qty) as total_qty, SUM(sell_items.total_amount) as total_amt, i.sku_barcode, item_id, i.item_name');
        
        if($filter['store_id'] != "") {
            $mdl->where('o.store_id',$filter['store_id']);
            $flt->where('o.store_id',$filter['store_id']);
        }
        if($filter['daterange'] != "") {
            $range = explode('-',$filter['daterange']);
            $startDt = date('Y-m-d',strtotime($range[0]));
            $endDt = date('Y-m-d',strtotime($range[1]));

            $mdl->where('o.invoice_date >=',$startDt);
            $mdl->where('o.invoice_date <=',$endDt);
            $flt->where('o.invoice_date >=',$startDt);
            $flt->where('o.invoice_date <=',$endDt);
        }
        $mdl->join('sell_orders o','sell_items.s_o_id = o.id');
        $mdl->join('items i','sell_items.item_id = i.id');
        $mdl->groupBy('sell_items.item_id');

        $flt->join('sell_orders o','sell_items.s_o_id = o.id');
        $flt->join('items i','sell_items.item_id = i.id');
        $flt->groupBy('sell_items.item_id');
        // $mdl->where('pos_id',$sessData['pos_id']);
        // $mdl->orderBy('id','desc');
        $records = $mdl->findAll($rowperpage, $start);
        $totalRecords = $mdl->countAllResults();
        $totalRecordwithFilter = $flt->countAllResults();

        $data = array();
        foreach($records as $record ){
            $data[] = array( 
               "item_name"=>$record['item_name'],
               "sku"=>$record['sku_barcode'],
               "qty"=>$record['total_qty'],
               "amount"=>$record['total_amt']
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
    public function salesByTerminal()
    {
        $post = $this->request->getVar();
        
        $dtpost = $post['data'];
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpost['order'][0]['column']; // Column index
        $columnName = $dtpost['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpost['order'][0]['dir']; // asc or desc
        $filter = $post['filter'];
        $sessData = getSessionData();

        $mdl = new SellItemsModel();
        $flt = new SellItemsModel();
        $flt->select('SUM(qty) as total_qty, SUM(rate) as amount, i.sku_barcode, item_id, i.item_name, t.terminal_name,o.invoice_date');
        // $totalRecords = $mdl->select('SUM(qty) as total_qty, SUM(total_amount) as total_amount, i.sku_barcode, item_id, i.item_name')->countAllResults();

        $mdl->select('SUM(qty) as total_qty, SUM(sell_items.total_amount) as total_amt, i.sku_barcode, item_id, i.item_name, t.terminal_name,o.invoice_date, s.store_name');
        
        if($filter['store_id'] != "") {
            $mdl->where('o.store_id',$filter['store_id']);
            $flt->where('o.store_id',$filter['store_id']);
        }
        if($filter['daterange'] != "") {
            $range = explode('-',$filter['daterange']);
            $startDt = date('Y-m-d',strtotime($range[0]));
            $endDt = date('Y-m-d',strtotime($range[1]));

            $mdl->where('o.invoice_date >=',$startDt);
            $mdl->where('o.invoice_date <=',$endDt);
            $flt->where('o.invoice_date >=',$startDt);
            $flt->where('o.invoice_date <=',$endDt);
        }
        $mdl->join('sell_orders o','sell_items.s_o_id = o.id');
        $mdl->join('items i','sell_items.item_id = i.id');
        $mdl->join('terminals t','o.terminal_id = t.id');
        $mdl->join('stores s','o.store_id = s.id');
        $mdl->groupBy('sell_items.item_id');
        $mdl->groupBy('o.terminal_id');

        $flt->join('sell_orders o','sell_items.s_o_id = o.id');
        $flt->join('items i','sell_items.item_id = i.id');
        $flt->join('terminals t','o.terminal_id = t.id');
        $flt->join('stores s','o.store_id = s.id');
        $flt->groupBy('sell_items.item_id');
        $mdl->groupBy('o.terminal_id');
        // $mdl->where('pos_id',$sessData['pos_id']);
        // $mdl->orderBy('id','desc');
        $records = $mdl->findAll($rowperpage, $start);
        $totalRecords = $mdl->countAllResults();
        $totalRecordwithFilter = $flt->countAllResults();

        $data = array();
        foreach($records as $record ){
            $data[] = array(
               "item_code"=>$record['item_id'],
               "store_name"=>$record['store_name'],
               "terminal_name"=>$record['terminal_name'],
               "item_name"=>$record['item_name'],
               "date"=>$record['invoice_date'],
               "sku"=>$record['sku_barcode'],
               "qty"=>$record['total_qty'],
               "amount"=>$record['total_amt']
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
    public function creditNotes()
    {
        $post = $this->request->getVar();
        
        $dtpost = $post['data'];
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpost['order'][0]['column']; // Column index
        $columnName = $dtpost['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpost['order'][0]['dir']; // asc or desc
        $filter = $post['filter'];
        $sessData = getSessionData();

        $mdl = new CreditNote();
        $flt = new CreditNote();
        $flt->select('id');

        $mdl->select('credit_notes.*, customers.registerd_name');
        
        if($filter['store_id'] != "") {
            $mdl->where('credit_notes.store_id',$filter['store_id']);
            $flt->where('credit_notes.store_id',$filter['store_id']);
        }
        if($filter['customer_id'] != "") {
            $mdl->where('credit_notes.customer_id',$filter['customer_id']);
            $flt->where('credit_notes.customer_id',$filter['customer_id']);
        }
        if($filter['daterange'] != "") {
            $range = explode('-',$filter['daterange']);
            $startDt = date('Y-m-d',strtotime($range[0]));
            $endDt = date('Y-m-d',strtotime($range[1]));

            $mdl->where('credit_date >=',$startDt);
            $mdl->where('credit_date <=',$endDt);
            $flt->where('credit_date >=',$startDt);
            $flt->where('credit_date <=',$endDt);
        }
        $mdl->join('customers','credit_notes.customer_id = customers.id');
        $mdl->where('credit_notes.pos_id',$sessData['pos_id']);

        $flt->join('customers','credit_notes.customer_id = customers.id');
        $flt->where('credit_notes.pos_id',$sessData['pos_id']);

        $records = $mdl->findAll($rowperpage, $start);
        $totalRecords = $mdl->countAllResults();
        $totalRecordwithFilter = $flt->countAllResults();

        $data = array();
        foreach($records as $record ){
            $data[] = array(
               "credit_note"=>$record['id'],
               "date"=>$record['credit_date'],
               "customer_name"=>$record['registerd_name'],
               "total_amount"=>$record['total_amount'],
               "balance"=>$record['credits_available']
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
    public function stockOnHand()
    {
        $post = $this->request->getVar();
        
        $dtpost = $post['data'];
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpost['order'][0]['column']; // Column index
        $columnName = $dtpost['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpost['order'][0]['dir']; // asc or desc
        $filter = $post['filter'];
        $sessData = getSessionData();

        $mdl = new CurrentInventory();
        $flt = new CurrentInventory();
        $flt->select('current_inventory.id');

        $totalRecords = $mdl->select('id')->where('current_inventory.quantity >',0)
                ->countAllResults();

        $mdl->select('current_inventory.id,current_inventory.quantity, items.id as item_code,items.item_name,items.sku_barcode,c.category_name,b.brand_name,p.retail_price,stores.store_name,uom_master.uom,l.location_description');
        $mdl->join('items', 'current_inventory.item_id = items.id','left');
        $mdl->join('stores', 'current_inventory.store_id = stores.id','left');
        $mdl->join('location l', 'current_inventory.location_id = l.id','left');
        $mdl->join('categories c', 'items.category_id = c.id','left');
        $mdl->join('brandmasters b', 'items.brand_id = b.id','left');
        $mdl->join('items_price p','items.id = p.items_id','left');
        $mdl->join('uom_master', 'items.uom_id = uom_master.id','left');

        $flt->join('items', 'current_inventory.item_id = items.id','left');
        $flt->join('stores', 'current_inventory.store_id = stores.id','left');
        $flt->join('location l', 'current_inventory.location_id = l.id','left');
        $flt->join('categories c', 'items.category_id = c.id','left');
        $flt->join('brandmasters b', 'items.brand_id = b.id','left');
        $flt->join('items_price p','items.id = p.items_id','left');
        $flt->join('uom_master', 'items.uom_id = uom_master.id','left');
        
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
        $mdl->orderBy('current_inventory.id','desc');
        $records = $mdl->findAll($rowperpage, $start);
        
        $flt->where('current_inventory.quantity >',0);
        $flt->groupBy('current_inventory.item_id');
        $flt->groupBy('current_inventory.store_id');
        $totalRecordwithFilter = $flt->countAllResults();//count($records);
        $data = array();
        
        foreach($records as $record ){

            $data[] = [ 
               "id"=>$record['id'],
               "store_name"=>$record['store_name'],
               "location"=>$record['location_description'],
               "item_code"=>$record['item_code'],
               "item_name"=>$record['item_name'],
               "category_name"=>$record['category_name'],
               "brand_name"=>$record['brand_name'],
               "sku"=>$record['sku_barcode'],
               "current_inventory"=>$record['quantity'],
               "unit"=>$record['uom'],
               "inventory_amount"=>$record['quantity']*$record['retail_price'],
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
    public function stockValuation()
    {
        $post = $this->request->getVar();
        
        $dtpost = $post['data'];
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpost['order'][0]['column']; // Column index
        $columnName = $dtpost['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpost['order'][0]['dir']; // asc or desc
        $filter = $post['filter'];
        $sessData = getSessionData();

        $mdl = new ItemModel();
        $flt = new ItemModel();
        $flt->select('items.id');

        $totalRecords = $mdl->select('id')->where('pos_id',$sessData['pos_id'])
                ->countAllResults();

        $mdl->select('items.id, items.item_name,items.sku_barcode,u.uom,p.supply_price,p.retail_price,p.current_inventory, p.inventory_value,stores.store_name');
        $mdl->join('items_price p','items.id = p.items_id','left');
        $mdl->join('stores', 'p.store_id = stores.id','left');
        $mdl->join('uom_master u', 'items.uom_id = u.id','left');

        $flt->join('items_price p','items.id = p.items_id','left');
        $flt->join('stores', 'p.store_id = stores.id','left');
        $flt->join('uom_master u', 'items.uom_id = u.id','left');

        if($filter['store_id'] != "") {
            $mdl->where('p.store_id',$filter['store_id']);
            $flt->where('p.store_id',$filter['store_id']);
        }
        if($filter['search'] != "") {
            $mdl->orLike('stores.store_name',$filter['search'])
                ->orLike('items.item_name',$filter['search']);
        }
        $mdl->where('items.pos_id',$sessData['pos_id']);
        // $mdl->orderBy('p.store_id');
        $records = $mdl->findAll($rowperpage, $start);
        
        $flt->where('items.pos_id',$sessData['pos_id']);
        $totalRecordwithFilter = $flt->countAllResults();//count($records);

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $records,
            "token" => csrf_hash() // New token hash
         );

         return $this->response->setJSON($response);

    }
    public function stockPrice()
    {
        $post = $this->request->getVar();
        
        $dtpost = $post['data'];
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpost['order'][0]['column']; // Column index
        $columnName = $dtpost['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpost['order'][0]['dir']; // asc or desc
        $filter = $post['filter'];
        $sessData = getSessionData();

        $mdl = new ItemModel();
        $flt = new ItemModel();
        $flt->select('items.id');

        $totalRecords = $mdl->select('id')->where('pos_id',$sessData['pos_id'])
                ->countAllResults();

        $mdl->select('items.id, items.item_name,items.sku_barcode,c.category_name,p.supply_price,p.retail_price,p.current_inventory, p.inventory_value,stores.store_name');
        $mdl->join('items_price p','items.id = p.items_id','left');
        $mdl->join('stores', 'p.store_id = stores.id','left');
        $mdl->join('categories c', 'items.category_id = c.id','left');

        $flt->join('items_price p','items.id = p.items_id','left');
        $flt->join('stores', 'p.store_id = stores.id','left');
        $flt->join('categories c', 'items.category_id = c.id','left');

        if($filter['store_id'] != "") {
            $mdl->where('p.store_id',$filter['store_id']);
            $flt->where('p.store_id',$filter['store_id']);
        }
        if($filter['category_id'] != "") {
            $mdl->where('items.category_id',$filter['category_id']);
            $flt->where('items.category_id',$filter['category_id']);
        }
        if($filter['search'] != "") {
            $mdl->orLike('stores.store_name',$filter['search'])
                ->orLike('items.item_name',$filter['search']);
        }
        $mdl->where('items.pos_id',$sessData['pos_id']);
        // $mdl->orderBy('p.store_id');
        $records = $mdl->findAll($rowperpage, $start);
        
        $flt->where('items.pos_id',$sessData['pos_id']);
        $totalRecordwithFilter = $flt->countAllResults();//count($records);

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $records,
            "token" => csrf_hash() // New token hash
         );

         return $this->response->setJSON($response);

    }
    public function stockTakeWithQty()
    {
        $post = $this->request->getVar();
        
        $dtpost = $post['data'];
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpost['order'][0]['column']; // Column index
        $columnName = $dtpost['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpost['order'][0]['dir']; // asc or desc
        $filter = $post['filter'];
        $sessData = getSessionData();

        $mdl = new StoreItemsModel();
        $flt = new StoreItemsModel();
        $flt->select('store_items.id');

        $totalRecords = $mdl->select('id')->where('pos_id',$sessData['pos_id'])->countAllResults();

        $mdl->select('store_items.*,items.item_name,items.sku_barcode,c.category_name,p.retail_price,stores.store_name,l.location_description as location');
        $mdl->join('items', 'store_items.item_id = items.id','left');
        $mdl->join('stores', 'store_items.store_id = stores.id','left');
        $mdl->join('location l', 'store_items.location_id = l.id','left');
        $mdl->join('categories c', 'items.category_id = c.id','left');
        $mdl->join('items_price p','items.id = p.items_id','left');

        $flt->join('items', 'store_items.item_id = items.id','left');
        $flt->join('stores', 'store_items.store_id = stores.id','left');
        $flt->join('location l', 'store_items.location_id = l.id','left');
        $flt->join('categories c', 'items.category_id = c.id','left');
        $flt->join('items_price p','items.id = p.items_id','left');
        
        if($filter['daterange'] != "") {
            $range = explode('-',$filter['daterange']);
            $startDt = date('Y-m-d',strtotime($range[0]));
            $endDt = date('Y-m-d',strtotime($range[1]));

            $mdl->where('store_items.created_at >=',$startDt);
            $mdl->where('store_items.created_at <=',$endDt);
            $flt->where('store_items.created_at >=',$startDt);
            $flt->where('store_items.created_at <=',$endDt);
        }
        if($filter['store_id'] != "") {
            $mdl->where('store_items.store_id',$filter['store_id']);
            $flt->where('store_items.store_id',$filter['store_id']);
        }
        if($filter['location_id'] != "") {
            $mdl->where('store_items.location_id',$filter['location_id']);
            $flt->where('store_items.location_id',$filter['location_id']);
        }
        if($filter['category_id'] != "") {
            $mdl->where('items.category_id',$filter['category_id']);
            $flt->where('items.category_id',$filter['category_id']);
        }
        if($filter['search'] != "") {
            $mdl->orLike('stores.store_name',$filter['search'])
                ->orLike('items.item_name',$filter['search']);
        }

        $mdl->groupBy('store_items.item_id');
        $mdl->groupBy('store_items.store_id');
        $mdl->groupBy('store_items.location_id');
        $mdl->where('store_items.pos_id',$sessData['pos_id']);
        $mdl->orderBy('store_items.id','desc');
        $records = $mdl->findAll($rowperpage, $start);

        $flt->groupBy('store_items.item_id');
        $flt->groupBy('store_items.store_id');
        $flt->groupBy('store_items.location_id');
        $totalRecordwithFilter = $flt->countAllResults();//count($records);

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $records,
            "token" => csrf_hash() // New token hash
         );

         return $this->response->setJSON($response);

    }
    public function laybySales()
    {
        $post = $this->request->getVar();
        
        $dtpost = $post['data'];
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpost['order'][0]['column']; // Column index
        $columnName = $dtpost['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpost['order'][0]['dir']; // asc or desc
        $filter = $post['filter'];
        $sessData = getSessionData();

        $mdl = new ContractModel();
        $flt = new ContractModel();
        $flt->select('id');

        $mdl->select('layby_contract.*, customers.registerd_name, stores.store_name');
        
        if($filter['store_id'] != "") {
            $mdl->where('layby_contract.store_id',$filter['store_id']);
            $flt->where('layby_contract.store_id',$filter['store_id']);
        }
        if($filter['customer_id'] != "") {
            $mdl->where('layby_contract.customer_id',$filter['customer_id']);
            $flt->where('layby_contract.customer_id',$filter['customer_id']);
        }
        if($filter['layby_type'] != "") {
            if($filter['layby_type'] == "1") {
                $mdl->whereIn('contract_status',[0,2]);
                $flt->whereIn('contract_status',[0,2]);
            } else if($filter['layby_type'] == "2") {
                $mdl->whereIn('contract_status',[3,5]);
                $flt->whereIn('contract_status',[3,5]);
            } else if($filter['layby_type'] == "3") {
                $mdl->whereIn('contract_status',[4]);
                $flt->whereIn('contract_status',[4]);
            }
        }
        if($filter['daterange'] != "") {
            $range = explode('-',$filter['daterange']);
            $startDt = date('Y-m-d',strtotime($range[0]));
            $endDt = date('Y-m-d',strtotime($range[1]));

            $mdl->where('contract_date >=',$startDt);
            $mdl->where('contract_date <=',$endDt);
            $flt->where('contract_date >=',$startDt);
            $flt->where('contract_date <=',$endDt);
        }
        $mdl->join('stores','layby_contract.store_id = stores.id');
        $mdl->join('customers','layby_contract.customer_id = customers.id');
        $mdl->where('layby_contract.pos_id',$sessData['pos_id']);

        $flt->join('stores','layby_contract.store_id = stores.id');
        $flt->join('customers','layby_contract.customer_id = customers.id');
        $flt->where('layby_contract.pos_id',$sessData['pos_id']);

        $records = $mdl->findAll($rowperpage, $start);
        $totalRecords = $mdl->countAllResults();
        $totalRecordwithFilter = $flt->countAllResults();
        
        $thisModel = new ContractModel();
        $data = $thisModel->laybyReports($records);

        /*if($filter['layby_type'] == "4" && $filter['amount'] != "" && $filter['amount'] > 0) {
            $data = $thisModel->laybyReportswithBalance($records,$filter['amount']);
        }*/
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response);
    }
    public function cancelledInvoice()
    {
        $post = $this->request->getVar();
        
        $dtpost = $post['data'];
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpost['order'][0]['column']; // Column index
        $columnName = $dtpost['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpost['order'][0]['dir']; // asc or desc
        $filter = $post['filter'];
        $sessData = getSessionData();

        $mdl = new SellordersModel();
        $flt = new SellordersModel();
        $flt->select('id');

        $mdl->select('credit_notes.*, customers.registerd_name');
        
        if($filter['store_id'] != "") {
            $mdl->where('credit_notes.store_id',$filter['store_id']);
            $flt->where('credit_notes.store_id',$filter['store_id']);
        }
        if($filter['customer_id'] != "") {
            $mdl->where('credit_notes.customer_id',$filter['customer_id']);
            $flt->where('credit_notes.customer_id',$filter['customer_id']);
        }
        if($filter['daterange'] != "") {
            $range = explode('-',$filter['daterange']);
            $startDt = date('Y-m-d',strtotime($range[0]));
            $endDt = date('Y-m-d',strtotime($range[1]));

            $mdl->where('credit_date >=',$startDt);
            $mdl->where('credit_date <=',$endDt);
            $flt->where('credit_date >=',$startDt);
            $flt->where('credit_date <=',$endDt);
        }
        $mdl->join('customers','credit_notes.customer_id = customers.id');
        $mdl->where('credit_notes.pos_id',$sessData['pos_id']);

        $flt->join('customers','credit_notes.customer_id = customers.id');
        $flt->where('credit_notes.pos_id',$sessData['pos_id']);

        $records = $mdl->findAll($rowperpage, $start);
        $totalRecords = $mdl->countAllResults();
        $totalRecordwithFilter = $flt->countAllResults();

        $data = array();
        foreach($records as $record ){
            $data[] = array(
               "credit_note"=>$record['id'],
               "date"=>$record['credit_date'],
               "customer_name"=>$record['registerd_name'],
               "total_amount"=>$record['total_amount'],
               "balance"=>$record['credits_available']
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
    public function printReport()
    {
        $type = $_GET['type'];
        $filter = json_decode($_GET['filter']);

        $data = [];
        $data['heading'] = 'Reports';
        $data['report_data'] = array();
        $page = 'report-html-to-pdf';
        $sessData = getSessionData();
        $filename = 'Report.pdf';
        $data['date'] = "";
        if(isset($filter->daterange)) {
            $range = explode('-',$filter->daterange);
            $startDt = date('Y-m-d',strtotime($range[0]));
            $endDt = date('Y-m-d',strtotime($range[1]));
            $data['date'] = $startDt.' to '.$endDt;
        }

        switch($type) {
            case 'sales-by-item':
                $data['heading'] = 'Sales By Item';
                $filename = 'sales_by_item.pdf';

                $mdl = new SellItemsModel();
                $mdl->select('SUM(qty) as total_qty, SUM(sell_items.total_amount) as total_amt, i.sku_barcode, item_id, i.item_name');
                
                if($filter->store_id != "") {
                    $mdl->where('o.store_id',$filter->store_id);
                }
                if($filter->daterange != "") {
                    $mdl->where('o.invoice_date >=',$startDt);
                    $mdl->where('o.invoice_date <=',$endDt);
                }
                $mdl->join('sell_orders o','sell_items.s_o_id = o.id');
                $mdl->join('items i','sell_items.item_id = i.id');
                $mdl->groupBy('sell_items.item_id');

                $records = $mdl->findAll();
                $data['header'] = [
                    'Item Name', 'SKU', 'Quantity Sold', 'Amount'
                ];

                foreach($records as $record ){
                    $data['report_data'][] = [
                       "item_name"=>$record['item_name'],
                       "sku"=>$record['sku_barcode'],
                       "qty"=>$record['total_qty'],
                       "amount"=>$record['total_amt']
                    ]; 
                }
            break;
            case 'sales-by-terminal':
                $page = 'sales-by-terminal';
                $data['heading'] = 'Sales By Terminal';
                $filename = 'sales_by_terminal.pdf';

                $mdl = new SellItemsModel();
                $mdl->select('SUM(qty) as total_qty, SUM(sell_items.total_amount) as total_amt, i.sku_barcode, item_id, i.item_name, t.terminal_name,o.invoice_date, s.store_name');
                
                if($filter->store_id != "") {
                    $mdl->where('o.store_id',$filter->store_id);
                }
                if($filter->daterange != "") {
                    $mdl->where('o.invoice_date >=',$startDt);
                    $mdl->where('o.invoice_date <=',$endDt);
                }
                $mdl->join('sell_orders o','sell_items.s_o_id = o.id');
                $mdl->join('items i','sell_items.item_id = i.id');
                $mdl->join('terminals t','o.terminal_id = t.id');
                $mdl->join('stores s','o.store_id = s.id');
                $mdl->groupBy('sell_items.item_id');
                $mdl->groupBy('o.terminal_id');

                $mdl->groupBy('o.terminal_id');
                $records = $mdl->findAll();

                foreach($records as $record ){
                    $data['report_data'][] = array(
                       "item_code"=>$record['item_id'],
                       "store_name"=>$record['store_name'],
                       "terminal_name"=>$record['terminal_name'],
                       "item_name"=>$record['item_name'],
                       "date"=>$record['invoice_date'],
                       "sku"=>$record['sku_barcode'],
                       "qty"=>$record['total_qty'],
                       "amount"=>$record['total_amt']
                    ); 
                }
            break;
            case 'credit-notes':
                $page = 'credit-notes';
                $data['heading'] = 'Credit Notes';
                $filename = 'credit_notes.pdf';

                $mdl = new CreditNote();
                $mdl->select('credit_notes.*, customers.registerd_name');
                
                if($filter->store_id != "") {
                    $mdl->where('credit_notes.store_id',$filter->store_id);
                }
                if($filter->customer_id != "") {
                    $mdl->where('credit_notes.customer_id',$filter->customer_id);
                }
                if($filter->daterange != "") {
                    $mdl->where('credit_date >=',$startDt);
                    $mdl->where('credit_date <=',$endDt);
                }
                $mdl->join('customers','credit_notes.customer_id = customers.id');
                $mdl->where('credit_notes.pos_id',$sessData['pos_id']);

                $records = $mdl->findAll();

                foreach($records as $record ){
                    $data['report_data'][] = array(
                       "credit_note"=>$record['id'],
                       "date"=>$record['credit_date'],
                       "customer_name"=>$record['registerd_name'],
                       "total_amount"=>$record['total_amount'],
                       "balance"=>$record['credits_available']
                    ); 
                }
            break;
            case 'stock-on-hand':
                $page = 'stock-on-hand';
                $data['heading'] = 'Stock On Hand';
                $filename = 'stock_on_hand.pdf';

                $mdl = new CurrentInventory();
                $mdl->select('current_inventory.id,current_inventory.quantity, items.id as item_code,items.item_name,items.sku_barcode,c.category_name,b.brand_name,p.retail_price,stores.store_name,uom_master.uom,l.location_description');
                $mdl->join('items', 'current_inventory.item_id = items.id','left');
                $mdl->join('stores', 'current_inventory.store_id = stores.id','left');
                $mdl->join('location l', 'current_inventory.location_id = l.id','left');
                $mdl->join('categories c', 'items.category_id = c.id','left');
                $mdl->join('brandmasters b', 'items.brand_id = b.id','left');
                $mdl->join('items_price p','items.id = p.items_id','left');
                $mdl->join('uom_master', 'items.uom_id = uom_master.id','left');
                
                if($filter->store_id != "") {
                    $mdl->where('current_inventory.store_id',$filter->store_id);
                }
                if($filter->location_id != "") {
                    $mdl->where('current_inventory.location_id',$filter->location_id);
                }
                if($filter->category_id != "") {
                    $mdl->where('items.category_id',$filter->category_id);
                }
                if($filter->search != "") {
                    $mdl->orLike('stores.store_name',$filter->search)
                        ->orLike('items.item_name',$filter->search);
                }
                $mdl->where('current_inventory.quantity >',0);
                $mdl->groupBy('current_inventory.item_id');
                $mdl->groupBy('current_inventory.store_id');
                $mdl->orderBy('current_inventory.id','desc');
                $records = $mdl->findAll();
                
                foreach($records as $record ){

                    $data['report_data'][] = [ 
                       "id"=>$record['id'],
                       "store_name"=>$record['store_name'],
                       "location"=>$record['location_description'],
                       "item_code"=>$record['item_code'],
                       "item_name"=>$record['item_name'],
                       "category_name"=>$record['category_name'],
                       "brand_name"=>$record['brand_name'],
                       "sku"=>$record['sku_barcode'],
                       "current_inventory"=>$record['quantity'],
                       "unit"=>$record['uom'],
                       "inventory_amount"=>$record['quantity']*$record['retail_price'],
                       "cost_price"=>$record['retail_price'],
                    ]; 
                }
            break;
            case 'stock-price':
                $page = 'stock-price';
                $data['heading'] = 'Stock Price';
                $filename = 'stock_price.pdf';

                $mdl = new ItemModel();
                $mdl->select('items.id, items.item_name,items.sku_barcode,c.category_name,p.supply_price,p.retail_price,p.current_inventory, p.inventory_value,stores.store_name');
                $mdl->join('items_price p','items.id = p.items_id','left');
                $mdl->join('stores', 'p.store_id = stores.id','left');
                $mdl->join('categories c', 'items.category_id = c.id','left');

                if($filter->store_id != "") {
                    $mdl->where('p.store_id',$filter->store_id);
                }
                if($filter->category_id != "") {
                    $mdl->where('items.category_id',$filter->category_id);
                }
                if($filter->search != "") {
                    $mdl->orLike('stores.store_name',$filter->search)
                        ->orLike('items.item_name',$filter->search);
                }
                $mdl->where('items.pos_id',$sessData['pos_id']);
                $records = $mdl->findAll();
                $data['report_data'] = $records;
            break;
            case 'stock-valuation':
                $page = 'stock-valuation';
                $data['heading'] = 'Stock Valuation';
                $filename = 'stock_valuation.pdf';

                $mdl = new ItemModel();
                $mdl->select('items.id, items.item_name,items.sku_barcode,u.uom,p.supply_price,p.retail_price,p.current_inventory, p.inventory_value,stores.store_name');
                $mdl->join('items_price p','items.id = p.items_id','left');
                $mdl->join('stores', 'p.store_id = stores.id','left');
                $mdl->join('uom_master u', 'items.uom_id = u.id','left');

                if($filter->store_id != "") {
                    $mdl->where('p.store_id',$filter->store_id);
                }
                if($filter->search != "") {
                    $mdl->orLike('stores.store_name',$filter->search)
                        ->orLike('items.item_name',$filter->search);
                }
                $mdl->where('items.pos_id',$sessData['pos_id']);
                $records = $mdl->findAll();
                $data['report_data'] = $records;
            break;
            case 'stock-take-with-qty':
                $page = 'stock-take-with-qty';
                $data['heading'] = 'Stock Take With Quantity';
                $filename = 'stock_take_with_qty.pdf';

                $mdl = new StoreItemsModel();
                $mdl->select('store_items.*,items.item_name,items.sku_barcode,c.category_name,p.retail_price,stores.store_name,l.location_description as location');
                $mdl->join('items', 'store_items.item_id = items.id','left');
                $mdl->join('stores', 'store_items.store_id = stores.id','left');
                $mdl->join('location l', 'store_items.location_id = l.id','left');
                $mdl->join('categories c', 'items.category_id = c.id','left');
                $mdl->join('items_price p','items.id = p.items_id','left');
                
                if($filter->daterange != "") {
                    $mdl->where('store_items.created_at >=',$startDt);
                    $mdl->where('store_items.created_at <=',$endDt);
                }
                if($filter->store_id != "") {
                    $mdl->where('store_items.store_id',$filter->store_id);
                }
                if($filter->location_id != "") {
                    $mdl->where('store_items.location_id',$filter->location_id);
                }
                if($filter->category_id != "") {
                    $mdl->where('items.category_id',$filter->category_id);
                }
                if($filter->search != "") {
                    $mdl->orLike('stores.store_name',$filter->search)
                        ->orLike('items.item_name',$filter->search);
                }

                $mdl->groupBy('store_items.item_id');
                $mdl->groupBy('store_items.store_id');
                $mdl->groupBy('store_items.location_id');
                $mdl->where('store_items.pos_id',$sessData['pos_id']);
                $mdl->orderBy('store_items.id','desc');
                $records = $mdl->findAll();
                $data['report_data'] = $records;
            break;
            case 'layby-sales':
                $page = 'layby-sales';
                $data['heading'] = 'Layby Sales';
                $filename = 'layby_sales.pdf';

                $mdl = new ContractModel();
                $mdl->select('layby_contract.*, customers.registerd_name, stores.store_name');
                
                if($filter->store_id != "") {
                    $mdl->where('layby_contract.store_id',$filter->store_id);
                }
                if($filter->customer_id != "") {
                    $mdl->where('layby_contract.customer_id',$filter->customer_id);
                }
                if($filter->layby_type != "") {
                    if($filter->layby_type == "1") {
                        $mdl->whereIn('contract_status',[0,2]);
                    } else if($filter->layby_type == "2") {
                        $mdl->whereIn('contract_status',[3,5]);
                    } else if($filter->layby_type == "3") {
                        $mdl->whereIn('contract_status',[4]);
                    }
                }
                if($filter->daterange != "") {
                    $mdl->where('contract_date >=',$startDt);
                    $mdl->where('contract_date <=',$endDt);
                }
                $mdl->join('stores','layby_contract.store_id = stores.id');
                $mdl->join('customers','layby_contract.customer_id = customers.id');
                $mdl->where('layby_contract.pos_id',$sessData['pos_id']);
                $records = $mdl->findAll();

                $thisModel = new ContractModel();
                $laybydata = $thisModel->laybyReports($records);
                $data['report_data'] = $laybydata;
            break;
        }

        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('pages/reports-pdf/'.$page, $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->set_option('isFontSubsettingEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->render();
        $dompdf->stream($filename);
    } 
}