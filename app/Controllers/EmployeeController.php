<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\StoreModel;
use App\Models\CommonModel;
use App\Models\EmployeeModel;
use App\Models\TerminalsModel;

class EmployeeController extends BaseController
{
    
    public function Add_employee()
    {
        $data = [];
        $data['title'] = 'Add Employee'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings');

        $sessData = getSessionData();

        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->where('status', 1)->whereNotIn('role_name',['Manager','Owner'])->findAll();

        $storeModel = new StoreModel();
        if($sessData['role_name'] == "Owner") {
            $storeModel->where('pos_id',$sessData['pos_id']);
        }
        $data['stores'] = $storeModel->where('status', 1)->findAll();
        
        /*$terminalModel = new TerminalsModel();
        $data['terminals'] = $terminalModel->GetTerminalData();*/
        return $this->template->render('pages/settings/employees_add', $data); //
    }

    public function Edit_employee($id)
    { 
        $data = [];
        $data['title'] = 'Edit Employee'; 
        $data['main_menu'] = 'Settings';
        $data['main_menu_url'] = base_url('settings');

        $sessData = getSessionData();

        $employeeModel = new EmployeeModel();
        $data['employees'] = $employeeModel->where("id",$id)->first();

        $storeModel = new StoreModel();
        $terminalModel = new TerminalsModel();

        if($sessData['role_name'] == "Owner") {
            $storeModel->where('pos_id',$sessData['pos_id']);
            // $terminalModel->select('terminals.*')->where('stores.pos_id',$sessData['pos_id']);
        }

        $data['stores'] = $storeModel->where('status', 1)->findAll();
        $data['terminals'] = $terminalModel->where('terminals.status', 1)->findAll();

        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->where('status', 1)->findAll();
        return $this->template->render('pages/settings/employees_add', $data); 
    }

    public function Profile()
    {
        $data = [];
        $data['title'] = 'Profile'; 
        $session = session();
        $employeeModel = new EmployeeModel();
        $data['employees'] = $employeeModel->GetEmployeeData($session->get('id'));
        return $this->template->render('pages/profile/profile', $data); 
    }

    public function Edit_Profile($id)
    { 
        $data = [];
        $data['title'] = 'Edit Profile'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings'); 

        $employeeModel = new EmployeeModel();
        $data['employees'] = $employeeModel->where("id",$id)->first();

         $roleModel = new RoleModel();
        $data['roles'] = $roleModel->where('status', 1)->findAll();
       
        $storeModel = new StoreModel();
        $data['stores'] = $storeModel->where('status', 1)->findAll();
        
        $terminalModel = new TerminalsModel();
        $data['terminals'] = $terminalModel->GetTerminalData();
        return $this->template->render('pages/profile/profile_edit', $data); 
    }

    public function PostProfileData()
    {
        if($this->request->getMethod() == "post")
        { 
                 $db = db_connect();
                $commonModel = new CommonModel($db);
                $post = $this->request->getVar();
                if(!empty($post['profile_image_name'])){
                     if($imageFile = $post['profile_image_name']){
                    $base64 = $post['profile_image_name']; 
                        $img = explode(";base64,", $base64);
                        $imagetype = explode("image/", $img[0]);
                        $imagetype = $imagetype[1];
                        $imagebase64 = base64_decode($img[1]);
                        $imagename = time().'.'.'png';  
                        $file = FCPATH."/public/uploads/employees/" . $imagename;
                        file_put_contents($file, $imagebase64);
                    }
                }else{
                    $imagename = $post['profile_image_old'];
                }
               
                $data = [
                   'first_name' => $post["first_name"],
                    'last_name' => $post["last_name"],
                    'profile' => $imagename ,
                    'role_id' => isset($post["role_id"])?$post["role_id"]:0,
                    'primary_email' => $post["primary_email"],
                    'country_code' =>isset($post["country_code"])?$post["country_code"]:"0",
                    'phone' => $post["phone"],
                    'secondary_email' => $post["secondary_email"],
                    'address' => $post["address"],
                    'zip' => $post["zip"],
                    'city' => $post["city"],
                    // 'store_id' =>isset($post["store_id"])?json_encode($post["store_id"]):"0",
                    // 'terminal_id' => isset($post["terminal_id"])?json_encode($post["terminal_id"]):"0",
                    'gender' => isset($post["gender"])?$post["gender"]:0,
                ];
            }
            $db = db_connect();
            $id = $post['id'];
                    
            $result = $commonModel->UpdateData($post['table_name'],$id,$data);
            $session = session();
            if($post['id'] == $session->get('id')){
                $session->set('profile', $imagename);
            }
            return json_encode([
                "status" => "true",
                "message" => "Profile Data updated successfully",
            ]);
    }
    public function PostEmployeeData()
    {
       /* if($this->request->getMethod() == "post")
        { 
          */

            $employeeModel = new EmployeeModel();
            $post = $this->request->getVar();
               
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
                'role_id' => $post["role_id"],
                'primary_email' => $post["primary_email"],
                'country_code' =>isset($post["country_code"])?$post["country_code"]:"0",
                'phone' => $post["phone"],
                'secondary_email' => $post["secondary_email"],
                'address' => $post["address"],
                'zip' => $post["zip"],
                'city' => $post["city"],
                // 'password' => password_hash($post["employee_password"],PASSWORD_DEFAULT),
                'store_id' =>isset($post["store_id"])?json_encode($post["store_id"]):"0",
                'terminal_id' => isset($post['terminal_id'])?json_encode($post["terminal_id"]):"",
                'state' => isset($post["state"])?$post["state"]:0,
                'country' => isset($post["country"])?$post["country"]:0,
                'gender' => isset($post["gender"])?$post["gender"]:0,
                'status' => isset($post["status"])?$post["status"]:0
            ];
                
            // echo "<pre>";print_r($data);die;
                if(isset($post['id']) && empty($post['id']))
                {

                    $password = password_hash($post["employee_password"],PASSWORD_DEFAULT);
                    $data['password'] = $password;

                    $employeeModel = new EmployeeModel();
                    $employeeModel->save($data);
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
    
    public function getEmployee()
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
       $cm = new EmployeeModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

       ## Total number of records with filtering
       ## Fetch records
        $cm->select('employees.*,employees.id as e_id,r.role_name');
        $cm->join('role as r', 'r.id = employees.role_id','left');

        if($sessData['role_name'] == "Owner") {
            $own = new EmployeeModel();
            $getEmpCode = $own->select('employee_code')->where('employees.id',$sessData['id'])->first();
            $cm->where('employee_code',$getEmpCode['employee_code']);
        }

        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('first_name', $searchValue);
        }
        if(!empty($advancesearchValue['equal']['role_id'])){
            $searchValue = $advancesearchValue['equal']['role_id']; 
            $cm->like('role_id', $searchValue);
        }
         if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $cm->where('employees.status', 1);
            }else{ 
                $cm->where('employees.status', 0);
            }
        }
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);
        $totalRecordwithFilter = count($records);
      
        $data = array();
        foreach($records as $k=>$row){
            $records[$k]['profile'] = '<img  src="'.GetImagePath($row['profile'],'employees').'" style="width:50px;height:50px;border-radius:50%;">';
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
}
    