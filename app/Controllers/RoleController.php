<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Models\RoleModel;

class RoleController extends BaseController
{    
    public function Add_role()
    {
        $data = [];
        $data['title'] = 'Add Role'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings'); 
        return $this->template->render('pages/settings/roles_add', $data); 
    }

    public function Edit_role($id)
    {
        $data = [];
        $data['title'] = 'Edit Role'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings'); 

         $roleModel = new RoleModel();
        $data['roles'] = $roleModel->where("id",$id)->first();
        return $this->template->render('pages/settings/roles_add', $data); 
    }

    public function Post_role()
    {
         if ($this->request->getMethod() == "post") {
                $roleModel = new RoleModel();
                $post = $this->request->getVar();
                $data = [
                    'role_name' => $post["role_name"],
                    'pos' => isset($post["pos"])?$post["pos"]:"0",
                    'pos_permission' => isset($post["pos_permission"])?json_encode($post["pos_permission"]):"0",
                    'back_office' => isset($post["back_office"])?$post["back_office"]:0,
                    'back_office_permission' => isset($post["back_office_permission"])?json_encode($post["back_office_permission"]):"0",
                    'waiter' => isset($post["waiter"])?$post["waiter"]:0,
                    'waiter_permission' => isset($post["waiter_permission"])?json_encode($post["waiter_permission"]):"0",
                    'status' => isset($post["status"])?$post["status"]:0
                ];
            }
            if(isset($post['id']) && empty($post['id']))
                {
                    $roleModel = new RoleModel();
                    $roleModel->save($data);
                    return json_encode([
                    "status" => "true",
                    "message" => "New Data Created successfully",
                ]);
                }
                else{
                    $id = $post['id'];
                    $roleModel = new RoleModel();
                    $roleModel->update($id,$data);
                    return json_encode([
                    "status" => "true",
                    "message" => "Data updated successfully",
                ]);
                } 
    }
    
    public function getRole()
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
       $cm = new RoleModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

       ## Total number of records with filtering
       
       
       ## Fetch records
       
        $cm->select('role.id as r_id,role.*');
        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('role_name', $searchValue);
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

        foreach($records as $k=>$row){
             $records[$k]['back_office'] = CheckStatus($row['back_office']);
             $records[$k]['pos'] = CheckStatus($row['pos']);
             $records[$k]['waiter'] = CheckStatus($row['waiter']);
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
