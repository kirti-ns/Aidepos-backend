<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomersModel;
use App\Models\GiftCardMasterModel;
use App\Models\GiftCardModel;
use App\Models\InvoiceModel;
use App\Models\CommonModel;
use App\Models\SellordersModel;
use App\Models\SalesPaymentModel;

class CustomersController extends BaseController
{
    public function index()
    {
        $data = [];
        $data['title'] = 'Customers'; 
        $sessData = getSessionData();

        $giftcard = New GiftCardMasterModel();
        $data['giftcards'] = $giftcard->where('pos_id',$sessData['pos_id'])->findAll();

        return $this->template->render('pages/customers/list_customers', $data); 
    }

    public function Add_Customer()
    {
        $data = [];
        $data['title'] = 'Add Customer'; 
        $data['main_menu'] = 'Customers'; 
        $data['main_menu_url'] = base_url('customers'); 
        return $this->template->render('pages/customers/add_customers', $data); 
    }

    public function Edit_customer($id)
    { 
        $data = [];
        $data['title'] = 'Edit Customer'; 
        $data['main_menu'] = 'Customers'; 
        $data['main_menu_url'] = base_url('customers'); 

        $customerModel = new CustomersModel();
        $data['customer'] = $customerModel->where("id",$id)->first();
        return $this->template->render('pages/customers/add_customers', $data); 
    }

    public function View_customer($id)
    { 
        $data = [];
        $data['title'] = 'View Customer'; 
        $data['main_menu'] = 'Customers'; 
        $data['main_menu_url'] = base_url('customers'); 

        $customerModel = new CustomersModel();
        $data['customer'] = $customerModel->where("id",$id)->first();
        
        $sellOrder = new SellordersModel();
        $data['invoice_data'] = $sellOrder->where("customer_id",$id)->first();

        $data['customer_id'] = $id;

        return $this->template->render('pages/customers/view_customers', $data); 
    }
    public function importCustomers()
    {
      $sessData = getSessionData();

      $file = $this->request->getFile('file');
      $path = FCPATH . 'public/uploads/csvfile/';

      $input = $this->validate([
            'file' => 'uploaded[file]|ext_in[file,csv],'
        ]);
        if (!$input) {
            $err = $this->validator;

            return json_encode([
              'status'=>'false',
              'msg'=>\Config\Services::validation()->getErrors()
            ]);
        }else{
            if($file = $this->request->getFile('file')) {
              if ($file->isValid() && ! $file->hasMoved()) {
                  $newName = $file->getRandomName();

                  $file->move($path,$newName);
                  
                  $file = fopen($path.$newName,"r");
                  $i = 0;
                  $numberOfFields = 10;
                  $csvArr = array();
                  
                  while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                      $num = count($filedata);
                      if($i > 0 && $num == $numberOfFields){
                          $csvArr[$i]['pos_id'] = $sessData['pos_id'];
                          $csvArr[$i]['account_id'] = $filedata[0];
                          $csvArr[$i]['tpin_no'] = $filedata[1];
                          $csvArr[$i]['lpo_no'] = $filedata[2];
                          $csvArr[$i]['id_no'] = $filedata[3];
                          $csvArr[$i]['registerd_name'] = $filedata[4];
                          $csvArr[$i]['tax_account_name'] = $filedata[5];
                          $csvArr[$i]['address'] = $filedata[6];
                          $csvArr[$i]['email'] = $filedata[7];
                          $csvArr[$i]['country_code'] = $filedata[8];
                          $csvArr[$i]['phone'] = $filedata[9];
                      }
                      $i++;
                  }
                  fclose($file);
                  $count = 0;
                  foreach($csvArr as $v){
                      $customer = new CustomersModel();
                      $findRecord = $customer->where('email', $v['email'])->countAllResults();
                      if($findRecord == 0){
                          if($customer->insert($v)){
                              $count++;
                          }
                      }
                  }

                  unlink($path.$newName);

                  return json_encode([
                    'status'=>'true',
                    'msg'=>$count.' rows successfully added.'
                  ]);
              }
              else{
                  return json_encode([
                    'status'=>'false',
                    'msg'=>'CSV file coud not be imported.'
                  ]);
              }
            }else{
                return json_encode([
                  'status'=>'false',
                  'msg'=>'CSV file coud not be imported.'
                ]);
            }
        }
    }

    public function Add_GiftCard_Master()
    {
        $data = [];
        $data['title'] = 'Add Gift Card'; 
        $data['main_menu'] = 'Customers'; 
        $data['main_menu_url'] = base_url('customers'); 
        
        return $this->template->render('pages/customers/add_gift_card', $data); 
    }

    public function Add_GiftCard()
    {
        $data = [];
        $data['title'] = 'Add Gift Card'; 
        $data['main_menu'] = 'Customers'; 
        $data['main_menu_url'] = base_url('customers');
        $sessData = getSessionData();

        $giftcard = New GiftCardMasterModel();
        $giftcardData = $giftcard->where('pos_id',$sessData['pos_id'])->findAll();
        $data['giftcardData']  = $giftcardData;
        $data['url'] = uri_string();

        return $this->template->render('pages/customers/add_gift_card', $data); 
    }

    public function Edit_gift_card($id)
    { 
        $data = [];
        $data['title'] = 'Edit Gift Card'; 
        $data['main_menu'] = 'Customers'; 
        $data['main_menu_url'] = base_url('customers');
        $sessData = getSessionData();
         
        $giftcard = New GiftCardMasterModel();
        $giftcardData = $giftcard->where('pos_id',$sessData['pos_id'])->findAll();
        $data['giftcardData']  = $giftcardData;

        $giftcardModel = new GiftCardModel();
        $data['giftcard'] = $giftcardModel->GetGiftCardDataById($id);
   
        return $this->template->render('pages/customers/add_gift_card', $data); 
    }

    public function Add_LoyaltyPoints()
    {
        $data = [];
        $data['title'] = 'Add Loyalty Points'; 
        $data['main_menu'] = 'Customers'; 
        $data['main_menu_url'] = base_url('customers');
        return $this->template->render('pages/customers/add_gift_card', $data); 
    }

    public function Post_Customers_Data()
    {
        if ($this->request->getMethod() == "post") 
        {
          $sessData = getSessionData();
            $post = $this->request->getVar();

            switch($post['table_name']){
                case 'customers':
                    $data = [
                      'pos_id' => $sessData['pos_id'],
                      'account_id' => isset($post["account_id"])?$post["account_id"]:"0",
                      'tpin_no' => isset($post["tpin_no"])?$post["tpin_no"]:"0",
                      'lpo_no' => isset($post["lpo_no"])?$post["lpo_no"]:"0",
                      'id_no' => isset($post["id_no"])?$post["id_no"]:"0",
                      'registerd_name' => isset($post["registerd_name"])?$post["registerd_name"]:"0",
                      'tax_account_name' => isset($post["tax_account_name"])?$post["tax_account_name"]:"0",
                      'address' => isset($post["address"])?$post["address"]:"0",
                      'email' => isset($post["email"])?$post["email"]:"0",
                      'country_code' => isset($post["country_code"])?$post["country_code"]:"0",
                      'phone' => isset($post["phone"])?$post["phone"]:"0",
                      'receivables' => isset($post["receivables"])?$post["receivables"]:"0",
                      'loyalty' => isset($post["loyalty"])?$post["loyalty"]:"0",
                      'status' => isset($post["status"])?$post["status"]:"0"
                    ];
                break;
                case 'giftcardmasters':
                    $data = [
                        'pos_id' => $sessData['pos_id'],
                        'batch_name' => isset($post["batch_name"])?$post["batch_name"]:"0"
                    ];
                break;
                case 'giftcards':
                   
                    $data = [
                        'batch_id' => isset($post['batch_id'])?$post['batch_id']:"",
                        'voucher_card_no' => isset($post["voucher_card_no"])?$post["voucher_card_no"]:"0",
                        'amount' => isset($post["amount"])?$post["amount"]:"0",
                        'expiry_date' => isset($post["expiry_date"])?$post["expiry_date"]:""
                    ];
                break;
                case 'loyaltypoints':
                    $data = [
                        'pos_id' => $sessData['pos_id'],
                        'loyalty_system' => isset($post["loyalty_system"])?$post["loyalty_system"]:"0",
                        'bill_amount_to_earn' => isset($post["bill_amount_to_earn"])?$post["bill_amount_to_earn"]:"0",
                        'point_in_amount' => isset($post["point_in_amount"])?$post["point_in_amount"]:"0",
                        'minimum_redeem' => isset($post["minimum_redeem"])?$post["minimum_redeem"]:"0"
                    ];
                break;
            }
        }
        $db = db_connect();
        $commonModel = new CommonModel($db);
            
            if(isset($post['id']) && empty($post['id']))
            {
                // $id = $post['id'];
                $result = $commonModel->AddData($post['table_name'],$data);
                $result_data = "";
                switch($post['table_name']){
                    case 'customers':
                    $result_data = $this->getCustomerList();
                    break;
                    case 'giftcardmasters':
                      $result_data = '<option value="'.$result.'">'.$post['batch_name'].'</option>';
                    break;
                }
                return json_encode([
                    "status" => "true",
                    "message" => "New Data added successfully",
                    "data" =>$result_data
                ]);
            }
            else
            {
                $id = $post['id'];
                $result = $commonModel->UpdateData($post['table_name'],$id,$data);
                return json_encode([
                    "status" => "true",
                    "message" => "Data updated successfully",
                ]);
            }          
    }
    public function getCustomers(){

      $request = service('request');
      $postData = $request->getPost();
      $dtpostData = $postData['data'];
      $response = array();
      $sessData = getSessionData();

      ## Read value
      $draw = $dtpostData['draw'];
      $start = $dtpostData['start'];
      $rowperpage = $dtpostData['length']; // Rows display per page
      //$searchValue = $dtpostData['search']['value']; // Search value
      $advancesearchValue = $dtpostData['advFilter']; // Search value
      $searchValue = $advancesearchValue['match']['search'];
      //$searchStatus = $advancesearchValue['match']['status'];
       
      // Total number of records without filtering
      $cm = new CustomersModel();
      $cmfilter = new CustomersModel();

      $totalRec = $cm->select('id')->where('pos_id',$sessData['pos_id'])
                ->countAllResults();

      // Total number of records with filtering
      $filterRec = $cmfilter->select('id');

       ## Fetch records
        $cm->select('*');
        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            //$cm->Like('registerd_name', $searchValue);
            $cm->like('email', $searchValue);
            $cm->orLike('account_id', $searchValue);
            $cm->orLike('registerd_name', $searchValue);
            $cmfilter->like('email', $searchValue);
            $cmfilter->orLike('account_id', $searchValue);
            $cmfilter->orLike('registerd_name', $searchValue);
        }
        if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $cm->where('status', 1);
                $cmfilter->where('status', 1);
            }else{ 
                $cm->where('status', 0);
                $cmfilter->where('status', 0);
            }
        }
        $cm->where('pos_id',$sessData['pos_id']);
        $cm->orderBy('id','DESC');
        $records = $cm->findAll($rowperpage, $start);

        $cmfilter->where('pos_id',$sessData['pos_id']);
        $totalRecordwithFilter = $cmfilter->countAllResults();

        $data = array();
       
        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRec,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $records,
          "token" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response);
    }
    public function getGiftCards(){

       $request = service('request');
       $postData = $request->getPost();
       $dtpostData = $postData['data'];
       $response = array();
       $sessData = getSessionData();

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
      $cm = new GiftCardModel();
      $cmF = new GiftCardModel();
      $totalRecords = $cm->select('id')
                ->countAllResults();

       ## Total number of records with filtering
       
       ## Fetch records
        $cm->select('giftcards.*,giftcards.id as g_id,g.batch_name');
        $cm->join('giftcardmasters as g', 'g.id = giftcards.batch_id');
        $cmF->join('giftcardmasters as g', 'g.id = giftcards.batch_id');

        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('voucher_card_no', $searchValue);
            $cmF->like('voucher_card_no', $searchValue);
        }
        if(!empty($advancesearchValue['equal']['batch_id'])){
            $searchStatus = $advancesearchValue['equal']['batch_id'];
            $cm->where('batch_id',$searchStatus);
            $cmF->where('batch_id',$searchStatus); 
        }
        if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $cm->where('g.status', 1);
                 $cmF->where('g.status', 1);
            }else{ 
                $cm->where('g.status', 0);
                $cmF->where('g.status', 0);
            }
        }
      $cm->where('g.pos_id',$sessData['pos_id']);
      $cmF->where('g.pos_id',$sessData['pos_id']);
      $cm->orderBy($columnName,$columnSortOrder);

      $records = $cm->findAll($rowperpage, $start);
        
      $totalRecordwithFilter = $cmF->countAllResults();
       
       $data = array();
       
       /*foreach($records as $record ){ 
    
          $data[] = array( 
             "voucher_card_no"=>$record['voucher_card_no'],
             "batch_id"=>$record['batch_name'],
             "amount"=>$record['amount'],
             "balance"=>$record['amount'],
             "expiry_date"=>$record['expiry_date'],
             "action"=>$action,
          ); 
       }*/
       
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
   
    public function getViewCustomers(){

       $request = service('request');
       $postData = $request->getPost();
       $id = isset($postData['user_id'])?$postData['user_id']:"";

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
       $cm = new SellordersModel();
       $totalRecords = $cm->select('id','customer_id')->where("customer_id",$id)
                ->countAllResults();

       ## Total number of records with filtering
              
       ## Fetch records
        $cm->select('sell_orders.*,c.registerd_name');
        $cm->join('customers as c', 'c.id = sell_orders.customer_id');
        $cm->where("sell_orders.customer_id",$id);
        $cm->where("sell_orders.invoice_type",1);
        
        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('registerd_name', $searchValue);
        }
        if(!empty($advancesearchValue['equal']['customer_id'])){
            $searchStatus = $advancesearchValue['equal']['customer_id'];
            $cm->where('customer_id',$searchStatus);
        }
        if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $cm->where('sell_orders.status', 1);
            }else{ 
                $cm->where('sell_orders.status', 0);
            }
        }
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);
       
        $totalRecordwithFilter = count($records);
        
        $data = array();

        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "order_number"=>$record['order_number'],
               "status"=>$this->getInvoiceStatus($record['id'],$record['due_date'],$record['total_amount'],$record['balance_due'],$record['is_sent']),
               "date"=>dateFormat($record['invoice_date']),
               "due_date"=>dateFormat($record['due_date']),
               "total_amount"=>$record['total_amount'],
               "balance_due"=>$record['balance_due']
            ); 
        }
       
       ## Response
       $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data,
          "token" => csrf_hash() // New token hash
       );

       return $this->response->setJSON($response);
    }

    function getInvoiceStatus($id,$due_date,$total_amt,$due_balance,$is_sent)
    {
        $today = date('Y-m-d');

        $paymentModel = new SalesPaymentModel(); 
        $payments = $paymentModel->select('SUM(amount_received) as total_sum')->where('invoice_id',$id)->first();

        $status = "Draft";
        if($is_sent == "0") {
            $status = "<span class='text-bold-500 grey'>Draft</span>";
        }
        else if($due_balance > 0 && $today < $due_date) {
            $status = "<span class='text-bold-500 success'>Partially Paid</span>";
        }
        else if($due_balance > 0 && $today > $due_date) {
            $status = "<span class='text-bold-500 deep-orange'>Overdue</span>";
        }
        else{
            $status = "<span class='text-bold-500 success'>Paid</span>";
        }
        return $status;

    }

    public function getCustomerById()
    {
        $sessData = getSessionData();
        $id = $this->request->getVar('customer_id');
      
        $customer = new CustomersModel();
        $data = $customer->where('id',$id)->first();

        if(!empty($data)){
            return json_encode(['status'=>"true",'message'=>'Fetch Data','data'=>$data]); 
        }else{
            return json_encode(['status'=>"false",'message'=>'No Data Found','data'=>$data]); 
        }     
    }
   
    public function getCustomerList()
    {
        $cm = new CustomersModel();
        $data = $cm->where('status',1)->orderBy('id','desc')->findAll();
        $html = "";
        $html .=  '<option value="">Please select</option>';
            
        if(!empty($data)){
           foreach($data as $row){ 
                $html .='<option value="'.$row["id"].'">'.$row["registerd_name"].'</option>';
            }
            $html .='<option value="others">Add Customer</option>';
            return $html; 
        }else{
            return $html; 
        }
    }
}
