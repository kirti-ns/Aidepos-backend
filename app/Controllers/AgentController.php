<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Models\EmployeeModel;
use App\Models\StoreModel;
use App\Models\MerchantContractModel;
use DateTime;

class AgentController extends BaseController
{
    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }
    public function index()
    {
        $data = [];
        $data['title'] = 'Dashboard'; 
        $data['main_menu'] = ''; 
        $data['main_menu_url'] = '';

        $dayHrs = date('H');
        $data['greeting'] = "";

        if ($dayHrs >=  4) {
            $data['greeting'] = "Good Morning"; 
        }
        if ($dayHrs >= 12) {
            $data['greeting'] = "Good Afternoon";
        }
        if ($dayHrs >= 17) {
            $data['greeting'] = "Good Evening";
        }
        if ($dayHrs >= 22) {
            $data['greeting'] = "Good Night";  
        }

        $employees = new EmployeeModel();
        $data['merchants'] = $employees->where('created_by',2)->where('created_by_id',session()->get('id'))->findAll();
        
        return $this->agent_template->render('pages/agent/index',$data);
    }
    
    public function List_Merchant()
    {
        $data = [];
        $data['title'] = 'Merchants'; 
        $data['main_menu'] = 'Merchants'; 
        $data['main_menu_url'] = base_url('agent/merchants');

        return $this->agent_template->render('pages/agent/merchants/list',$data);
    }

    public function getMerchants()
    {
       $request = service('request');
       $postData = $request->getPost();
       
       $dtpostData = $postData['data'];
       $response = array();
       ## Read value
       $draw = $dtpostData['draw'];
       $start = $dtpostData['start'];
       $rowperpage = $dtpostData['length']; // Rows display per page
       $advancesearchValue = $postData['filter']; // Search value
       $searchValue = $advancesearchValue['match']['search'];

       $agent_id = session()->get('id');

        $cm = new EmployeeModel();
        $cmfilter = new EmployeeModel();
       
        $totalRecords = $cm->select('id')
                ->countAllResults();

        $cm->select('employees.*');

        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->orLike('first_name', $searchValue)
            ->orLike('last_name', $searchValue)
            ->orLike('primary_email', $searchValue);

            $cmfilter->orLike('first_name', $searchValue)
            ->orLike('last_name', $searchValue)
            ->orLike('primary_email', $searchValue);
        }
         if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            $cm->where('employees.status', $searchStatus);
            $cmfilter->where('employees.status', $searchStatus);
        }
        $cm->where('is_super_user',1);
        $cmfilter->where('is_super_user',1);
        $cm->where('created_by',2)->where('created_by_id',$agent_id);
        $cmfilter->where('created_by',2)->where('created_by_id',$agent_id);
        $cm->orderBy('id','DESC');

        $records = $cm->findAll($rowperpage, $start);
        $totalRecordwithFilter = $cmfilter->countAllResults();
      
        $data = array();    
        $store = new StoreModel();
        foreach($records as $k=>$row){
            $records[$k]['stores'] = $store->where('pos_id',$row['pos_id'])->countAllResults();
            $records[$k]['created_at'] = date('Y-m-d',strtotime($row['created_at']));
        }
        
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

    public function Add_Merchant()
    {
        $data = [];
        $data['title'] = 'Add Merchant'; 
        $data['main_menu'] = 'Merchants'; 
        $data['main_menu_url'] = base_url('agent/merchants');

        $contract = new MerchantContractModel();
        $contractData = $contract->findAll();
        $data['contract'] = [];

        foreach ($contractData as $key => $value) {
            $list['id'] = $value['id'];
            $term  = "Month";
            if($value['license_period_term'] == "2") {
                $term = "Year";
            }

            $pay = "Monthly";
            if($value['payment_structure'] == "1"){
                $pay = "Quarterly";
            } else if($value['payment_structure'] == "2") {
                $pay = "Yearly";
            }
            $list['license'] = $value['license_period'].' '.$term.' - '.$pay.' Pay';
            $data['contract'][] = $list;
        }

        return $this->agent_template->render('pages/agent/merchants/merchant_add', $data);
    }

    public function Edit_merchant($id)
    { 
        $data = [];
        $data['title'] = 'Edit Merchant'; 
        $data['main_menu'] = 'Merchant';
        $data['main_menu_url'] = base_url('agent/merchants');

        $employeeModel = new EmployeeModel();
        $data['profile'] = $employeeModel->where("id",$id)->first();

        $contract = new MerchantContractModel();
        $contractData = $contract->findAll();
        $data['contract'] = [];
        
        foreach ($contractData as $key => $value) {
            $list['id'] = $value['id'];
            $term  = "Month";
            if($value['license_period_term'] == "2") {
                $term = "Year";
            }

            $pay = "Monthly";
            if($value['payment_structure'] == "1"){
                $pay = "Quarterly";
            } else if($value['payment_structure'] == "2") {
                $pay = "Yearly";
            }
            $list['license'] = $value['license_period'].' '.$term.' - '.$pay.' Pay';
            $data['contract'][] = $list;
        }

        return $this->agent_template->render('pages/agent/merchants/merchant_add', $data); 
    }

    public function Post_Data()
    {
        $employeeModel = new EmployeeModel();
        $post = $this->request->getVar();

        $session = session();
        $agent_id = $session->get('id');
           
        if(!empty($post['profile_image_name'])){
            if($imageFile = $post['profile_image_name']){
                $base64 = $post['profile_image_name']; 
                $img = explode(";base64,", $base64);
                $imagetype = explode("image/", $img[0]);
                $imagetype = $imagetype[1];
                $imagebase64 = base64_decode($img[1]);
                $imagename = time().'.'.'png';  
                $file = FCPATH."public/uploads/employees/" . $imagename;
                file_put_contents($file, $imagebase64);
            }
        }else{
            $imagename = $post['profile_image_old'];
        }
            
        $data = [
            'first_name' => $post["first_name"],
            'last_name' => $post["last_name"],
            'profile' => $imagename,
            'primary_email' => $post["primary_email"],
            'country_code' =>isset($post["country_code"])?$post["country_code"]:"0",
            'phone' => $post["phone"],
            'secondary_email' => $post["secondary_email"],
            'address' => $post["address"],
            'zip' => $post["zip"],
            'city' => $post["city"],
            'state' => isset($post["state"])?$post["state"]:0,
            'country' => isset($post["country"])?$post["country"]:0,
            'gender' => isset($post["gender"])?$post["gender"]:0,
            'expiry_date' => isset($post["expiry_date"])?$post["expiry_date"]:0,
            'store_id' => "",
            'terminal_id' => "",
            'role_id'=>1,
            'status' => isset($post["status"])?$post["status"]:0,
            'contract' => isset($post["contract"])?$post["contract"]:"",
            'is_super_user'=>1,
            'created_by'=>2
        ];
                
        if(isset($post['id']) && empty($post['id']))
        {
            $password = password_hash($post["employee_password"],PASSWORD_DEFAULT);
            $data['password'] = $password;

            $data['created_by_id'] = $agent_id;

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $length = 10;
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[rand(0, $charactersLength - 1)];
            }  

            $pData = [
                'code'=>$code
            ];

            $db = db_connect();
            $commonModel = new CommonModel($db);
            $pResult = $commonModel->AddData('pos',$pData);

            $data['pos_id'] = $pResult;

            $fData = [
                'pos_id'=>$pResult,
                'barcode_generation'=>1
            ];
            $commonModel->AddData('features',$fData);
            $commonModel->AddData('employees',$data);

            return json_encode([
                "status" => "true",
                "message" => "New Data Created successfully",
            ]);
        }
        else{
            
            if($post['employee_password'] != "") {
                $password = password_hash($post["employee_password"],PASSWORD_DEFAULT);
                $data['password'] = $password;
            }

            $id = $post['id'];
            $employeeModel = new EmployeeModel();
            $employeeModel->UpdateData($post['table_name'],$id,$data);
            return json_encode([
                "status" => "true",
                "message" => "Data updated successfully",
            ]);
        }
    }

    public function List_Terms()
    {
        $data = [];
        $data['title'] = 'Term'; 
        $data['main_menu'] = 'Renewals'; 
        $data['main_menu_url'] = base_url('agent/renewals/term');

        return $this->agent_template->render('pages/agent/renewals/list', $data);
    }

    public function getTerms()
    {
       $request = service('request');
       $postData = $request->getPost();
       
       $dtpostData = $postData['data'];
       $response = array();
       ## Read value
       $draw = $dtpostData['draw'];
       $start = $dtpostData['start'];
       $rowperpage = $dtpostData['length']; // Rows display per page
       $advancesearchValue = $postData['filter']; // Search value
       $searchValue = $advancesearchValue['match']['search'];

       $agent_id = session()->get('id');

        $cm = new EmployeeModel();
        $cmfilter = new EmployeeModel();
       
        $totalRecords = $cm->select('id')
                ->countAllResults();

        $cm->select('employees.*');

        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->orLike('first_name', $searchValue)
            ->orLike('last_name', $searchValue)
            ->orLike('primary_email', $searchValue);

            $cmfilter->orLike('first_name', $searchValue)
            ->orLike('last_name', $searchValue)
            ->orLike('primary_email', $searchValue);
        }
         if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            $cm->where('employees.status', $searchStatus);
            $cmfilter->where('employees.status', $searchStatus);
        }
        $cm->where('created_by',2)->where('created_by_id',$agent_id);
        $cmfilter->where('created_by',2)->where('created_by_id',$agent_id);
        $cm->where('is_super_user',1);
        $cmfilter->where('is_super_user',1);

        $records = $cm->findAll($rowperpage, $start);
        $totalRecordwithFilter = $cmfilter->countAllResults();
      
        $data = array();    
        $store = new StoreModel();
        $contract = new MerchantContractModel();
        foreach($records as $k=>$row){
            $records[$k]['license'] = "-";
            $records[$k]['next_renw'] = "-";
            if($row['contract'] != "") {
                $contractDt = $contract->where('id',$row['contract'])->first();
                $term = $contractDt['license_period_term'] == "1" ? "Month" : "Year";
                $records[$k]['license'] = $contractDt['license_period'].' '.$term;

                if($row['contract_date'] != "") {
                    $givenDate = $row['contract_date']; 
                    $startDate = new DateTime($givenDate);

                    if($contractDt['license_period_term'] == "1") {
                        $records[$k]['next_renw'] = $startDate->modify('+'.$contractDt['license_period'].' months')->format('Y-m-d');
                    } else {
                        $records[$k]['next_renw'] = $startDate->modify('+'.$contractDt['license_period'].' years')->format('Y-m-d');
                    }
                }
            }
            $records[$k]['created_at'] = date('Y-m-d',strtotime($row['created_at']));
        }
        
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

    public function Edit_NumofStore()
    {
        $request = service('request');
        $post = $request->getPost();

        $id = $post['id'];

        $data = array('num_of_store'=>$post['num_of_store']);

        $db = db_connect();
        $commonModel = new CommonModel($db);

        $result = $commonModel->UpdateData('employees',$id,$data);

        return json_encode([
            "status" => "true",
            "message" => "Data Updated Successfully",
        ]);
    }

    public function Edit_StoreandStaff()
    {
        $request = service('request');
        $post = $request->getPost();
        
        $pos_id = $post['id'];
        $store = new StoreModel();
        $storeData = $store->where('pos_id',$pos_id)->findAll();

        if(!empty($storeData)) {
            return json_encode([
                    "status" => "true",
                    "message" => "Data updated successfully",
                    "data" => $storeData
                ]);
        } else {
            return json_encode([
                "status" => "false",
                "message" => "No Stores found",
            ]);    
        }
        
    }

    public function Post_StoreandStaff()
    {
        $request = service('request');
        $post = $request->getPost();

        $db = db_connect();
        $commonModel = new CommonModel($db);

        foreach($post['store'] as $val) {
            $data = array('no_of_staff'=>$val['no_of_staff']);
            $result = $commonModel->UpdateData('stores',$val['store_id'],$data);
        }

        return json_encode([
            "status" => "true",
            "message" => "Data Updated Successfully",
        ]);
    }
}