<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Models\StoreModel;

class StoreController extends BaseController
{
    public function Add_store()
    {
        $data = [];
        $data['title'] = 'Add Store';
        $data['main_menu'] = 'Settings';
        $data['main_menu_url'] = base_url('settings');  

        return $this->template->render('pages/settings/stores_add', $data);
    }

    public function Edit_store($id)
    { 
        $data = [];
        $data['title'] = 'Edit Store'; 
        $data['main_menu'] = 'Settings'; 
        $data['main_menu_url'] = base_url('settings'); 

        $storeModel = new StoreModel();
        $data['stores'] = $storeModel->where("id",$id)->first();
        return $this->template->render('pages/settings/stores_add', $data); 
    }

    public function PostStoreData()
    {  
        if ($this->request->getMethod() == "post") {
            $post = $this->request->getVar();
            $sessData = getSessionData();

            $data = [
                    'pos_id' => $sessData['pos_id'],
                    'store_name' => $post["store_name"],
                    'country_code' => isset($post["country_code"])?$post["country_code"]:"",
                    'phone' => isset($post["phone"])?$post["phone"]:"",
                    'tax_no' => isset($post["tax_no"])?$post["tax_no"]:"",
                    'address' => isset($post["address"])?$post["address"]:"",
                    'zip' => isset($post["zip"])?$post["zip"]:"",
                    'city' => isset($post["city"])?$post["city"]:"",
                    'features' => isset($post["features"])?json_encode($post["features"]):"",
                    'status' => isset($post["status"])?$post["status"]:""
                ];
            }
            
            if(isset($post['id']) && empty($post['id']))
                {
                    $storeModel = new StoreModel();
                    $storeModel->save($data);
                    return json_encode([
                    "status" => "true",
                    "message" => "New Data Created successfully",
                ]);
                }
                else{
                    $id = $post['id'];
                    $storeModel = new StoreModel();
                    $storeModel->update($id,$data);
                    return json_encode([
                    "status" => "true",
                    "message" => "Data updated successfully",
                ]);
                }  
        
    }
}
