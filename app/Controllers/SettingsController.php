<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\GeneralModel;
use App\Models\CommonModel;
use App\Models\CurrencyModel;
use App\Models\TerminalsModel;
use App\Models\TaxesModel;
use App\Models\EmployeeModel;
use App\Models\StoreModel;
use App\Models\PaymentModel;
use App\Models\WeighingScaleModel;
use App\Models\PaymentMasterModel;
use App\Models\WeighingScaleMaster;
use App\Models\TaxMasterModel;
use App\Models\ReceiptModel;
use App\Models\LocationMaster;
use App\Models\Location;
use App\Models\CurrentInventory;
use App\Models\CurrentInventoryDetails;
use App\Models\ItemModel;
use App\Models\ItemsPriceModel;
use App\Models\BackOrderModel;
use App\Models\CreditNote;
use App\Models\CreditsModel;
use App\Models\ContractModel;
use App\Models\DirectGoodsReceived;
use App\Models\GoodsReceivedModel;
use App\Models\GoodsReturnedModel;
use App\Models\ProductionModel;
use App\Models\PurchaseModel;
use App\Models\Quote;
use App\Models\SellordersModel;
use App\Models\SellOrderEditNote;
use App\Models\TransferModel;
use App\Models\StoreItemsModel;
use App\Models\SalesPaymentModel;

class SettingsController extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function index()
    { 
        $data = [];
        $data['title'] = 'Settings';
        $sessData = getSessionData();
        $data['permission'] = $sessData['permissions'];

        $currencyModel = new CurrencyModel();
        $data['currencies'] = $currencyModel->findAll();

        $terminalModel = new TerminalsModel();
        $data['terminals'] = $terminalModel->findAll();

        $taxesModel = new TaxesModel();
        $data['taxes'] = $taxesModel->GetTaxMasterData();

        $employeeModel = new EmployeeModel();
        $data['employees'] = $employeeModel->GetAllEmployeeData();

        $storeModel = new StoreModel();
        
        $paymentModel = new PaymentModel();
        $data['payments'] = $paymentModel->GetGoodsReceivedData();
        
        $weighingmasterModel = new WeighingScaleMaster();
        $data['weighing_master'] = $weighingmasterModel->findAll();

        $weighingscale = new WeighingScaleModel();
        $data['weighingscales'] = $weighingscale->first();
        
        $terminalModel = new TerminalsModel();
        $data['terminals'] = $terminalModel->GetTerminalData();
        
        $data['base_currency'] = "";
        if($sessData['store_id'] != "") {
            $general = new GeneralModel();
            $generalData = $general->select('general.id,c.currency_code')->join('currencies as c','general.currency_id = c.id')->where('general.store_id',$sessData['store_id'])->first();
            $data['base_currency'] = $generalData['currency_code'];
        }
        
        $currencyModel = new CurrencyModel();
        if($sessData['role_name'] == "Owner"){
            $storeModel->where('pos_id',$sessData['pos_id']);
            $currencyModel->where('pos_id',$sessData['pos_id']);
        }
        $data['stores'] = $storeModel->findAll();
        
        $location_master = new LocationMaster();
        $data['location_master'] = $location_master->where('pos_id',$sessData['pos_id'])->findAll();

        $data['currency'] = $currencyModel->findAll();
        $data['sessionRole'] = $sessData['role_name'];
        //For Filter
        $paymentmasterModel = new PaymentMasterModel();
        $data['payment_master'] = $paymentmasterModel->where('status', 1)->findAll();
        
        $taxmasterModel = new TaxMasterModel();
        $data['tax'] = $taxmasterModel->where('status', 1)->findAll();
        
        $employeeModel = new EmployeeModel();
        $data['employee'] = $employeeModel->findAll();

        $roleModel = new RoleModel();
        $data['role'] = $roleModel->findAll();

        $data['is_super_user'] = $sessData['is_super_user'];
        return $this->template->render('pages/settings/settings', $data); 
    }

    public function Add_Currency()
    {
        $data = [];
        $data['title'] = 'Add Currency'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings');

        $data['currency_master_data'] = getCurrencies();

        return $this->template->render('pages/settings/currency_add', $data); 
    }

    public function Edit_currency($id)
    { 
        $data = [];
        $data['title'] = 'Edit Currency'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings'); 

        $data['currency_master_data'] = getCurrencies();

        $currencyModel = new CurrencyModel();
        $data['currency'] = $currencyModel->where("id",$id)->first();
        return $this->template->render('pages/settings/currency_add', $data); 
    }

    public function Add_Terminal()
    {
        $data = [];
        $data['title'] = 'Add Terminals';
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings');

        $sessData = getSessionData(); 
      
        $storeModel = new StoreModel();
        $storeModel->where('pos_id',$sessData['pos_id']);
        
        $data['stores'] = $storeModel->where('status', 1)->findAll();

        $location = new Location();
        $data['location'] = $location->where('pos_id',$sessData['pos_id'])->where('status',1)->findAll();

        return $this->template->render('pages/settings/terminals_add', $data); 
    }

    public function Edit_terminal($id)
    { 
        $data = [];
        $data['title'] = 'Edit Terminals'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings'); 

        $session = session();
        $user_id = $session->get('id');
        $empModel = new EmployeeModel();
        $data['emp'] = $empModel->GetEmployeeData($user_id);
        $data['store_id'] = $data['emp']['stores'][0]['store_id'];
        $sessData = getSessionData(); 
        
        $terminalModel = new TerminalsModel();
        $data['terminals'] = $terminalModel->where("id",$id)->first();

        $storeModel = new StoreModel();
        $data['stores'] = $storeModel->where('status', 1)->findAll();

        $location = new Location();
        $data['location'] = $location->where('pos_id',$sessData['pos_id'])->where('status',1)->findAll();
        return $this->template->render('pages/settings/terminals_add', $data); 
    }

    public function Add_Tax()
    {
        $data = [];
        $data['title'] = 'Add Tax'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings'); 
        
        $taxmasterModel = new TaxMasterModel();
        $data['tax'] = $taxmasterModel->where('status', 1)->findAll();
        return $this->template->render('pages/settings/tax_add', $data); 
    }

    public function Edit_Tax($id)
    {
        $data = [];
        $data['title'] = 'Edit Tax'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings'); 

        $taxModel = new TaxesModel();
        $data['taxes'] = $taxModel->where("id",$id)->first();

        $taxmasterModel = new TaxMasterModel();
        $tax = $taxmasterModel->where('id', $data['taxes']['tax_type_id'])->first();
        $data['taxes']['tax_name'] = $tax['tax_type'];
      
        return $this->template->render('pages/settings/tax_add', $data); 
    }

    public function Add_Payment()
    {
        $data = [];
        $data['title'] = 'Add Payment'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings');

        $storeModel = new StoreModel();
        $data['stores'] = $storeModel->where('status', 1)->findAll();
        
        $paymentmasterModel = new PaymentMasterModel();
        $data['payment_master'] = $paymentmasterModel->where('status', 1)->findAll();
         
        return $this->template->render('pages/settings/payment_type_add', $data); 
    }

    public function Edit_payment($id)
    { 
        $data = [];
        $data['title'] = 'Edit Payment'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings'); 

        $paymentModel = new PaymentModel();
        $data['payments'] = $paymentModel->where("id",$id)->first();

        $storeModel = new StoreModel();
        $data['stores'] = $storeModel->where('status', 1)->findAll();
        
        $paymentmasterModel = new PaymentMasterModel();
        $data['payment_master'] = $paymentmasterModel->where('status', 1)->findAll();
        
        
        return $this->template->render('pages/settings/payment_type_add', $data); 
    }

    public function Add_WeighingScale()
    {
        $data = [];
        $data['title'] = 'Add Weighing Scale'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings');
         
        return $this->template->render('pages/settings/settings', $data); 
    }
    
    public function Add_General()
    {
        $data = [];
        $data['title'] = 'Add General'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings');
         
        return $this->template->render('pages/settings/settings', $data); 
    }
    
    public function AddReceipt()
    {
        $data = [];
        $data['title'] = 'Add Receipt'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings');
         
        $session = session();
        $user_id = $session->get('id');
        $empModel = new EmployeeModel();
        $data['emp'] = $empModel->GetEmployeeData($user_id);

        $data['store_id'] = "";
        if(!empty($data['stores'])){
        $data['store_id'] = $data['emp']['stores'][0]['store_id'];
        }

        return $this->template->render('pages/settings/settings', $data); 
    }
    
    public function Post_Data_Settings()
    {
        if ($this->request->getMethod() == "post") {
           
            $post = $this->request->getVar();
            switch($post['table_name']){
                case 'receipt':
                    $receipt_logo = "";
                    if(!empty($_FILES['receipt_logo']['name']))
                    {
                        $image = $this->request->getFile('receipt_logo');
                        $receipt_logo = 'rec_'.time().'.'.$image->getClientExtension();
                        $image->move(FCPATH . 'public/uploads/receiptlogo',$receipt_logo);
                    }
                    else
                    {
                        $receipt_logo = isset($post['receipt_image_old'])?$post['receipt_image_old']:"";
                    } 
                    $store_logo = "";
                    if(!empty($_FILES['store_logo']['name']))
                    {
                        $image = $this->request->getFile('store_logo');
                        $store_logo = 'store_'.time().'.'.$image->getClientExtension();
                        $image->move(FCPATH . 'public/uploads/storelogo',$store_logo);
                    }
                    else
                    {
                        $store_logo = isset($post['store_image_old'])?$post['store_image_old']:"";
                    } 
                    $data = [
                        'store_id' => isset($post["store_id"])?$post["store_id"]:0,
                        'receipt_title' => isset($post["receipt_title"])?$post["receipt_title"]:0,
                        'receipt_footer' => isset($post["receipt_footer"])?$post["receipt_footer"]:0,
                        'receipt_language' => isset($post["receipt_language"])?$post["receipt_language"]:0,
                        'receipt_logo' => $receipt_logo,
                        'store_logo' => $store_logo
                    ]; 
                break; 
                case 'role':  
                    $data = [
                        'pos_id'=>isset($sessData['pos_id'])?$sessData['pos_id']:'',
                        'role_name' => $post["role_name"],
                        'pos' => isset($post["pos"])?$post["pos"]:"0",
                        'pos_permission' => isset($post["pos_permission"])?json_encode($post["pos_permission"]):"0",
                        'back_office' => isset($post["back_office"])?$post["back_office"]:0,
                        'back_office_permission' => isset($post["back_office_permission"])?json_encode($post["back_office_permission"]):"0",
                        'waiter' => isset($post["waiter"])?$post["waiter"]:0,
                        'waiter_permission' => isset($post["waiter_permission"])?json_encode($post["waiter_permission"]):"0",
                        'status' => isset($post["status"])?$post["status"]:0
                    ];
                break;
                case 'currencies':
                    $data = [
                        'pos_id' => isset($sessData['pos_id'])?$sessData['pos_id']:'',
                        'currency_code' => $post["currency_code"],
                        'currency_symbol' => isset($post["currency_symbol"])?$post["currency_symbol"]:"0",
                        'currency_name' => isset($post["currency_name"])?$post["currency_name"]:0,
                        'decimal_places' => isset($post["decimal_places"])?$post["decimal_places"]:0,
                        'format' => isset($post["format"])?$post["format"]:0,
                        'exchange_date' => isset($post["exchange_date"])?$post["exchange_date"]:0,
                        'exchange_rate' => isset($post["exchange_rate"])?$post["exchange_rate"]:0,
                        'status' => isset($post["status"])?$post["status"]:0
                    ];          
                break;
                case 'terminals':
                    $data = [
                        'pos_id'=>isset($sessData['pos_id'])?$sessData['pos_id']:'',
                        'terminal_name' => isset($post["terminal_name"])?$post["terminal_name"]:0,
                        'type' => isset($post["type"])?$post["type"]:0,
                        'store_id' => isset($post["store_id"])?$post["store_id"]:"0",
                        'location_id' => isset($post["location_id"])?$post["location_id"]:"0",
                        'sales_invoice_prefix' => isset($post["sales_invoice_prefix"])?$post["sales_invoice_prefix"]:0,
                        'sales_invoice_starting_no' => isset($post["sales_invoice_starting_no"])?$post["sales_invoice_starting_no"]:0,
                        'sales_return_prefix' => isset($post["sales_return_prefix"])?$post["sales_return_prefix"]:0,
                        'sales_return_starting_no' => isset($post["sales_return_starting_no"])?$post["sales_return_starting_no"]:0,
                        'status' => isset($post["status"])?$post["status"]:0
                    ];
                break;
                case 'tax_master':
                    $data = [
                        'tax_type' => isset($post["tax_type"])?$post["tax_type"]:0,
                        'status' => isset($post["status"])?$post["status"]:0
                    ];
                break;
                case 'payments':
                    $data = [
                        'payment_type_id' => isset($post["payment_type_id"])?$post["payment_type_id"]:0,
                        'type_id' => isset($post["type_id"])?$post["type_id"]:0,
                        'receipt_name' => isset($post["receipt_name"])?$post["receipt_name"]:0,
                        'track_card_details' => isset($post["track_card_details"])?$post["track_card_details"]:0,
                        'mdr_collect_from_customer' => isset($post["mdr_collect_from_customer"])?$post["mdr_collect_from_customer"]:0,
                        'store_id' => isset($post["store_id"])?json_encode($post["store_id"]):"0",
                        'status' => isset($post["status"])?$post["status"]:0
                    ];
                break;
                case 'weighingscales':
                    $data = [
                        'prefix' => isset($post["prefix"])?$post["prefix"]:0,
                        'entry_code' => isset($post["entry_code"])?$post["entry_code"]:0,
                        'type' => isset($post["type"])?$post["type"]:0,
                        'digit' => isset($post["digit"])?$post["digit"]:0
                    ];
                break;
                case 'general':
                    $data = [
                        'store_id' =>isset($post['store_id'])?$post['store_id']:"",
                        // 'tax_id' =>isset($post["tax_id"])?$post["tax_id"]:"",
                        'currency_id' =>isset($post["currency_id"])?$post["currency_id"]:"",
                        'opening_hour' =>isset($post["opening_hour"])?$post["opening_hour"]:"",
                        'closing_hour' =>isset($post["closing_hour"])?$post["closing_hour"]:"",
                        'rounding_to' =>isset($post["rounding_to"])?$post["rounding_to"]:0,
                        'middle_point' =>isset($post["middle_point"])?$post["middle_point"]:0,
                        'from_email' =>isset($post["from_email"])?$post["from_email"]:"",
                        'layby_deposit_per' =>isset($post["layby_deposit_per"])?$post["layby_deposit_per"]:0,
                        'layby_source_location' =>isset($post["layby_source_location"])?$post["layby_source_location"]:"",
                        'general_features' =>isset($post["general_features"])?json_encode($post["general_features"]):0
                    ];
                break;    
            }

            $db = db_connect();
            $commonModel = new CommonModel($db);
            if(isset($post['id']) && empty($post['id'])) {
                $id = $post['id'];
                $result = $commonModel->AddData($post['table_name'],$data);
                switch($post['table_name']){
                    case 'tax_master':
                        $data = [
                            'tax_type_id' => $result,
                            'tax_rate' => isset($post["tax_rate"])?$post["tax_rate"]:0,
                            'status' => isset($post["status"])?$post["status"]:0
                        ];
                        $result = $commonModel->AddData('taxes',$data);
                    break;
                }
                return json_encode([
                    "status" => "true",
                    "message" => "New Data added successfully",
                ]);
            }
            else{
                $id = $post['id'];
                $result = $commonModel->UpdateData($post['table_name'],$id,$data);
                switch($post['table_name']){
                    case 'tax_master':
                        $data = [
                            'tax_type_id' => $id,
                            'tax_rate' => isset($post["tax_rate"])?$post["tax_rate"]:0,
                            'status' => isset($post["status"])?$post["status"]:0
                        ];
                        $result = $commonModel->UpdateData('taxes',$post['tax_id'],$data);
                    break;
                }
                return json_encode([
                    "status" => "true",
                    "message" => "Data updated successfully",
                ]);
            } 
        }           
    }
    
    public function getPaymenttype()
    {
       $request = service('request');
       $postData = $request->getPost();
       
       $dtpostData = $postData['data'];
       $response = array();
      ## Read value
       $draw = $dtpostData['draw'];
       $start = $dtpostData['start'];
       $rowperpage = $dtpostData['length']; // Rows display per page
       $columnIndex = $dtpostData['order'][0]['column']; // Column index
       $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
       $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
       $advancesearchValue = $dtpostData['advFilter']; // Search value
       $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $cm = new PaymentModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

       ## Total number of records with filtering
       ## Fetch records
        
        $cm->select('payments.*,payments.id as p_id,p.payment_type');
        $cm->join('payment_type_master as p', 'p.id = payments.type_id');  
        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('payment_type_id', $searchValue);
        }
        if(!empty($advancesearchValue['equal']['type_id'])){
            $searchStatus = $advancesearchValue['equal']['type_id'];
            $cm->where('type_id',$searchStatus);
        }
         if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $cm->where('payments.status', 1);
            }else{ 
                $cm->where('payments.status', 0);
            }
        }
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);
        $totalRecordwithFilter = count($records);
       
       $data = array();
       
       ## Response
       $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $records,
          "token" => csrf_hash() // New token hash
       );

       return $this->response->setJSON($response);
   }
   
   public function getTax()
    {
       $request = service('request');
       $postData = $request->getPost();
       
       $dtpostData = $postData['data'];
       $response = array();
       ## Read value
       $draw = $dtpostData['draw'];
       $start = $dtpostData['start'];
       $rowperpage = $dtpostData['length']; // Rows display per page
       $columnIndex = $dtpostData['order'][0]['column']; // Column index
       $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
       $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
       $advancesearchValue = $dtpostData['advFilter']; // Search value
       $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $cm = new TaxesModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

       ## Total number of records with filtering
       ## Fetch records
        $cm->select('taxes.*,taxes.id as t_id,t.tax_type');
        $cm->join('tax_master as t', 't.id = taxes.tax_type_id');  
        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('tax_type_id', $searchValue);
        }
        if(!empty($advancesearchValue['equal']['tax_type_id'])){
            $searchStatus = $advancesearchValue['equal']['tax_type_id'];
            $cm->where('tax_type_id',$searchStatus);
        }
         if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $cm->where('taxes.status', 1);
            }else{ 
                $cm->where('taxes.status', 0);
            }
        }
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);
        $totalRecordwithFilter = count($records);
       
       $data = array();
       
       ## Response
       $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $records,
          "token" => csrf_hash() // New token hash
       );

       return $this->response->setJSON($response);
   }
   
   public function getStore()
    {
       $request = service('request');
       $postData = $request->getPost();
       
       $dtpostData = $postData['data'];
       $response = array();
       ## Read value
       $draw = $dtpostData['draw'];
       $start = $dtpostData['start'];
       $rowperpage = $dtpostData['length']; // Rows display per page
       $columnIndex = $dtpostData['order'][0]['column']; // Column index
       $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
       $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
       $advancesearchValue = $dtpostData['advFilter']; // Search value
       $searchValue = $advancesearchValue['match']['search'];
       
       $sessData = getSessionData();
       ## Total number of records without filtering
       $cm = new StoreModel();
       $totalRecords = $cm->select('id')->where('pos_id',$sessData['pos_id'])
                ->countAllResults();

       ## Total number of records with filtering
       ## Fetch records
        $cm->select('stores.*,stores.id as s_id,(select count(id) as total from terminals where store_id = stores.id) as total_terminals');

        /*if ($sessData['role_name'] == "Owner") {
            $cm->where('stores.owner_id',$sessData['id']);
        }*/
       
        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('store_name', $searchValue);
        }
        if(!empty($advancesearchValue['equal']['store_name'])){
            $searchStatus = $advancesearchValue['store_name'];
            $cm->where('store_name',$searchStatus);
        }
         if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $cm->where('status', 1);
            }else{ 
                $cm->where('status', 0);
            }
        }
        $cm->where('pos_id',$sessData['pos_id']);
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);
        $totalRecordwithFilter = count($records);
       
       $data = array();
       
       ## Response
       $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $records,
          "token" => csrf_hash() // New token hash
       );

       return $this->response->setJSON($response);
   }
   
    public function getTerminal()
    {
       $request = service('request');
       $postData = $request->getPost();
       
       $dtpostData = $postData['data'];
       $response = array();
       ## Read value
       $draw = $dtpostData['draw'];
       $start = $dtpostData['start'];
       $rowperpage = $dtpostData['length']; // Rows display per page
       $columnIndex = $dtpostData['order'][0]['column']; // Column index
       $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
       $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
       $advancesearchValue = $dtpostData['advFilter']; // Search value
       $searchValue = $advancesearchValue['match']['search'];
       $sessData = getSessionData();

       ## Total number of records without filtering
       $cm = new TerminalsModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

       ## Total number of records with filtering
       ## Fetch records
        $cm->select('terminals.*,terminals.id as t_id,s.store_name');
        $cm->join('stores as s', 's.id = terminals.store_id');

        if ($sessData['role_name'] == "Owner") {
            $cm->where('s.owner_id',$sessData['id']);
        }      
        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('terminal_name', $searchValue);
        }
         if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $cm->where('terminals.status', 1);
            }else{ 
                $cm->where('terminals.status', 0);
            }
        }
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);
        $totalRecordwithFilter = count($records);
       
        
        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $records,
          "token" => csrf_hash() // New token hash
        );
        return $this->response->setJSON($response);
   }

   public function getCurrency()
   {
       $request = service('request');
       $postData = $request->getPost();
       $dtpostData = $postData['data'];
       $response = array();
       ## Read value
       $draw = $dtpostData['draw'];
       $start = $dtpostData['start'];
       $rowperpage = $dtpostData['length']; // Rows display per page
       $columnIndex = $dtpostData['order'][0]['column']; // Column index
       $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
       $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
       $advancesearchValue = $dtpostData['advFilter']; // Search value
       $searchValue = $advancesearchValue['match']['search'];
       
       $sessData = getSessionData();
       $generalData = "";
       if($sessData['store_id'] != "") {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->first();
       }
       ## Total number of records without filtering
       $cm = new CurrencyModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

       ## Total number of records with filtering
       
       ## Fetch records
       
        $cm->select('*');
        if ($sessData['pos_id'] != "") {
            $cm->where('pos_id',$sessData['pos_id']);
        }

        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('currency_name', $searchValue);
        }
        if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $cm->where('status', 1);
            }else{ 
                $cm->where('status', 0);
            }
        }

        $cm->orderBy($columnName,$columnSortOrder);
        $records = $cm->findAll($rowperpage, $start);

        $totalRecordwithFilter = count($records);

        $aaData = array();
        if(!empty($records)) {
            foreach($records as $key => $val) {
                $obj['id'] = $val['id'];
                $obj['currency_code'] = $val['currency_code'];
                $obj['currency_name'] = $val['currency_name'];
                $obj['currency_symbol'] = $val['currency_symbol'];
                $obj['decimal_places'] = $val['decimal_places'];
                $obj['exchange_date'] = $val['exchange_date'];
                $obj['exchange_rate'] = $val['exchange_rate'];
                $obj['format'] = $val['format'];
                $obj['created_at'] = $val['created_at'];
                $obj['is_base_currency'] = false;
                $aaData[] = $obj;
                if(isset($generalData['currency_id']) && $val['id'] == $generalData['currency_id']) {
                    $aaData[$key]['currency_name'].= isset($generalData)?'<span style="font-size:smaller;color:#37BC9B">&nbsp;(Base Currency)</span>':'';
                    $aaData[$key]['is_base_currency'] = true;
                    $e=$aaData[$key];
                    unset($aaData[$key]);
                    array_unshift($aaData, $e);
                }
            }
        }       
        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $aaData,
          "token" => csrf_hash() // New token hash
        );

       return $this->response->setJSON($response);
   }

   public function getReceipt()
   {
        $post = $this->request->getVar();

        $receipt = new ReceiptModel();
        $data = $receipt->where('store_id',$post['id'])->first();

        if(!empty($data)) {
            return json_encode([
                "status" => "true",
                "message" => "Get Receipt successfully",
                "data" => $data
            ]);
        } else {
            return json_encode([
                "status" => "false"
            ]);
        }
   }

   public function getGeneralSettings()
   {
        $post = $this->request->getVar();
        $sessData = getSessionData();
        $general = new GeneralModel();
        $data = $general->where('store_id',$post['id'])->first();

        $location = new Location();
        $locationData = $location->where('pos_id',$sessData['pos_id'])->where('store_id',$post['id'])->where('location_type',1)->where('status',1)->findAll();

        if(!empty($data)) {
            return json_encode([
                "status" => "true",
                "message" => "Get Receipt successfully",
                "data" => $data,
                "location" => $locationData
            ]);
        } else {
            return json_encode([
                "status" => "false"
            ]);
        }
   }
   public function clearStockandTransaction()
   {
        $post = $this->request->getVar();
        $sessData = getSessionData();
        $date = $post['date'];

        if($post['type'] == "1") {
            $this->clearStock($sessData, $date);

            return json_encode([
                "status" => "true",
                "message" => "Stock cleared successfully"
            ]);
        } elseif($post['type'] == "2") {
            $this->clearTransactions($sessData, $date);

            return json_encode([
                "status" => "true",
                "message" => "Transaction cleared successfully"
            ]);
        } elseif($post['type'] == "3") {
            $this->clearStock($sessData);
            $this->clearTransactions($sessData, $date);

            return json_encode([
                "status" => "true",
                "message" => "Stock & Transactions cleared successfully"
            ]);
        }
        
   }

   public function clearStock($sessData, $date)
   {
        $db = db_connect();
        $commonModel = new CommonModel($db);

        $uInventoryData = array('quantity' => 0);
        $commonModel->UpdateDataByField('current_inventory','pos_id',$sessData['pos_id'],$date,$uInventoryData);

        $uInventoryDetailData = array('qty'=> 0);
        $commonModel->UpdateDataByField('current_inventory_details','pos_id',$sessData['pos_id'],$date,$uInventoryDetailData);

        $uItemsPriceInventory = array('current_inventory'=> 0,'inventory_value'=> 0);
        $items = new ItemModel();
        $itemData = $items->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($itemData, 'id');

        $itemsPrice = new ItemsPriceModel();
        $itemsPrice->whereIn("items_id", $ids)->set($uItemsPriceInventory)->update();

        $storeItm = new StoreItemsModel();
        $storeItm->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        return true;
   }

   public function clearTransactions($sessData,$date)
   {
        $db = db_connect();
        $commonModel = new CommonModel($db);

        $boMdl = new BackOrderModel();
        $boData = $boMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=', $date)->findAll();
        $ids = array_column($boData, 'id');
        if(!empty($ids)) {
            $commonModel->DeleteMultipleDataByField('back_order_item','b_o_id',$ids,$date);
        }
        $boMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        $cnMdl = new CreditNote();
        $cnData = $cnMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($cnData, 'id');
        if(!empty($ids)) {
            $commonModel->DeleteMultipleDataByField('credit_notes_items','crn_id',$ids,$date);
        }
        $cnMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        $commonModel->DeleteMultipleDataByField('credits','pos_id',[$sessData['pos_id']],$date);
        
        $dGoodsRecMdl = new DirectGoodsReceived();
        $dgData = $dGoodsRecMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($dgData, 'id');
        if(!empty($ids)) {
            $commonModel->DeleteMultipleDataByField('direct_goods_received_item','direct_received_id',$ids,$date);
        }
        $dGoodsRecMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        $goodsRecMdl = new GoodsReceivedModel();
        $gData = $goodsRecMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($gData, 'id');
        if(!empty($ids)) {
            $commonModel->DeleteMultipleDataByField('goods_received_items','goods_received_id',$ids,$date);
        }
        $goodsRecMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        $goodsRetMdl = new GoodsReceivedModel();
        $returnData = $goodsRetMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($returnData, 'id');
        // $commonModel->DeleteMultipleDataByField('goods_returned_items','goods_received_id',$ids);
        $goodsRetMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        $contractMdl = new ContractModel();
        $contData = $contractMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($contData, 'id');
        if(!empty($ids)) {
            $commonModel->DeleteMultipleDataByField('layby_contract_items','contract_id',$ids,$date);
            $commonModel->DeleteMultipleDataByField('layby_contract_transactions','contract_id',$ids,$date);
        }
        $contractMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        $prodMdl = new ProductionModel();
        $prodData = $prodMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($prodData, 'id');
        if(!empty($ids)) {
            $commonModel->DeleteMultipleDataByField('production_items','production_id',$ids,$date);
        }
        $prodMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        $purchaseMdl = new PurchaseModel();
        $purchaseData = $purchaseMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($purchaseData, 'id');
        if(!empty($ids)) {
            $commonModel->DeleteMultipleDataByField('purchase_order_item','p_o_id',$ids,$date);
        }
        $purchaseMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        $qtMdl = new Quote();
        $qtData = $qtMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($qtData, 'id');
        if(!empty($ids)) {
            $commonModel->DeleteMultipleDataByField('quote_items','quote_id',$ids,$date);
        }
        $qtMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        $sellMdl = new SellordersModel();
        $sellData = $sellMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($sellData, 'id');
        if(!empty($ids)) {
            $commonModel->DeleteMultipleDataByField('sell_items','s_o_id',$ids,$date);
            $commonModel->DeleteMultipleDataByField('sell_order_editnote','s_o_id',$ids,$date);
            $sPays = new SalesPaymentModel();
            $sPays->whereIn('invoice_id',$ids)->delete();
        }
        $sellMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        $transferMdl = new TransferModel();
        $transferData = $transferMdl->select('id')->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->findAll();
        $ids = array_column($transferData, 'id');
        if(!empty($ids)) {
            $commonModel->DeleteMultipleDataByField('transfer_items','transfer_id',$ids,$date);
        }
        $transferMdl->where('pos_id',$sessData['pos_id'])->where('created_at <=',$date)->delete();

        return true;
   }
}
