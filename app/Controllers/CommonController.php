<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\CurrencyModel;
use App\Models\TaxesModel;
use App\Models\EmployeeModel;
use App\Models\StoreModel;
use App\Models\PaymentModel;
use App\Models\CustomersModel;
use App\Models\DepartmentModel;
use App\Models\GiftCardModel;
use App\Models\SupplierModel;
use App\Models\RecipeModel;
use App\Models\UomModel;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use App\Models\BrandMasterModel;
use App\Models\ItemModel;
use App\Models\ModifiersModel;
use App\Models\AdjustmentItemModel;
use App\Models\PurchaseModel;
use App\Models\GoodsReceivedModel;
use App\Models\GoodsReturnedModel;
use App\Models\BackOrderModel;
use App\Models\TerminalsModel;
use App\Models\TransferModel;
use App\Models\CommonModel;
use App\Models\PurchaseOrderModel;
use App\Models\SellordersModel;
use App\Models\StoreItemsModel;
use App\Models\VariantsModel;
use App\Models\VariantMatserModel;
use App\Models\Location;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\CurrentInventory;
use Session;

class CommonController extends BaseController
{
    public function change_password()
    {
       $session = session();
        $id = $session->get('id');
        $post = $this->request->getVar();
        $employeeModel = new EmployeeModel();
        $checkPassword = $employeeModel->where('id',$id)->first();
        $old_password = $post['password'];
        $password = $checkPassword['password'];
        $new_password = $post['new_password'];
        //p([$old, $password]);
        $authenticatePassword = password_verify($old_password, $password);
        
        if(!$authenticatePassword){
        //if(! password_hash::check($old,$password,PASSWORD_DEFAULT)) {

                return json_encode([
                    "status" => "false",
                    "message" => "Old Password Not Correct",
                ]);
        } else {    
            // $id = $post['id'];     
            $data = array(
                'password' => password_hash($new_password,PASSWORD_DEFAULT)
            );
        
            $db = db_connect();
            $commonModel = new CommonModel($db);
            $result = $commonModel->UpdateData($post['table_name'],$id,$data);

            return json_encode([
                    "status" => 'true',
                    "message" => "Password Changed Successfully",
                ]);
        }
    }

    public function getSubcategory()
    {
        $post = $this->request->getVar();
        $subcategoryModel = new SubcategoryModel();
        $subcat = $subcategoryModel->GetSubCategoryData($post['id']);
        $html = '<option value="">Please select</option>"';
        $html .= '<option class="font-color" value="subcategory">Add Subcategory</option>';
        if(empty($subcat)){
            echo json_encode(['status'=>"false","message"=>"Sub Category Not Found",'data'=>$html]);
        }else{
            $html = '<option value="">Please select</option>"';
            foreach($subcat as $row){
                $html .= '<option value="'.$row["id"].'">'.$row["subcategory_name"].'</option>';
            }
            $html .= '<option class="font-color" value="subcategory">Add Subcategory</option>';

            echo json_encode(['status'=>"true","message"=>"Data Fetch Successfully",'data'=>$html]);
        }
    }
    
    public function getTerminal()
    {
        $post = $this->request->getVar();
        $terminalModel = new TerminalsModel();
        $subcat = $terminalModel->GetTerminalsData($post['id']);
        if(empty($subcat)){
            echo json_encode(['status'=>"false","message"=>"Terminal Not Found",'data'=>""]);
        }else{
            $html = "";
            foreach($subcat as $row){
                $html .= '<option value="'.$row["id"].'">'.$row["terminal_name"].'</option>';
            }

            echo json_encode(['status'=>"true","message"=>"Data Fetch Successfully",'data'=>$html]);
        }
    }
    public function getLocationByStore()
    {
        $post = $this->request->getVar();

        $location = new Location();
        $locationData = $location->where('store_id',$post['id'])->where('status',1)->findAll();

        if(empty($locationData)){
            echo json_encode(['status'=>"false","message"=>"Location Not Found",'data'=>""]);
        }else{
            $html = '<option value="">Location</option>';
            foreach($locationData as $row){
                $html .= '<option value="'.$row["id"].'">'.$row["location_description"].'</option>';
            }

            echo json_encode(['status'=>"true","message"=>"Data Fetch Successfully",'data'=>$html]);
        }
    }
    public function checkPin()
    {
        $post = $this->request->getVar();

        $sessData = getSessionData();

        $sMdl = new StoreModel();
        $storeDt = $sMdl->select('pin')->where('id',$sessData['store_id'])->first();

        $pin = $storeDt['pin'];

        if($pin > 0 && $pin == $post['pin']) {
            return json_encode([
                "status" => "true"
            ]);
        } else {
            return json_encode([
                "status" => "false"
            ]);
        }

        
    }

    public function Delete_data()
    {
        $post = $this->request->getVar();
        $db = db_connect();
        $commonModel = new CommonModel($db);

        switch($post['table'])
        {
            case 'role':
                $model = new RoleModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'currencies':
                $model = new CurrencyModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'taxes':
                $model = new TaxesModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'employees':
                $model = new EmployeeModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'stores':
                $model = new StoreModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'payments':
                $model = new PaymentModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'customers':
                $model = new CustomersModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'giftcards':
                $model = new GiftCardModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'suppliers':
                $model = new SupplierModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'uom_master':
                $model = new UomModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'variant_master':
                $model = new VariantMatserModel();
                $data = $model->find($post['id']);
                if($data){
                    $variantItem = new VariantsModel();
                    $variantItem->where('variant_id', $post['id'])->delete();
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'location':
                $model = new Location();
                $data = $model->find($post['id']);
                if($data){
                    $inventoryMdl = new CurrentInventory();
                    $checkInvt = $inventoryMdl->where('location_id',$post['id'])->where('quantity >',0)->countAllResults();

                    if($checkInvt > 0) {
                        echo json_encode(['status'=>"false","message"=>"Location cannot be deleted as it contains stock."]);
                    } else {
                        $uData = array('status' => 0);
                        $commonModel->UpdateData('location',$post['id'],$uData);

                        echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                    }
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'department':
                $model = new DepartmentModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'categories':
                $model = new CategoryModel();
                $subcat_model = new SubcategoryModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    $subcat_model->where('category_id',$post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'subcategories':
                $model = new SubcategoryModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
             case 'brandmasters':
                $model = new BrandMasterModel();
                //$subcat_model = new SubcategoryModel();
                $data = $model->find($post['id']);
                if($data){
                    $data['post'] = $model->where('id', $post['id'])->delete();
                                // $subcat_model->where('category_id',$post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'items':
                $model = new ItemModel();
                $data = $model->find($post['id']);
                if($data){
                   $submodel = new StoreItemsModel();
                    $sub_data = $submodel->where('item_id',$post['id'])->findAll();
                    if($sub_data){
                    $data['sub_post'] = $submodel->where('item_id', $post['id'])->delete();
                    }
               
                $data['post'] = $model->where('id', $post['id'])->delete();
                   echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'modifiers':
                $model = new ModifiersModel();
                $data = $model->find($post['id']);
                if($data)
                {
                $data['post'] = $model->where('id', $post['id'])->delete();
                echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'invoices':
                $model = new SellordersModel();
                $data = $model->find($post['id']);
                if($data)
                {
                $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'quotes':
                $model = new Quote();
                $data = $model->find($post['id']);
                if($data){
                    $variantItem = new QuoteItem();
                    $variantItem->where('quote_id', $post['id'])->delete();
                    $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'sales_payment':
                $model = new SalesPaymentModel();
                $data = $model->find($post['id']);
                if($data)
                {
                $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'stock_adjustments_items':
                $model = new AdjustmentItemModel();
                $data = $model->find($post['id']);
                if($data)
                {
                $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'subcategories':
                $model = new SubcategoryModel();
                $data = $model->find($post['id']);
                if($data)
                {
                $data['post'] = $model->where('id', $post['id'])->delete();
                    echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
             case 'purchaseorders':
                $model = new PurchaseModel();
                $data = $model->find($post['id']);
                if($data)
                {
                    $submodel = new PurchaseOrderModel();
                $sub_data = $submodel->where('p_o_id',$post['id'])->findAll();
                if($sub_data){
                    $data['sub_post'] = $submodel->where('p_o_id', $post['id'])->delete();
                }
               
                $data['post'] = $model->where('id', $post['id'])->delete();
                   echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'goods_received':
                $model = new GoodsReceivedModel();
                $data = $model->find($post['id']);
                if($data)
                {
                $data['post'] = $model->where('id', $post['id'])->delete();
                   echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'goods_returned':
                $model = new GoodsReturnedModel();
                $data = $model->find($post['id']);
                if($data)
                {
                $data['post'] = $model->where('id', $post['id'])->delete();
                   echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'back_order':
                $model = new BackOrderModel();
                $data = $model->find($post['id']);
                if($data)
                {
                $data['post'] = $model->where('id', $post['id'])->delete();
                   echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'terminals':
                $model = new TerminalsModel();
                $data = $model->find($post['id']);
                if($data)
                {
                $data['post'] = $model->where('id', $post['id'])->delete();
                   echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'transfer':
                $model = new TransferModel();
                $data = $model->find($post['id']);
                if($data)
                {
                $data['post'] = $model->where('id', $post['id'])->delete();
                   echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
            case 'recipes_master':
                $model = new RecipeModel();
                $data = $model->find($post['id']);
                if($data)
                {
                    $submodel = new RecipeItemsModel();
                    $sub_data = $submodel->where('recipe_id',$post['id'])->findAll();
                    if($sub_data){
                        $data['sub_post'] = $submodel->where('recipe_id', $post['id'])->delete();
                    }
               
                $data['post'] = $model->where('id', $post['id'])->delete();
                   echo json_encode(['status'=>"true","message"=>"Row Deleted Successfully"]);
                }
                else{
                    echo json_encode(['status'=>"false","message"=>"Row Not Found"]);
                }
            break;
        } 
    }
    public function faq(){
        $data = [];
        $data['title'] = 'Customers'; 
        
        return $this->template->render('pages/common/faq', $data); 
    }
    public function send_mail(){
         $data = [];
        $data['title'] = 'Customers'; 
      
        return $this->template->render('pages/common/send_mail', $data); 
    }
    public function help_documents(){
         $data = [];
        $data['title'] = 'Customers'; 
       
        return $this->template->render('common/help_doxuments', $data); 
    }
    public function updateStatus(){
         $db = db_connect();
         $commonModel = new CommonModel($db);
         
         $post = $this->request->getVar();

         $data = array(
                'order_status' => $post['order_status']
            );
        
        $result = $commonModel->UpdateData($post['table_name'],$post['id'],$data);
        return json_encode([
            "status" => "true",
            "message" => "Status Changed Successfully",
        ]);
    }
    public function updateField(){
         $db = db_connect();
         $commonModel = new CommonModel($db);
         
         $post = $this->request->getVar();

         $data = array(
                $post['key'] => $post['value']
            );
        
        $result = $commonModel->UpdateData($post['table_name'],$post['id'],$data);
        return json_encode([
            "status" => "true",
            "message" => "Status Changed Successfully",
        ]);
    }
    public function updateTransferStatus(){
        $db = db_connect();
        $commonModel = new CommonModel($db);

        $post = $this->request->getVar();

        $data = array(
                'status' => $post['status']
            );

        $result = $commonModel->UpdateData('transfer',$post['id'],$data);
        return json_encode([
            "status" => "true",
            "message" => "Status Changed Successfully",
        ]);
    }
    public function getDataByTableName(){
        $db = db_connect();
        $commonModel = new CommonModel($db);

        $post = $this->request->getVar();

        $data = array(
            "id" => $post['id']
        );

        $db = \Config\Database::connect();
        $builder = $db->table($post['table_name']);
        foreach ($data as $k => $v) {
            $builder->where($k,$v,true);
        }
        $result = $builder->get()->getRow();

        $status = "true";
        $msg = "Get Data Successfully";
        if(empty($result)) {
            $status = "false";
            $msg = "No Data found";
        }
        return json_encode([
            "status" => $status,
            "message" => $msg,
            "data" => $result
        ]);
    }
}
