<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ContractModel;
use App\Models\ContractItemsModel;
use App\Models\ContractDepositModel;
use App\Models\ContractTransactionModel;
use App\Models\CustomersModel;
use App\Models\CurrencyModel;
use App\Models\ItemModel;
use App\Models\GeneralModel;
use App\Models\StoreModel;
use App\Models\StoreItemsModel;
use App\Models\CommonModel;
use App\Models\CurrentInventory;
use App\Models\CurrentInventoryDetails;
use App\Models\Location;

class LayByController extends BaseController
{
    public function index()
    {
        $data = [];
        $data['title'] = 'Lay By'; 

        return $this->template->render('pages/lay-by/lay-by', $data); 
    }

    public function addContract()
    {
      $data = [];
      $data['title'] = 'Add Lay By'; 
      $data['main_menu'] = 'Lay By'; 
      $data['main_menu_url'] = base_url('layby');
      $data['page_title'] = 'Add Contract';
      $sessData = getSessionData();

        $base_currency_id = '';
        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['layby_deposit'] = 25;

        $currencyModel = new CurrencyModel();

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $base_currency_id = $generalData['currency_id'];
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['layby_deposit'] = $generalData['layby_deposit_per'];
            }
        }

        $storeModel = new StoreModel();
        if($sessData['role_name'] == "Staff") {
            $storeModel->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $storeModel->where('pos_id',$sessData['pos_id']);
            $currencyModel->where('pos_id',$sessData['pos_id']);
        }
        $currencyModel->where('id !=',$base_currency_id);
        $data['currency'] = $currencyModel->findAll();

        $customers = new CustomersModel();
        $data['customers'] = $customers->where('pos_id',$sessData['pos_id'])->findAll();

        $items = new ItemModel();
        $itemlist = $items->getCanSaleItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

      return $this->template->render('pages/lay-by/contract_add', $data);
    }

    public function editContract($id)
    {
        $data = [];
        $data['title'] = 'Edit Lay By'; 
        $data['main_menu'] = 'Lay By'; 
        $data['main_menu_url'] = base_url('layby');
        $data['page_title'] = 'Edit Contract';
        $sessData = getSessionData();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['layby_deposit'] = 25;

        $storeModel = new StoreModel();
        $currencyModel = new CurrencyModel();

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['layby_deposit'] = $generalData['layby_deposit_per'] > 0 ? $generalData['layby_deposit_per'] : 25;
            }
        }

        if($sessData['role_name'] == "Staff") {
            $storeModel->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $storeModel->where('pos_id',$sessData['pos_id']);
            $currencyModel->where('pos_id',$sessData['pos_id']);
        }
        $currencyModel->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        $contract = new ContractModel();
        $data['contract'] = $contract->select('layby_contract.*, c.currency_code')->join('currencies c','layby_contract.currency_id = c.id','left')->where('layby_contract.id',$id)->first();

        $contractItems = new ContractItemsModel();
        $data['contract_items'] = $contractItems->where('contract_id',$id)->findAll();

        $customers = new CustomersModel();
        $data['customers'] = $customers->where('pos_id',$sessData['pos_id'])->findAll();

        $items = new ItemModel();
        $itemlist = $items->getItemList($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        return $this->template->render('pages/lay-by/contract_add', $data);
    }

    public function getLaybyContract()
    {   
       $request = service('request');
       $postData = $request->getPost();
       $sessData = getSessionData();
       
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
       // $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $cm = new ContractModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

        ## Fetch records
        $cm->select('layby_contract.*,customers.registerd_name,customers.phone,customers.address');
        $cm->join('customers','layby_contract.customer_id = customers.id','left');
        $cm->where('layby_contract.pos_id',$sessData['pos_id']);
        $cm->whereIn('contract_status',[0,2]);
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            $currency_symbol = $generalData != '' ? $generalData['currency_symbol'] : '';
        }

        $contractTxnData = new ContractTransactionModel();
      
        foreach($records as $key=>$row){
       
            $countRows = $contractTxnData->countDepositData($row['id']);
            $balance = $contractTxnData->checkContractDepositAmt($row['id']);
            $checkRefundAmt = $contractTxnData->checkContractRefundAmt($row['id']);

            $records[$key]['deposit_count'] = $countRows;
            $records[$key]['balance'] = number_format((float)$row['total_amount'] - ((float)$balance['amount'] + $checkRefundAmt['amount']),2);//number_format($balance['amount'],2);
            $records[$key]['currency'] = $currency_symbol;
        }
        
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

    public function getLaybyContractPayment()
    {   
       $request = service('request');
       $postData = $request->getPost();
       $sessData = getSessionData();
       
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
       // $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $cm = new ContractModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

        ## Fetch records
        $cm->select('layby_contract.*,customers.registerd_name,customers.phone,customers.address');
        $cm->join('customers','layby_contract.customer_id = customers.id','left');
        $cm->where('layby_contract.pos_id',$sessData['pos_id']);
        $cm->whereIn('contract_status',[0,2]);
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            $currency_symbol = $generalData != '' ? $generalData['currency_symbol'] : '';
        }

        $contractTxnData = new ContractTransactionModel();
      
        foreach($records as $key=>$row){
            $countRows = $contractTxnData->countDepositData($row['id']);
            $balance = $contractTxnData->checkContractDepositAmt($row['id']);
            $checkRefundAmt = $contractTxnData->checkContractRefundAmt($row['id']);
            $records[$key]['deposit_count'] = $countRows;
            $records[$key]['balance'] = number_format((float)$row['total_amount'] - ((float)$balance['amount'] + $checkRefundAmt['amount']),2);
            $records[$key]['currency'] = $currency_symbol;
        }
        
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

    public function getLaybyContractTxn()
    {   
       $request = service('request');
       $postData = $request->getPost();
       $sessData = getSessionData();
       
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
       // $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $cm = new ContractModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

        ## Fetch records
        $cm->select('layby_contract.*,customers.registerd_name,customers.phone,customers.address');
        $cm->join('customers','layby_contract.customer_id = customers.id','left');
        $cm->where('layby_contract.pos_id',$sessData['pos_id']);
        if($advancesearchValue['tab'] == 'refund') {
          $cm->whereIn('contract_status',[0,2,4]);
        } else if($advancesearchValue['tab'] == 'cancel') {
          $cm->whereIn('contract_status',[0,2,3]);
        } else {
          $cm->whereIn('contract_status',[0,2,5]);
        }
        
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            $currency_symbol = $generalData != '' ? $generalData['currency_symbol'] : '';
        }

        $contractTxnData = new ContractTransactionModel();
      
        foreach($records as $key=>$row){
            $countRows = $contractTxnData->countDepositData($row['id']);
            $balance = $contractTxnData->checkContractDepositAmt($row['id']);
            $checkRefundAmt = $contractTxnData->checkContractRefundAmt($row['id']);
            $records[$key]['deposit_count'] = $countRows;
            $records[$key]['balance'] = number_format((float)$row['total_amount'] - ((float)$balance['amount'] + $checkRefundAmt['amount']),2);
            $records[$key]['currency'] = $currency_symbol;
        }
        
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

    public function getContractDepositData()
    {
        $id = $this->request->getVar('id');
        $contractDeposit = new ContractTransactionModel();
        $data = $contractDeposit->GetDepositData($id);
        
        $contract = new ContractModel();
        $contractData = $contract->select('layby_contract.*,customers.address')->join('customers','layby_contract.customer_id = customers.id','left')->where('layby_contract.id',$id)->first();

        $deposit = 0;
        $remaining = $contractData['total_amount'];
        $checkDepositAmt = $contractDeposit->checkContractDepositAmt($id);
        $checkRefundAmt = $contractDeposit->checkContractRefundAmt($id);
        if(!empty($data)) {
            $deposit = $checkDepositAmt['amount'];
            $remaining = sprintf('%0.2f',(float)$contractData['total_amount'] - ((float)$checkDepositAmt['amount'] + $checkRefundAmt['amount']));
        }

        // $remaining = number_format(abs((float)$contractData['total_amount'] - $transaction),2);
        return json_encode(['status'=>"true",'message'=>'Fetch Data','contractData'=>$contractData,'data'=>$data,'total_amount'=>$contractData['total_amount'],'total_deposit'=>sprintf('%0.2f',$deposit),'remaining_amt'=>$remaining]); 
    }

    public function getLaybyPayment()
    {   
       $request = service('request');
       $postData = $request->getPost();
       $sessData = getSessionData();
       
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
       // $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $cm = new ContractModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

        ## Fetch records
        $cm->select('layby_contract.*,customers.registerd_name,customers.phone,customers.address');
        $cm->join('customers','layby_contract.customer_id = customers.id','left');
        $cm->where('layby_contract.pos_id',$sessData['pos_id']);
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            $currency_symbol = $generalData != '' ? $generalData['currency_symbol'] : '';
        }

        $subcategoryModel = new ContractItemsModel();
      
        $subcat = [];
        /*foreach($records as $key=>$row){
            $subcat = $subcategoryModel->GetSubCategoryData($row['id']);
            $records[$key]['sub_category'] = $subcat;
        }*/
        
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

    public function getCompletedLaybyContract()
    {
        $request = service('request');
        $postData = $request->getPost();
        $sessData = getSessionData();
       
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
        // $searchValue = $advancesearchValue['match']['search'];
      
        ## Total number of records without filtering
        $cm = new ContractModel();
        $totalRecords = $cm->select('id')
                ->countAllResults();

        ## Fetch records
        $cm->select('layby_contract.*,customers.registerd_name,customers.phone,customers.address');
        $cm->join('customers','layby_contract.customer_id = customers.id','left');
        $cm->where('layby_contract.pos_id',$sessData['pos_id']);
        $cm->where('layby_contract.contract_status',1);
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);

        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            $currency_symbol = $generalData != '' ? $generalData['currency_symbol'] : '';
        }

        $contractTxnData = new ContractTransactionModel();
      
        foreach($records as $key=>$row){
            $countRows = $contractTxnData->countDepositData($row['id']);
            $balance = $contractTxnData->checkContractDepositAmt($row['id']);
            $checkRefundAmt = $contractTxnData->checkContractRefundAmt($row['id']);
            $records[$key]['deposit_count'] = $countRows;
            $records[$key]['balance'] = number_format((float)$row['total_amount'] - ((float)$balance['amount'] + $checkRefundAmt['amount']),2);
            $records[$key]['currency'] = $currency_symbol;
        }
        
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

    public function post_Layby_Data()
    {
        if ($this->request->getMethod() == "post") 
        {
            $sessData = getSessionData();
            $post = $this->request->getVar();
            $genData = "";
          // p($post);
            switch($post['table_name'])
            {
                case 'layby_contract':
                    $store_id = isset($post["store_id"])?$post["store_id"]:$sessData['store_id'];
                    $general = new GeneralModel();
                    $genData = $general->where('store_id',$sessData['store_id'])->first();
                    $location_id = "";
                    if(isset($genData) && $genData['layby_source_location'] != "") {
                      $location_id = $genData['layby_source_location'];
                    } else {
                      $location = new Location();
                      $locData = $location->where('store_id',$store_id)->where('location_type',1)->where('status',1)->first();
                      if(empty($locData)) {
                        return json_encode([
                          "status" => "false",
                          "message" => "No Front Location provided in the store.",
                        ]);
                      } else {
                        $location_id = $locData['id'];
                      }
                    }

                    foreach($post['items'] as $item) {
                      $invtQuery = new CurrentInventory();
                      $invtRow = $invtQuery->where('item_id',$item['item_id'])->where('store_id',$sessData['store_id'])->where('location_id',$location_id)->first();
                      
                      $detail = new CurrentInventoryDetails();
                      $records = $detail->where('current_inventory_id', $invtRow['id'])->where('qty >', 0)->orderBy('lot_no', 'ASC')->countAll();
                      if($records == 0) {
                        return json_encode([
                          "status" => "false",
                          "message" => "Sale failed due to insufficient stock.",
                        ]);
                      }
                    }
                    
                    $data = [
                        'pos_id' => $sessData['pos_id'],
                        'store_id' => $store_id,
                        'customer_id' => $post["customer_id"],
                        'first_name' => $post['firstname'],
                        'last_name'  => $post['lastname'],
                        'phone' => $post['phone'],
                        'country_code' => $post['country_code'],
                        // 'address' => $post['address'],
                        // 'zipcode' => $post['zip'],
                        // 'city' => $post['city'],
                        'base_currency_id' => $post['base_currency_id'],
                        'currency_id' => $post['exchange_rate'],
                        'currency_rate' => isset($post["currency_rate"])?$post["currency_rate"]:"0",
                        'terms' => isset($post["terms"])?$post["terms"]:"",
                        'due_date' => isset($post["due_date"])?$post["due_date"]:"0",
                        'currency_discount' => isset($post['currency_discount'])?$post['currency_discount']:"",
                        'total_discount' => $post['total_discount'],
                        'sub_curr_total' => isset($post['sub_curr_total'])?$post['sub_curr_total']:"",
                        'sub_total'  => $post['sub_total'],
                        'total_quantity' => $post['total_quantity'],
                        'currency_tax' => isset($post['currency_tax'])?$post['currency_tax']:"",
                        'total_tax' => $post['total_tax'],
                        'minimum_deposit' => isset($post['minimum_deposit'])?$post['minimum_deposit']:"0.00",
                        'currency_deposit' => isset($post['currency_deposit'])?$post['currency_deposit']:'0.00',
                        'deposit_amount' => $post['deposit_amount'],
                        'currency_total' => isset($post['conv_total_amount'])?$post['conv_total_amount']:"",
                        'total_amount' => $post['total_amount'],
                        'notes' => isset($post["notes"])?$post["notes"]:"",
                        'contract_status' => $post['deposit_amount'] != "" ? 2 : 0,
                    ];
                    if(isset($post['id']) && $post['id'] == "") {
                        $data['contract_date'] = date('Y-m-d');
                    }
                break;
                case 'layby_contract_transactions':
                    $data = [
                        'contract_id' => $post['contract_id'],
                        'transaction_type' => $post['transaction_type'] == "3" ? "4" : $post['transaction_type'],
                        'date' => date('Y-m-d'),
                        'payment_type' => isset($post['payment_type'])?$post['payment_type']:0,
                        'amount' => sprintf('%0.2f',$post['amount'])
                    ];
                break;
                case 'layby_contract_deposit':
                    $data = [
                        'contract_id' => $post['contract_id'],
                        'deposit_date' => date('Y-m-d'),
                        'type' => $post['payment_type'],
                        'deposit_amount' => sprintf('%0.2f',$post['deposit_amount'])
                    ];
                break;
                case 'layby_contract_refund':
                    $data = [
                        'contract_id' => $post['contract_id'],
                        'refund_date' => date('Y-m-d'),
                        'refund_amount' => sprintf('%0.2f',$post['deposit_amount'])
                    ];
                break;
            }

            $db = db_connect();
            $commonModel = new CommonModel($db);
            if(isset($post['id']) && empty($post['id']))
            {
                $result = $commonModel->AddData($post['table_name'],$data);
                switch($post['table_name'])
                {
                    case 'layby_contract':
                        if($post['deposit_amount'] != "") {
                            $contractDeposit = new ContractTransactionModel();
                            $depositData = array(
                                'contract_id' => $result,
                                'transaction_type' => '1',
                                'date' => date('Y-m-d'),
                                'payment_type' => isset($post['payment_type'])?$post['payment_type']:0,
                                'amount' => sprintf('%0.2f',$post['deposit_amount'])
                            );
                            $addDeposit = $commonModel->AddData('layby_contract_transactions',$depositData);
                        }
                        foreach($post['items'] as $item) {
                            $storeItemModel = new StoreItemsModel();
                            $store_data = [
                                'item_id'=>$item['item_id'],
                                'store_id'=>$store_id,
                                'pos_id'=>$sessData['pos_id'],
                                'qty'=>$item['quantity'],
                                'location_id'=>$location_id,
                                'type'=>'layby'
                            ];
                            $store_item = $storeItemModel->laybyItemStock($store_data);
                            $items = array(
                                'contract_id' => $result,
                                'item_id' => $item['item_id'],
                                'uom_id' => $item['uomid'],
                                'uom_value' => $item['uom'],
                                'qty' => $item['quantity'],
                                'rate' => $item['rate'],
                                'discount' => $item['discount'],
                                'discount_type' => $item['discount_type'],
                                'discount_amount' => $item['discount_amount'],
                                'tax_value' => $item['tax'],
                                'tax_name' => $item['tax_type'],
                                // 'currency_amt' => $item['currency'],
                                'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                                'tax_amount' => $item['tax_amount'],
                                'total_amount' => $item['amount'] ,
                                'item_amount' => $item['amount'],
                            );

                            $addItem = $commonModel->AddData('layby_contract_items',$items);       
                        }
                    break;
                    case 'layby_contract_transactions':
                        $contract = new ContractModel();
                        $contractData = $contract->select('layby_contract.*')->where('id',$post['contract_id'])->first();

                        $contractDeposit = new ContractTransactionModel();
                        $data = $contractDeposit->GetDepositData($post['contract_id']);

                        if($post['transaction_type'] == "1") {
                            $remaining = $contractData['total_amount'];
                            $checkDepositAmt = $contractDeposit->checkContractDepositAmt($post['contract_id']);
                            $checkRefundAmt = $contractDeposit->checkContractRefundAmt($post['contract_id']);
                            if(!empty($data)) {
                                $remaining = sprintf('%0.2f',(float)$contractData['total_amount'] - ((float)$checkDepositAmt['amount'] + $checkRefundAmt['amount']));
                            }
                            
                            $status = 0;
                            if($remaining > 0) {
                              $status = 2;
                            } elseif($remaining == '0' || $remaining == '0.00') {
                              $status = 1;
                            }
                            $data = [
                                'contract_status' => $status
                            ];
                            $commonModel->UpdateData('layby_contract',$post['contract_id'],$data);
                        } elseif($post['transaction_type'] == "3") {
                            $data = [
                                'contract_status' => 4,
                                'is_cancel' => 1
                            ];
                            $commonModel->UpdateData('layby_contract',$post['contract_id'],$data);
                        } elseif($post['transaction_type'] == "2") {
                            $data = [
                                'contract_status' => 4
                            ];
                            $commonModel->UpdateData('layby_contract',$post['contract_id'],$data);
                        } elseif($post['transaction_type'] == "4") {
                            $data = [
                                'contract_status' => 5
                            ];
                            $commonModel->UpdateData('layby_contract',$post['contract_id'],$data);
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
                    case 'layby_contract':
                    /*if($post['deposit_amount'] != "") {
                        $contractDeposit = new ContractDepositModel();
                        $depositData = array(
                            'contract_id' => $post['id'],
                            'deposit_date' => date('Y-m-d'),
                            'deposit_amount' => $post['deposit_amount']
                        );
                        $addDeposit = $commonModel->AddData('layby_contract_deposit',$depositData);
                    }*/

                    foreach($post['items'] as $item) {
                        $storeItemModel = new StoreItemsModel();
                        $store_data = [
                            'item_id'=>$item['item_id'],
                            'store_id'=>$store_id,
                            'qty'=>$item['quantity'],
                            'location_id'=>$location_id,
                            'type'=>'sold'
                        ];
                        $store_item = $storeItemModel->laybyItemStock($store_data);

                        $items = array(
                            'contract_id' => $post['id'],
                            'item_id' => $item['item_id'],
                            'uom_id' => $item['uomid'],
                            'uom_value' => $item['uom'],
                            'qty' => $item['quantity'],
                            'rate' => $item['rate'],
                            'discount' => $item['discount'],
                            'discount_type' => $item['discount_type'],
                            'discount_amount' => $item['discount_amount'],
                            'tax_value' => $item['tax'],
                            'tax_name' => $item['tax_type'],
                            'tax_amount' => $item['tax_amount'],
                            // 'currency_amt' => $item['currency'],
                            'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                            'total_amount' => $item['amount'],
                            'item_amount' => $item['amount'],
                        );
                        
                        if(isset($item['id'])) {
                            $updateOrderItem = $commonModel->UpdateData('layby_contract_items',$item['id'],$items);
                        } else {
                            $addOrderItem = $commonModel->AddData('layby_contract_items',$items);
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
}
