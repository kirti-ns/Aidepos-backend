<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Models\StoreModel;
use App\Models\UomModel;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use App\Models\BrandMasterModel;
use App\Models\ModifiersModel;
use App\Models\ModifierItemsModel;
use App\Models\TaxesModel;
use App\Models\TaxMasterModel;
use App\Models\VariantMatserModel;
use App\Models\VariantsModel;
use App\Models\VariantItemModel;
use App\Models\CompositeMasterModel;
use App\Models\CompositeItemModel;
use App\Models\DepartmentModel;
use App\Models\ItemModel;
use App\Models\ItemsPriceModel;
use App\Models\ItemMasterModel;
use App\Models\RecipeModel;
use App\Models\RecipeItemsModel;
use App\Models\EmployeeModel;
use App\Models\WeighingScaleModel;
use App\Models\LocationMaster;
use App\Models\Location;
use App\Models\CurrentInventory;

class ItemsController extends BaseController
{
    public function index()
    {
        $data = [];
        $data['title'] = 'Items'; 
        $uomModel = new UomModel();
        $data['uom'] = $uomModel->findAll();

        $sessData = getSessionData();

        $categoryModel = new CategoryModel();
        $subcategoryModel = new SubcategoryModel();
        $itemModel = new ItemModel();
        
        $data['category'] = $categoryModel->GetCategoryData();
        $db = db_connect();

        $store = new StoreModel();
        $data['stores'] = $store->where('pos_id',$sessData['pos_id'])->findAll();

        $location_master = new LocationMaster();
        $data['location_master'] = $location_master->where('pos_id',$sessData['pos_id'])->findAll();

        $brandmatserModel = new BrandmasterModel();
        $data['brand'] = $brandmatserModel->where('pos_id',$sessData['pos_id'])->where("status",1)->findAll();
        
        $data['item'] = $itemModel->GetItemData();
        return $this->template->render('pages/items/items_list', $data); 
    }

    public function itemExportOptions()
    {
        $post = $this->request->getVar();
        $sessData = getSessionData();

        $weighingscale = new WeighingScaleModel();
        $weighingData = $weighingscale->first();

        $res = [];
        switch($post['type']) {
            case 'export_all':
                $item = new ItemModel();

                $item->select('items.id, items.item_name,items.barcode,cat.category_name,pr.supply_price,pr.retail_price,pr.current_inventory,u.uom,txm.tax_type');
                $item->join('categories cat','items.category_id = cat.id','left');
                $item->join('items_price pr','items.id = pr.items_id','left');
                $item->join('uom_master u','items.uom_id = u.id','left');
                $item->join('taxes','items.tax_id = taxes.id','left');
                $item->join('tax_master txm','taxes.tax_type_id = txm.id','left');
                $item->where('pr.store_id',$post['store_id']);

                $itemsData = $item->findAll();

                $file_name = 'Items_'.$post['store_id'].'_'.date('Ymd').'.xlsx';

                $data = [];
                foreach($itemsData as $row)
                {
                    $obj = [
                        'Store_ID' => $post['store_id'],
                        'Category' => $row['category_name'],
                        'Item_Code'=> $row['id'],
                        'Item_Name'=> $row['item_name'],
                        'Bar_Code' => $row['barcode'],
                        'Unit'     => $row['uom'],
                        'Purchase_Price'=>$row['supply_price'],
                        'Selling_Price' =>$row['retail_price'],
                        'Weighed'=>$row['id'],
                        'Tax_Label' => $row['tax_type'],
                        'Is_Tax_Inclusive'=>'Yes',
                        'Inventory_Qty'   =>$row['current_inventory']
                    ];
                    $data[] = $obj;
                }
                $res = [
                    'data'=>$data,
                    'file_name'=>$file_name
                ];
                
            break;
            case 'plu_export_csv':
                $item = new ItemModel();

                $item->select('items.id, items.item_name,items.shelflife,items.sku_barcode,items.barcode,items.item_options,pr.supply_price,pr.retail_price');
                $item->join('items_price pr','items.id = pr.items_id','left');
                $item->where('pr.store_id',$post['store_id']);
                $itemsData = $item->findAll();

                $file_name = 'PLU_Upd.csv';

                $header = array("Plu_No","UnitPrice","ShelfLife","SalesMode","DateFlag","Posflag","BarCodeNum","ExMessage2","ExMessage3","ItemCode","Coupon","Font1","Desc1","Font2","Desc2","Font3","Desc3","Font4","Desc4");
                $data = [];
                foreach ($itemsData as $key=>$val){
                    $options = json_decode($val['item_options']);
                    if(isset($options->weighing_scale) && $options->weighing_scale == 1) {
                        $salesMode = 0;
                        if($options->weighing_scale == 1 && $options->weight_item == 1) {
                            $salesMode = 0;
                        } else if($options->weighing_scale == 1 && $options->weight_item == 0) {
                            $salesMode = 1;
                        }
                        $arrayObj = array(
                            "Plu_No"=>$val['sku_barcode'],
                            "UnitPrice"=>$val['retail_price'].'.00',
                            "ShelfLife"=>isset($val['shelflife'])?$val['shelflife']:"0",
                            "SalesMode"=>$salesMode,
                            "DateFlag"=>"4",
                            "Posflag"=>$weighingData['prefix'],
                            "BarCodeNum"=>$weighingData['entry_code'],
                            "ExMessage2"=>'0',
                            "ExMessage3"=>'0',
                            "ItemCode"=>$val['sku_barcode'],
                            "Coupon"=>"0",
                            "Font1"=>"3",
                            "Desc1"=>$val['item_name'],
                            "Font2"=>"",
                            "Desc2"=>"",  
                            "Font3"=>"",
                            "Desc3"=>"",  
                            "Font4"=>"",
                            "Desc4"=>""                  
                        );
                        $data[] = $arrayObj;
                    }
                }

                $res = [
                    'data'=>$data,
                    'file_name'=>$file_name,
                    'header'=>$header
                ]; 
            break;
            case 'plu_export_txt':
                $item = new ItemModel();

                $item->select('items.id, items.item_name,items.shelflife,items.sku_barcode,items.barcode,items.item_options,pr.supply_price,pr.retail_price');
                $item->join('items_price pr','items.id = pr.items_id','left');
                $item->where('pr.store_id',$post['store_id']);
                $itemsData = $item->findAll();

                $file_name = 'PLU_Upd.txt';

                $header = array("PLU_No","UnitPrice","ShelfLife","SalesMode","DateFlag","PosFlag","BarCodeNum","ExMessage2","ExMessage3","ItemCode","Coupon","Font1","Desc1","Font2","Desc2","Font3","Desc3","Font4","Desc4"); 
                $data = [];
                foreach ($itemsData as $key=>$val){
                    $options = json_decode($val['item_options']);
                    $options = json_decode($val['item_options']);
                    if(isset($options->weighing_scale) && $options->weighing_scale == 1) {
                        $salesMode = 0;
                        if($options->weighing_scale == 1 && $options->weight_item == 1) {
                            $salesMode = 0;
                        } else if($options->weighing_scale == 1 && $options->weight_item == 0) {
                            $salesMode = 1;
                        }
                        $arrayObj = array(
                            "Plu_No"=>$val['sku_barcode'],
                            "UnitPrice"=>$val['retail_price'].'.00',
                            "ShelfLife"=>isset($val['shelflife'])?$val['shelflife']:"0",
                            "SalesMode"=>$salesMode,
                            "DateFlag"=>"4",
                            "Posflag"=>$weighingData['prefix'],
                            "BarCodeNum"=>$weighingData['entry_code'],
                            "ExMessage2"=>'0',
                            "ExMessage3"=>'0',
                            "ItemCode"=>$val['sku_barcode'],
                            "Coupon"=>"0",
                            "Font1"=>"3",
                            "Desc1"=>$val['item_name'],
                            "Font2"=>"",
                            "Desc2"=>"",  
                            "Font3"=>"",
                            "Desc3"=>"",  
                            "Font4"=>"",
                            "Desc4"=>""                  
                        );
                        $data[] = $arrayObj;
                    }
                }

                $res = [
                    'data'=>$data,
                    'file_name'=>$file_name,
                    'header'=>$header
                ]; 
            break;
            case 'expiry_items_export':
                $db = db_connect();

                $sql = "SELECT
                        i.item_name,
                        i.sku_barcode,
                        s.store_name,
                        l.location_description,
                        id.qty,
                        id.lot_no,
                        id.dom,
                        id.expiry_date,
                        DATEDIFF(id.expiry_date, CURDATE()) AS remaining_days
                        FROM
                        current_inventory_details id
                        JOIN
                        current_inventory iv ON id.current_inventory_id = iv.id
                        JOIN
                        items i ON iv.item_id = i.id
                        JOIN
                        location l ON iv.location_id = l.id
                        JOIN
                        stores s ON iv.store_id = s.id
                        WHERE
                        i.item_options LIKE '%\"track_expiry\":1%' AND 
                        id.qty > 0 AND
                        i.pos_id = '".$sessData['pos_id']."'
                        AND id.expiry_date >= CURDATE()
                        AND id.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 1 MONTH)";
                $query = $db->query($sql)->getResult();

                $sql2 = "SELECT
                        i.item_name,
                        i.sku_barcode,
                        s.store_name,
                        l.location_description,
                        id.qty,
                        id.lot_no,
                        id.dom,
                        id.expiry_date,
                        DATEDIFF(CURDATE(), id.expiry_date) as overdue_days
                    FROM
                        current_inventory_details id
                    JOIN
                        current_inventory iv ON id.current_inventory_id = iv.id
                    JOIN
                        items i ON iv.item_id = i.id
                    JOIN
                        stores s ON iv.store_id = s.id
                    JOIN
                        location l ON iv.location_id = l.id
                    WHERE
                        i.item_options LIKE '%\"track_expiry\":1%' AND 
                        id.qty > 0 AND
                        i.pos_id = '".$sessData['pos_id']."'
                        AND id.expiry_date <= CURDATE()";
                $query2 = $db->query($sql2)->getResult();

                $data = [];
                foreach($query as $k => $v) {
                    $list['store_name'] = $v->store_name;
                    $list['location_description'] = $v->location_description;
                    $list['item_name'] = $v->item_name;
                    $list['sku_barcode'] = $v->sku_barcode;
                    $list['qty'] = $v->qty;
                    $list['lot_no'] = $v->lot_no;
                    $list['dom'] = $v->dom;
                    $list['expiry_date'] = $v->expiry_date;
                    $list['remaining_days'] = $v->remaining_days;
                    $list['overdue_days'] = '-';
                    $data[] = $list;
                }

                foreach($query2 as $k => $v) {
                    $list['store_name'] = $v->store_name;
                    $list['location_description'] = $v->location_description;
                    $list['item_name'] = $v->item_name;
                    $list['sku_barcode'] = $v->sku_barcode;
                    $list['qty'] = $v->qty;
                    $list['lot_no'] = $v->lot_no;
                    $list['dom'] = $v->dom;
                    $list['expiry_date'] = $v->expiry_date;
                    $list['remaining_days'] = '-'.$v->overdue_days;           
                    $list['overdue_days'] = $v->overdue_days;
                    $data[] = $list;
                }


                $header = array('Store','Location','Item Name','SKU Barcode','Qty','Lot No','Date of Manf','Expiry Date','Remaining Days','Overdue Days');

                $file_name = 'ItemsExpiryDetails_'.date('Ymd');
                if($post['fileType'] == "xlsx") {
                    $header = [
                        ['Store','Location','Item Name','SKU Barcode','Qty','Lot No','Date of Manf','Expiry Date','Remaining Days','Overdue Days']
                    ];
                    $file_name.= '.xlsx';
                } else if($post['fileType'] == "csv") {
                    $file_name.= '.csv';
                }

                $res = [
                    'data'=>$data,
                    'file_name'=>$file_name,
                    'header'=>$header
                ];
                
            break;
        }

        return json_encode(['status'=>"true",'message'=>'Fetch Data','response'=>$res]); 
    }

    public function synchronizeStorePrices()
    {
        $post = $this->request->getVar();
        $sessData = getSessionData();

        $mainStoreID = $post['main_store'];
        $syncStores = $post['stores'];

        $items = new ItemModel();
        $itemsData = $items->where('pos_id',$sessData['pos_id'])->findAll();

        $db = db_connect();
        $commonModel = new CommonModel($db);

        foreach ($itemsData as $key => $value) {
            $itemPrices = new ItemsPriceModel();
            $dataToSync = $itemPrices->where('store_id',$mainStoreID)->where('items_id',$value['id'])->first();

            foreach($syncStores as $val) {
                if($val != $mainStoreID) {

                    $check = $itemPrices->where('store_id',$val)->where('items_id',$value['id'])->first();
                    $pItems = array(
                        'items_id' => $value['id'],
                        'store_id' => $val,
                        'supply_price' => $dataToSync['supply_price'],
                        'mrp' => $dataToSync['mrp'],
                        'mrp_percent' => $dataToSync['mrp_percent'],
                        'markup' => $dataToSync['markup'],
                        'retail_price' => $dataToSync['retail_price'],
                    );
                    if(!empty($check)) {
                        $updateItemsPrice = $commonModel->UpdateData('items_price',$check['id'],$pItems);
                    } else {
                        $addItemsPrice = $commonModel->AddData('items_price',$pItems);
                    }
                }
            }
        }

        return json_encode(['status'=>"true",'message'=>'Prices Synchronized successfully']); 
    }

    public function copyLocationItems()
    {
        $post = $this->request->getVar();
        $sessData = getSessionData();

        $db = db_connect();
        $commonModel = new CommonModel($db);

        $mainStoreID = $post['main_store'];
        $copyFrom = $post['copy_from_location'];
        $copyTo = $post['copy_to_location'];

        $items = new ItemModel();
        $itemsData = $items->select('id')->where('pos_id',$sessData['pos_id'])->findAll();
        $itemPrices = new ItemsPriceModel();
        $invt = new CurrentInventory();

        foreach ($itemsData as $key => $value) {
            $pr = $itemPrices->where('store_id',$mainStoreID)->where('items_id',$value['id'])->first();

            $where = [
                'store_id'=>$mainStoreID,
                'location_id'=>$copyFrom,
                'item_id'=>$value['id']
            ];

            $getData = $commonModel->GetTableDataByIDwithQty('current_inventory',$where);

            if(!empty($getData)) {
                $getDetailDt = $commonModel->GetTableDataByKey('current_inventory_details','current_inventory_id',$getData->id);
                $where2 = [
                    'store_id'=>$mainStoreID,
                    'location_id'=>$copyTo,
                    'item_id'=>$value['id']
                ];
                $getToData = $commonModel->GetTableDataByID('current_inventory',$where2);

                if(empty($getToData)) {
                    $aData = [
                        'store_id'=>$mainStoreID,
                        'location_id'=>$copyTo,
                        'item_id'=>$value['id'],
                        'quantity'=>$getData->quantity
                    ];
                    $aRes = $commonModel->AddData('current_inventory',$aData);
                    if(!empty($getDetailDt)){
                        foreach ($getDetailDt as $key => $v) {
                            $aDetData = [
                                'pos_id'=>$sessData['pos_id'],
                                'current_inventory_id'=>$aRes,
                                'qty'=>$v->qty,
                                'lot_no'=>$v->lot_no,
                                'dom'=>$v->dom,
                                'expiry_date'=>$v->expiry_date
                            ];
                            $commonModel->AddData('current_inventory_details',$aDetData);
                        }
                    }
                } else {
                    $uData = [
                        'quantity'=>$getToData->quantity + (int)$getData->quantity
                    ];
                    $commonModel->UpdateData('current_inventory',$getToData->id,$uData);
                    if(!empty($getDetailDt)){
                        foreach ($getDetailDt as $key => $v) {
                            $aDetData = [
                                'pos_id'=>$sessData['pos_id'],
                                'current_inventory_id'=>$getToData->id,
                                'qty'=>$v->qty,
                                'lot_no'=>$v->lot_no,
                                'dom'=>$v->dom,
                                'expiry_date'=>$v->expiry_date
                            ];
                            $commonModel->AddData('current_inventory_details',$aDetData);
                        }
                    }
                }
                $total = $invt->where('item_id',$value['id'])->where('store_id',$mainStoreID)->selectSum('quantity')->first();
                if(!empty($pr)) {
                    $uPriceData = [
                        'current_inventory'=>$total['quantity'],
                        'inventory_value'=>(int)$total['quantity']*$pr['retail_price']
                    ];
                    $commonModel->UpdateData('items_price',$pr['id'],$uPriceData);
                }
            }

        }

        return json_encode(['status'=>"true",'message'=>'Items copied successfully']); 
    }

    public function itemDeleteOptions()
    {
        $post = $this->request->getVar();
        $db = db_connect();
        $commonModel = new CommonModel($db);

        switch($post['type']) {
            case 'batch_delete':
                foreach($post['ids'] as $val) {
                    $cPrOrder = $db->table('purchase_order_item')->where('item_id',$val)->countAllResults();
                    $cSellOrder = $db->table('sell_items')->where('item_id',$val)->countAllResults();

                    if($cPrOrder >0 || $cSellOrder >0) {
                        $data = [
                            'status' => 0
                        ];
                        $result = $commonModel->UpdateData('items',$val,$data);
                    } else {
                        $db->table('items')->where('id',$val)->delete();
                    }
                }
            break;
            case 'all_delete':
                $items = new ItemModel();
                $itemsData = $items->select('id')->findAll();

                foreach($itemsData as $val) {
                    $cPrOrder = $db->table('purchase_order_item')->where('item_id',$val['id'])->countAllResults();
                    $cSellOrder = $db->table('sell_items')->where('item_id',$val['id'])->countAllResults();

                    if($cPrOrder >0 || $cSellOrder >0) {
                        $data = [
                            'status' => 0
                        ];
                        $result = $commonModel->UpdateData('items',$val['id'],$data);
                    } else {
                        $db->table('items')->where('id',$val['id'])->delete();
                    }
                }
            break;
        }
    }

    public function AddCategory()
    {
        $data = [];
        $data['title'] = 'Add Category'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items'); 
        $uomModel = new UomModel();
        $data['uom'] = $uomModel->where("status",1)->findAll();
        return $this->template->render('pages/items/category_add', $data); 
    }
    public function EditCategory($id)
    {
        $data = [];
        $data['title'] = 'Edit Category'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items'); 
         $categoryModel = new CategoryModel();
        $subcategoryModel = new SubcategoryModel();
         $uomModel = new UomModel();
        $data['uom'] = $uomModel->where("status",1)->findAll();
        
        $data['category'] = $categoryModel->where("id",$id)->first();
        $subcat = $subcategoryModel->GetSubCategoryData($id);
        $data['category']['sub_category'] = $subcat;

        return $this->template->render('pages/items/category_add', $data); 
    }

    public function AddSubcategory()
    {
        $data = [];
        $data['title'] = 'Add Subcategory'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items');
        return $this->template->render('pages/items/subcategory_add', $data); 
    }
    public function EditSubcategory($id)
    {
        $data = [];
        $data['title'] = 'Edit Subcategory'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items');
        $subcategoryModel = new SubcategoryModel();
        
        $data['subcategory'] = $subcategoryModel->where("id",$id)->first();

        return $this->template->render('pages/items/subcategory_add', $data); 
    }
    public function AddDepartment()
    {
        $data = [];
        $data['title'] = 'Add Department'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items');
        return $this->template->render('pages/items/department_add', $data); 
    }
    public function EditDepartment($id)
    {
        $data = [];
        $data['title'] = 'Edit Department'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items');
        $deptModel = new DepartmentModel();
        $data['department'] = $deptModel->where("id",$id)->first();

        return $this->template->render('pages/items/department_add', $data); 
    }
    public function getCategoryDataById()
    {
        $id = $this->request->getVar('id');

        $categoryMdl = new CategoryModel();
        $data = $categoryMdl->select('prefix')->where('id',$id)->first();

        $itemMdl = new ItemModel();
        $cItems = $itemMdl->where('category_id',$id)->countAllResults();
        $sku = $data['prefix'].$cItems;
        $sku = (int) $sku;
        
        if(!empty($data)){
            return json_encode(['status'=>"true",'message'=>'Fetch Data','sku'=>$sku]); 
        }else{
            return json_encode(['status'=>"false",'message'=>'No Data Found']); 
        }
    }
    public function getSubcategoryDataById()
    {
        $id = $this->request->getVar('id');
        $subcategoryModel = new SubcategoryModel();
        $data = $subcategoryModel->GetSubCategoryData($id);
        if(!empty($data)){
            return json_encode(['status'=>"true",'message'=>'Fetch Data','data'=>$data]); 
        }else{
            return json_encode(['status'=>"false",'message'=>'No Data Found']); 
        }
    }
    public function getItemsByCategoryId()
    {
        $sessData = getSessionData();

        $id = $this->request->getVar('id');
        $itemModel = new ItemModel();
        $data = $itemModel->GetItemDataByCategoryId($id,$sessData['pos_id']);
        $html = "";
        $html .=  '<option value="">Click to select item</option>';
            
        if(!empty($data)){
           foreach($data as $row){ 
                $html .='<option value="'.$row["id"].'">'.$row["item_name"].'</option>';
            }
            return json_encode(['status'=>"true",'message'=>'Fetch Data','data'=>$html]); 
        }else{
            return json_encode(['status'=>"false",'message'=>'No Data Found','data'=>$html]); 
        }
    }
    public function searchItems()
    {
        $type = $this->request->getVar('type');
        $txt = $this->request->getVar('term');
        $sessData = getSessionData();
        $items = new ItemModel();
        $data = [];

        if($type == "sales") {
            $data = $items->getCanSaleItems($sessData['pos_id'],$txt);
        } else if($type == "purchase") {
            $data = $items->getCanPurchaseItem($sessData['pos_id'],$txt);
        }
        
        if(!empty($data)){
            return json_encode(['status'=>"true",'message'=>'Fetch Data','data'=>$data]); 
        }else{
            return json_encode(['status'=>"false",'message'=>'No Data Found']); 
        }
    }
    public function AddUom()
    {
        $data = [];
        $data['title'] = 'Add UOM'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items'); 
        return $this->template->render('pages/items/uom_add', $data); 
    }
   
    public function Edituom($id)
    { 
        $data = [];
        $data['title'] = 'Edit UOM'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items'); 

        $uomModel = new UomModel();
        $data['uom'] = $uomModel->where("id",$id)->first();
        return $this->template->render('pages/items/uom_add', $data); 
    }
     public function AddBrand()
    {
        $data = [];
        $data['title'] = 'Add Brand'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items'); 
        return $this->template->render('pages/items/brand_add', $data); 
    }
     public function EditBrand($id)
    {
        $data = [];
        $data['title'] = 'Edit Brand'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items'); 
        $bmModel = new BrandMasterModel();
        $data['brand'] = $bmModel->where("id",$id)->first();
        return $this->template->render('pages/items/brand_add', $data); 
    }
    public function getItemDataById()
    {
        $id = $this->request->getVar('id');
        $itemModel = New ItemModel();
        $data = $itemModel->GetItemsByBrandId($id);
          
        if(!empty($data)){
            return json_encode(['status'=>"true",'message'=>'Fetch Data','data'=>$data]); 
        }else{
            return json_encode(['status'=>"false",'message'=>'No Data Found']); 
        }
    }
    public function AddModifier()
    {
        $data = [];
        $data['title'] = 'Add Modifier'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items');
        $sessData = getSessionData();

        $items = new ItemModel();
        $itemsData = "";
        
        if($sessData['role_name'] == "Owner") {

            $itemsData = $items->select('items.id,items.item_name')->like('item_options','%"can_sale":1%')->where('pos_id',$sessData['pos_id'])->findAll();
        }else {

            $itemsData = $items->select('items.id,items.item_name')->like('item_options','%"can_sale":1%')->where('pos_id',$sessData['pos_id'])->findAll();
        }
        
        $data['items'] = json_encode($itemsData);

        return $this->template->render('pages/items/modifiers_add', $data); 
    }
    public function EditModifier($id)
    {
        $data = [];
        $data['title'] = 'Edit Modifier'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items');
        $sessData = getSessionData();

        $items = new ItemModel();
        $itemsData = "";
        
        if($sessData['role_name'] == "Owner") {

            $itemsData = $items->select('items.id,items.item_name')->like('item_options','%"can_sale":1%')->where('items.pos_id',$sessData['pos_id'])->findAll();
        }else {

            $itemsData = $items->select('items.id,items.item_name')->like('item_options','%"can_sale":1%')->where('pos_id',$sessData['pos_id'])->findAll();
        }
        
        $data['items'] = json_encode($itemsData);
        $modifierModel = new ModifiersModel();
        $data['modifier'] = $modifierModel->where("id",$id)->first();
        $modifierItemModel = new ModifierItemsModel();
        $data['modifier']['modifier_items'] = $modifierItemModel->where('modifier_id',$id)->findAll();
        // echo "<pre>";print_r()

        return $this->template->render('pages/items/modifiers_add', $data);
    }
    public function AddItem()
    {
        $data = [];
        $data['title'] = 'Add Item'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items'); 
        
        $sessData = getSessionData();

        $data['operation'] = "add"; 
        $data['class'] = "active";
        /*$data['isAdmin'] = false;
        if($session->get('role_name') == "Manager") {
            $data['isAdmin'] = true;
        }*/
        
        $iModel = new ItemModel();
        $data['itemsData'] = $iModel->getItemList($sessData['pos_id']);

        $store = new StoreModel();
        $store->select('id,store_name');
        if($sessData['role_name'] == "Staff") {
            $store->where('id',$sessData['store_id']);
        }elseif($sessData['role_name'] == "Manager") {
            $store->where('pos_id',$sessData['pos_id']);
        }
        $data['stores'] = $store->findAll();
        $data['encoded_store'] = json_encode($data['stores']);
        
        $uomModel = new UomModel();
        $data['uom'] = $uomModel->findAll();

        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->GetCategoryData();
        $data['categoryEncData'] = json_encode($data['category']);

        $subcatModel = new SubcategoryModel();
        $data['sub_category'] = $subcatModel->where('status',1)->findAll();
        
        $brandmatserModel = new BrandmasterModel();
        $data['brand'] = $brandmatserModel->GetBrandData();

        $data['item_type'] = '';

        $modifiersModel = new ModifierItemsModel();
        $data['modifier'] = $modifiersModel->findAll();

        $taxModel = new TaxesModel();
        $data['tax'] = $taxModel->getTaxData();

        $vmModel = new VariantMatserModel();
        $data['variant'] = $vmModel->findAll();

        $cmModel = new CompositeMasterModel();
        $data['composite'] = $cmModel->findAll();

        return $this->template->render('pages/items/item_add', $data); 
    }
    public function EditItem($id)
    {
        $data = [];
        $data['title'] = 'Edit Item';
        $data['main_menu'] = 'Items';
        $data['main_menu_url'] = base_url('items');

        $sessData = getSessionData();

        $data['operation'] = "edit";
        $data['class'] = "";

        $store = new StoreModel();
        $store->select('id,store_name');
        if($sessData['role_name'] == "Staff") {
            $store->where('id',$sessData['store_id']);
        }elseif($sessData['role_name'] == "Manager") {
            $store->where('pos_id',$sessData['pos_id']);
        }
        $data['stores'] = $store->findAll();
        $data['encoded_store'] = json_encode($data['stores']);

        $iModel = new ItemModel();
        $data['itemsData'] = $iModel->getItemList($sessData['pos_id']);
        
        $itemsPriceModel = new ItemsPriceModel();
        
        $uomModel = new UomModel();
        $data['uom'] = $uomModel->findAll();

        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->GetCategoryData();
        $data['categoryEncData'] = json_encode($data['category']);
        
        $brandmatserModel = new BrandmasterModel();
        $data['brand'] = $brandmatserModel->GetBrandData();

        $modifiersModel = new ModifierItemsModel();
        $data['modifier'] = $modifiersModel->findAll();

        $taxModel = new TaxesModel();
        $data['tax'] = $taxModel->getTaxData();

        $vmModel = new VariantMatserModel();
        $data['variant'] = $vmModel->findAll();

        $variantsModel = new VariantsModel();
        $data['variantData'] = $variantsModel->where('item_id',$id)->findAll();

        $data['tags1'] = "";
        $data['tags2'] = "";
        foreach($data['variantData'] as $k => $v) {
            if($k == 0) {
                $data['tags1'] = $v['attribute'];
            } else {
                $data['tags2'] = $v['attribute'];
            }
        }

        $variantItems = $iModel->where('item_type',4)->where('item_master_id',$id)->findAll();
        $data['variant_items'] = $variantItems;

        foreach($data['variant_items'] as $k => $v) {
            $variantPrice = $itemsPriceModel->select('items_price.*,stores.store_name')->join('stores','items_price.store_id = stores.id','left')->where('items_id',$v['id'])->findAll();
            $data['variant_items'][$k]['stores'] = $variantPrice;
        }
        $cmModel = new CompositeMasterModel();
        $data['composite'] = $cmModel->findAll();

        $ciModel = new CompositeItemModel();
        $data['compositeData'] = $ciModel->where('item_id',$id)->findAll();

        $itemModel = new ItemModel();
        $subcatModel = new SubcategoryModel();
        $data['sub_category'] = $subcatModel->where('status',1)->findAll();
        $data['item'] = $itemModel->where("id",$id)->first();
        $data['item_type'] = $data['item']['item_type'];

        $array = [];
        $data['items_price'] = $itemsPriceModel->where('items_id',$id)->findAll();

        $ids = [];
        $sIds = [];
        foreach($data['stores'] as $k => $v) {
            $flg = false;
            foreach($data['items_price'] as $i => $p) {
                if($p['store_id'] == $v['id'] && !in_array($v['id'], $ids)) {
                    $flg = true;
                    $obj = [
                        'id' => $v['id'],
                        'store_name' => $v['store_name'],
                        'p_id' => $p['id'],
                        'supply_price' => $p['supply_price'],
                        'markup' => $p['markup'],
                        'retail_price' => $p['retail_price'],
                        'mrp' => $p['mrp'],
                        'mrp_percent' => $p['mrp_percent'],
                        'current_inventory' => $p['current_inventory'],
                        'inventory_value' => $p['inventory_value'],
                        're_order_point' => $p['re_order_point']
                    ];
                    $array[] = $obj;
                    $ids[] = $v['id'];
                    $sIds[] = $v['id'];
                    unset($data['items_price'][$i]);
                }elseif(!in_array($v['id'],$sIds)){
                    $obj = [
                        'id' => $v['id'],
                        'store_name' => $v['store_name']
                    ];
                    $array[] = $obj;
                }
            }     
        }
        
        $data['stores'] = $array;

        return $this->template->render('pages/items/item_add', $data); 
    }
    
    public function AddRecipe()
    {
        $data = [];
        $data['title'] = 'Add Recipe'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items'); 

        $sessData = getSessionData();

        $items = new ItemModel();
        $is_recipe_items = "";
        $is_ingredient_items = "";
        
        if($sessData['role_name'] == "Owner") {
            $is_recipe_items = $items->select('items.id,items.item_name')->like('item_options','%"is_recipe":1%')->where('pos_id',$sessData['pos_id'])->findAll();
            $is_ingredient_items = $items->select('items.id,items.item_name')->like('item_options','%"is_ingredient":1%')->where('pos_id',$sessData['pos_id'])->findAll();
        }else {
            $is_recipe_items = $items->select('items.id,items.item_name')->like('item_options','%"is_recipe":1%')->where('pos_id',$sessData['pos_id'])->findAll();
            $is_ingredient_items = $items->select('items.id,items.item_name')->like('item_options','%"is_ingredient":1%')->where('pos_id',$sessData['pos_id'])->findAll();
        }
        
        $data['is_recipe_items'] = $is_recipe_items;
        $data['is_ingredient_items'] = json_encode($is_ingredient_items);

        return $this->template->render('pages/items/recipe_add', $data);
    }

    public function EditRecipe($id)
    {
        $data = [];
        $data['title'] = 'Edit Recipe'; 
        $data['main_menu'] = 'Items'; 
        $data['main_menu_url'] = base_url('items'); 
        $sessData = getSessionData();

        $recipeModel = new RecipeModel();
        $recipeitemsModel = new RecipeItemsModel();
        
        $data['recipe'] = $recipeModel->where("id",$id)->first();
        $subcat = $recipeitemsModel->GetRecipeItemData($id);
        $data['recipe']['recipe_items'] = $subcat;

        $items = new ItemModel();
        $is_recipe_items = "";
        $is_ingredient_items = "";
        
        if($sessData['role_name'] == "Owner") {
            $is_recipe_items = $items->select('items.id,items.item_name')->like('item_options','%"is_recipe":1%')->where('pos_id',$sessData['pos_id'])->findAll();
            $is_ingredient_items = $items->select('items.id,items.item_name')->like('item_options','%"is_ingredient":1%')->where('pos_id',$sessData['pos_id'])->findAll();
        }else {
            $is_recipe_items = $items->select('items.id,items.item_name')->like('item_options','%"is_recipe":1%')->where('pos_id',$sessData['pos_id'])->findAll();
            $is_ingredient_items = $items->select('items.id,items.item_name')->like('item_options','%"is_ingredient":1%')->where('pos_id',$sessData['pos_id'])->findAll();
        }
        
        $data['is_recipe_items'] = $is_recipe_items;
        $data['is_ingredient_items'] = json_encode($is_ingredient_items);

        return $this->template->render('pages/items/recipe_add', $data); 
    }

    public function getRecipeItemsDataById()
    {
        $id = $this->request->getVar('id');
        $recipeitemModel = new RecipeItemsModel();
        $data = $recipeitemModel->GetRecipeItemData($id);

        if(!empty($data)){
            return json_encode(['status'=>"true",'message'=>'Fetch Data','data'=>$data]); 
        }else{
            return json_encode(['status'=>"false",'message'=>'No Data Found']); 
        }
    }
    
    public function Post_Data()
    {
         if ($this->request->getMethod() == "post") {
            $imageitem = "";
            $post = $this->request->getVar();

            $sessData = getSessionData();
            
            $result_data = "";
            $type = 0;
            switch($post['table_name']){
                case 'uom_master':
                        $data = [
                        'pos_id' => $sessData["pos_id"],
                        'formal_name' => $post["formal_name"],
                        'uom' => $post["uom"],
                        'decimal_point' => isset($post["decimal_point"])?$post["decimal_point"]:0,
                        'status' => isset($post["status"])?$post["status"]:0
                        ];
                break;
                case 'department':
                        $data = [
                            'pos_id' => $sessData['pos_id'],
                            'department_name' => $post["department_name"],
                            'markup_percent' => $post["markup_percent"],
                            'status' => isset($post["status"])?$post["status"]:0
                        ];
                break;
                case 'categories':
                        $data = [
                            'pos_id' => $sessData['pos_id'],
                            'category_name' => $post["category_name"],
                            'prefix' => $post["prefix"],
                            // 'description' => $post["description"],
                            'custom_reports' => isset($post["custom_report"])?$post["custom_report"]:'',
                            'status' => isset($post["status"])?$post["status"]:0
                        ];
                break;
                case 'subcategories':
                        $data = [
                            'pos_id' => $sessData['pos_id'],
                            // 'category_id' => $post['category_id'],
                            'subcategory_name' => $post["subcategory_name"],
                        ];
                break;
                case 'tax_master':
                    $data = [
                        'tax_type' => isset($post["tax_type"])?$post["tax_type"]:0,
                        'status' => isset($post["status"])?$post["status"]:0
                    ];
                break;
                case 'brandmasters':
                        $data = [
                            'pos_id' => $sessData['pos_id'],
                            'brand_name' => $post["brand_name"],
                            'status' => isset($post["status"])?$post["status"]:0
                        ];
                break;
                case 'modifiers':
                        $data = [
                        'name' => $post["name"],
                        'pos_id' => $sessData['pos_id'],
                        'store_id' => $sessData['store_id'],
                        // 'quantity' => $post["quantity"],
                        // 'group' => $post["group"],
                        // 'total_rate' => $post["total_rate"]?$post["total_rate"]:0,
                        // 'unit_rate' => $post["unit_rate"]?$post["unit_rate"]:0,
                        // 'is_active' => isset($post["is_active"])?$post["is_active"]:0,
                        'status' => isset($post["status"])?$post["status"]:0
                        ];
                break;
                case 'recipes_master':
                        $data = [
                            'pos_id'=>$sessData['pos_id'],
                            'store_id'=> $sessData['store_id'],
                            'group_name' => $post["group_name"],
                            'status' => isset($post["status"])?$post["status"]:0
                        ];
                break;
                case 'items':
                   if($post['item_type'] == 1){
                        if($this->request->getFile('item_image') != "")
                        {
                            $image = $this->request->getFile('item_image');
                            $imageitem = time().'.'.$image->getClientExtension();
                            $image->move(FCPATH . 'public/uploads/items',$imageitem);
                        }
                        else
                        {
                        $imageitem = isset($post['item_image_old'])?$post['item_image_old']:"";
                        }
                    }
                    if($post['item_type'] == 2){
                        if($this->request->getFile('item_image_variance') != "")
                        {
                            $image = $this->request->getFile('item_image_variance');
                            $imageitem = time().'.'.$image->getClientExtension();
                            $image->move(FCPATH . 'public/uploads/items',$imageitem);
                        }
                        else
                        {
                            $imageitem = isset($post['item_image_variance'])?$post['item_image_variance']:"";
                        }
                    }
                    if($post['item_type'] == 3){
                        if($this->request->getFile('item_image_composite') != "")
                        {
                            $image = $this->request->getFile('item_image_composite');
                            $imageitem = time().'.'.$image->getClientExtension();
                            $image->move(FCPATH . 'public/uploads/items',$imageitem);
                        }
                        else
                        {
                            $imageitem = isset($post['item_image_composite'])?$post['item_image_composite']:"";
                        }
                    }

                    $item_options = [
                        'stockable' => isset($post['item_option']['stockable'])?1:0,
                        'can_sale' => isset($post['item_option']['can_sale'])?1:0,
                        'weighing_scale' => isset($post['item_option']['weighing_scale'])?1:0,
                        'weight_item' => isset($post['item_option']['weight_item'])?1:0,
                        'favourite' => isset($post['item_option']['favourite'])?1:0,
                        'is_service' => isset($post['item_option']['is_service'])?1:0,
                        'is_recipe' => isset($post['item_option']['is_recipe'])?1:0,
                        'is_ingredient' => isset($post['item_option']['is_ingredient'])?1:0,
                        'can_purchase' => isset($post['item_option']['can_purchase'])?1:0,
                        'pre_production' => isset($post['item_option']['pre_production'])?1:0,
                        'track_expiry' => isset($post['item_option']['track_expiry'])?1:0,
                        'track_serial_no' => isset($post['item_option']['track_serial_no'])?1:0
                    ];
                
                    $data = [
                        'pos_id' => $sessData['pos_id'],
                        'item_type' => $post["item_type"],
                        'item_name' => $post["item_name"],
                        'item_image' => $imageitem,
                        'sku_barcode' => isset($post["sku_barcode"])?$post["sku_barcode"]:"",
                        'barcode' => isset($post["barcode"])?$post["barcode"]:"",
                        'shelflife' => isset($post["shelflife"])?$post["shelflife"]:"",
                        'pack_size' => isset($post["pack_size"])?$post["pack_size"]:"",
                        'category_id' => $post["category_id"],
                        'subcategory_id' => isset($post["subcategory_id"])?$post["subcategory_id"]:"",
                        'uom_id' => isset($post["uom_id"])?$post["uom_id"]:"",
                        'tax_id' => isset($post["tax_id"])?$post["tax_id"]:"",
                        'purchase_tax_id' => $post["purchase_tax_id"],
                        'brand_id' => isset($post["brand_id"])?$post["brand_id"]:"",
                        'modifier_id' => $post["modifier_id"],
                        // 'item_description' => $post["item_description"],
                        'item_options' => json_encode($item_options)/*)?json_encode($post['item_option']):""*/,
                        'status' => isset($post["status"])?$post["status"]:0,
                        'barcode_specification'=>isset($post['br'])?json_encode($post['br']):""
                    ];
                       
                break;
                case 'variant_master':
                    $data = [
                        'pos_id'=>$sessData['pos_id'],
                        'product_name' => $post["variant_name"],
                        'status' => isset($post["status"])?$post["status"]:1
                    ];
                break;
                case 'location':
                    $data = [
                        'pos_id'=>$sessData['pos_id'],
                        'location_description' => $post['location_description']
                    ];
                    if(isset($post['location_type'])){
                        $data['location_type'] = $post['location_type'];
                    }
                    if(isset($post['store_id'])){
                        $data['store_id'] = $post['store_id'];
                    }
                break;
                case 'composite_master':
                    $data = [
                        'product_name' => $post["variant_name"],
                        'status' => isset($post["status"])?$post["status"]:1
                    ];
                break;
               
            }
        }
        
        if(empty($data)){
            return json_encode([
                "status" => "warning",
                "message" => "Please add action name",
            ]);
        }
        
        $db = db_connect();
        $commonModel = new CommonModel($db);
        if(isset($post['id']) && $post['id'] == "")
        {
            $id = isset($post['id'])?$post['id']:"";
            $result = $commonModel->AddData($post['table_name'],$data);
            switch($post['table_name']){
                case 'categories':
                    $category_list = $this->getCategoryList();
                    $result_data = $category_list; 
                break;
                case 'subcategories':
                    $subcategoryModel = new SubcategoryModel();
                    $subcat = $subcategoryModel->where('status',1)->findAll();
                    $html = "";
                    
                    if(!empty($subcat)) {
                        $html = '<option value="">Please select</option>"';
                        foreach($subcat as $row){
                            $html .= '<option value="'.$row["id"].'">'.$row["subcategory_name"].'</option>';
                        }
                        $html .= '<option class="font-color" value="subcategory">Add Subcategory</option>';
                    } else {
                        $html = '<option value="">Please select</option>"';
                        $html .= '<option class="font-color" value="subcategory">Add Subcategory</option>';
                    }
                    $result_data = $html;
                    if(isset($post['subCatform'])) {
                        $type = 1;
                    }
                break;
                case 'items_master':
                    $item_list = $this->getMasterItemsList($result);
                    $result_data = $item_list;
                break;
                case 'uom_master':
                    $uom_list = $this->getUomList();
                    $result_data = $uom_list; 
                break;
                case 'recipes_master':
                    foreach($post['items'] as $row) {
                    
                        $items = array(
                            'recipe_id' => $result,
                            'item_id' => $row["item_id"],
                            'unit' => $row["unit"],
                            'cost' => $row["cost"],
                            'total_cost' => $row["total_cost"],
                        );
                        $addOrderItem = $commonModel->AddData('recipe_items',$items);
                    }
                break;
                case 'tax_master':
                    $data = [
                        'tax_type_id' => $result,
                        'tax_rate' => isset($post["tax_rate"])?$post["tax_rate"]:0,
                        'status' => isset($post["status"])?$post["status"]:0
                    ];
                    $commonModel->AddData('taxes',$data);
                    $tax_list = $this->getTaxList();
                    $result_data = $tax_list; 
                break;
                case 'brandmasters':
                    $brand_list = $this->getBrandList();
                    $result_data = $brand_list; 
                break;
                case 'modifiers':
                    foreach($post['items'] as $row) {
                    
                        $items = array(
                            'modifier_id' => $result,
                            'modifier_item_name' => $row["modifier_item"],
                            'cost' => $row["cost"],
                            'total_cost' => $row["total_cost"],
                            'quantity' => $row["unit"],
                            'item_id' => $row["item_id"],
                        );
                        $addModifierItem = $commonModel->AddData('modifier_items',$items);
                    }

                    $modifier_list = $this->getModifierList();
                    $result_data = $modifier_list; 
                break;
                case 'items':
                    $combinations = $this->generateCombStoreandLocation();
                    
                    foreach($combinations as $c) {
                        $inventoryData = [
                            'pos_id'=>$sessData['pos_id'],
                            'item_id'=>$result,
                            'store_id'=>$c[0],
                            'location_id'=>$c[1],
                            'quantity'=>0
                        ];
                        $commonModel->AddData('current_inventory',$inventoryData);
                    }

                    if(!empty($post['items_pr'])) {
                        foreach($post['items_pr'] as $row) {
                            $pItems = array(
                                'items_id' => $result,
                                'store_id' => $row['store_id'],
                                'supply_price' => $row['supply_price'],
                                'mrp' => $row['mrp'],
                                'mrp_percent' => $row['mrp_percent'],
                                'markup' => $row['markup'],
                                'retail_price' => $row['retail_price'],
                                'current_inventory' => $row['current_inventory'],
                                'inventory_value' => $row['inventory_value'],
                                're_order_point' => $row['reorder_point'],
                            );
                            $addItemsPrice = $commonModel->AddData('items_price',$pItems);
                        }
                    }
                    if($post['item_type'] == 2){
                        foreach($post['variant'] as $row){
                            if(!empty($row['variant_id'])){
                                $new_data = array(
                                    'item_id'=>$result,
                                    'variant_id'=>$row['variant_id'],
                                    'attribute'=>$row['attributes']
                                );
                                $commonModel->AddData('variants',$new_data);
                            }
                        }

                        foreach ($post['items'] as $key => $value) {
                            $new_data = array(
                                'pos_id'=>$sessData['pos_id'],
                                'item_master_id'=>$result,
                                'item_type'=> 4,
                                'item_name'=>$post["item_name"].' '.$value['name'],
                                'sku_barcode'=>$value['sku'],
                                'supply_price'=>$value['supply_price'],
                                'retail_price'=>$value['retail_price'],
                                'markup'=>$value['mrp_percent'],
                                'mrp'=>$value['mrp']
                            );
                            $aVarItem = $commonModel->AddData('items',$new_data);
                            foreach($value['stores'] as $row) {
                                $pItems = array(
                                    'items_id' => $aVarItem,
                                    'main_item_id'=>$result,
                                    'store_id' => $row['store_id'],
                                    'supply_price' => $value['supply_price'],
                                    'mrp' => $row['mrp'],
                                    'markup' => $value['mrp_percent'],
                                    'retail_price' => $row['retail_price'],
                                    'current_inventory' => $row['current_inventory'],
                                    'inventory_value' => $row['inventory_value'],
                                    're_order_point' => $row['reorder_point'],
                                );
                                $commonModel->AddData('items_price',$pItems);
                            }
                        }
                    }
                    if($post['item_type'] == 3){
                        foreach($post['composite'] as $row){
                            $new_data = array(
                                'item_id'=>$result,
                                'composite_item_id'=>$row['composite_item_id'],
                                'quantity'=>$row['quantity'],
                                'optional'=>isset($row['optional'])?$row['optional']:0,
                                'category_id'=>$row['category_id'],
                            );
                            $commonModel->AddData('composite_items',$new_data);

                        }
                    }
                break;
                case 'location':
                    $items = new ItemModel();
                    $inventory = new CurrentInventory();
                    $allItems = $items->where('pos_id',$sessData['pos_id'])->findAll();

                    foreach($allItems as $val) {
                        $inv = [
                            'pos_id'=>$sessData['pos_id'],
                            'item_id'=>$val['id'],
                            'store_id'=>$post['store_id'],
                            'location_id'=>$result,
                            'quantity'=>0
                        ];
                        $commonModel->AddData('current_inventory',$inv);
                    }
                break;
            }
            return json_encode([
                "status" => "true",
                "message" => "New Data added successfully",
                'data'=>$result_data,
                'type'=>$type
            ]);
        }
        else {
            $id = isset($post['id'])?$post['id']:"";
            $result = $commonModel->UpdateData($post['table_name'],$id,$data);

            switch($post['table_name']) {
                case 'items':
                    if(!empty($post['items_pr'])) {
                        foreach($post['items_pr'] as $row) {
                            $pItems = array(
                                'items_id' => $id,
                                'store_id' => $row['store_id'],
                                'mrp' => $row['mrp'],
                                'mrp_percent' => $row['mrp_percent'],
                                'markup' => $row['markup'],
                                'retail_price' => $row['retail_price'],
                                'current_inventory' => $row['current_inventory'],
                                'inventory_value' => $row['inventory_value'],
                                're_order_point' => $row['reorder_point'],
                            );
                            if(isset($row['id']) && $row['id'] != "") {
                                $updateItemsPrice = $commonModel->UpdateData('items_price',$row['id'],$pItems);
                            } else {
                                $addItemsPrice = $commonModel->AddData('items_price',$pItems);
                            }
                        }
                    }

                    if($post['item_type'] == 2){
                        foreach($post['variant'] as $row){
                            if($row['variant_id'] != "" && $row['variant_id'] > 0) {
                                $new_data = array(
                                    'item_id'=>$id,
                                    'variant_id'=>$row['variant_id'],
                                    'attribute'=>$row['attributes']
                                );
                                if(isset($row['id']) && $row['id'] != "") {
                                    $commonModel->UpdateData('variants',$row['id'],$new_data);
                                } else {
                                    $commonModel->AddData('variants',$new_data);
                                }
                            }
                        }

                        if(!empty($post['items'])) {
                            foreach ($post['items'] as $key => $value) {
                                $new_data = array(
                                    'pos_id'=>$sessData['pos_id'],
                                    'item_master_id'=>$id,
                                    'item_type'=> 4,
                                    'item_name'=>$post["item_name"].' '.$value['name'],
                                    'sku_barcode'=>$value['sku'],
                                    'supply_price'=>$value['supply_price'],
                                    'retail_price'=>$value['retail_price'],
                                    'markup'=>$value['mrp_percent'],
                                    'mrp'=>$value['mrp']
                                );
                                if(isset($value['id']) && $value['id'] != "") {
                                    $commonModel->UpdateData('items',$value['id'],$new_data);
                                    foreach($value['stores'] as $row) {
                                        $pItems = array(
                                            'items_id' => $value['id'],
                                            'main_item_id'=>$id,
                                            'store_id' => $row['store_id'],
                                            'supply_price' => $value['supply_price'],
                                            'mrp' => $row['mrp'],
                                            // 'mrp_percent' => $row['mrp_percent'],
                                            'markup' => $value['mrp_percent'],
                                            'retail_price' => $row['retail_price'],
                                            'current_inventory' => $row['current_inventory'],
                                            'inventory_value' => $row['inventory_value'],
                                            're_order_point' => $row['reorder_point'],
                                        );
                                        if(isset($row['id']) && $row['id'] != "") {
                                            $commonModel->UpdateData('items_price',$row['id'],$pItems);
                                        } else {
                                            $commonModel->AddData('items_price',$pItems);
                                        }
                                    }
                                } else {
                                    $aVarItem = $commonModel->AddData('items',$new_data);

                                    foreach($value['stores'] as $row) {
                                        $pItems = array(
                                            'items_id' => $aVarItem,
                                            'main_item_id'=>$id,
                                            'store_id' => $row['store_id'],
                                            'supply_price' => $value['supply_price'],
                                            'mrp' => $row['mrp'],
                                            // 'mrp_percent' => $row['mrp_percent'],
                                            'markup' => $value['mrp_percent'],
                                            'retail_price' => $row['retail_price'],
                                            'current_inventory' => $row['current_inventory'],
                                            'inventory_value' => $row['inventory_value'],
                                            're_order_point' => $row['reorder_point'],
                                        );
                                        $commonModel->AddData('items_price',$pItems);
                                    }
                                }
                            }
                        }
                        if($post['delVariants'] != "") {
                            $delVariant = explode(',', $post['delVariants']);
                            $commonModel->DeleteMultipleData('items','id',$delVariant);
                            $commonModel->DeleteMultipleData('items_price','items_id',$delVariant);
                        }
                    }
                    if($post['item_type'] == 3){
                        foreach($post['composite'] as $row){
                            $new_data = array(
                                'item_id'=>$id,
                                'composite_item_id'=>$row['composite_item_id'],
                                'quantity'=>$row['quantity'],
                                'optional'=>isset($row['optional'])?$row['optional']:0,
                                'category_id'=>$row['category_id'],
                            );
                            if(isset($row['id']) && $row['id'] != "") {
                                $commonModel->UpdateData('composite_items',$row['id'],$new_data);
                            } else {
                                $commonModel->AddData('composite_items',$new_data);
                            }

                        }
                    }
                break;
                case 'categories':
                    /*foreach($post['sub'] as $row){
                        if($row['subcategory_name'] != "") {  
                            if(isset($row['sub_cat_id'])){
                                $new_data = array(
                                    'pos_id' => $sessData['pos_id'],
                                    'category_id'=>$id,
                                    'subcategory_name'=>$row['subcategory_name'],
                                    // 'description'=>$row['sub_description']
                                );
                               $commonModel->UpdateData('subcategories',$row['sub_cat_id'],$new_data);
                            }else{
                                $new_data = array(
                                    'pos_id' => $sessData['pos_id'],
                                    'category_id'=>$id,
                                    'subcategory_name'=>$row['subcategory_name'],
                                    // 'description'=>$row['sub_description']
                                );
                                $commonModel->AddData('subcategories',$new_data);
                            }
                        }  
                    }*/
                break;
                case 'subcategories':
                    if(isset($post['subCatform'])) {
                        $type = 1;
                    }
                break;
                case 'modifiers':
                    foreach($post['items'] as $row){
                        if(isset($row['modifier_item_id'])){
                            $new_data = array(
                                'modifier_id' => $id,
                                'modifier_item_name' => $row["modifier_item"],
                                'cost' => $row["cost"],
                                'total_cost' => $row["total_cost"],
                                'quantity' => $row["unit"],
                                'item_id' => $row["item_id"],
                            );
                            $commonModel->UpdateData('modifier_items',$row['modifier_item_id'],$new_data);
                        } else {
                            $new_data = array(
                                'modifier_id' => $id,
                                'modifier_item_name' => $row["modifier_item"],
                                'cost' => $row["cost"],
                                'total_cost' => $row["total_cost"],
                                'quantity' => $row["unit"],
                                'item_id' => $row["item_id"],
                            );
                            
                            $commonModel->AddData('modifier_items',$new_data);
                        } 
                    }
                    break;
                case 'recipes_master':
                    foreach($post['items'] as $row){
                        if(isset($row['recipe_items_id'])){
                            $new_data = array(
                                'item_id'=>$row['item_id'],
                                'unit'=>$row['unit'],
                                'cost'=>$row['cost'],
                                'total_cost' => $row["total_cost"]
                            );
                            $commonModel->UpdateData('recipe_items',$row['recipe_items_id'],$new_data);
                        } else {
                            $new_data = array(
                                'recipe_id'=>$id,
                                'item_id'=>$row['item_id'],
                                'unit'=>$row['unit'],
                                'cost'=>$row['cost'],
                                'total_cost' => $row["total_cost"]
                            );
                            
                            $commonModel->AddData('recipe_items',$new_data);
                        } 
                    }
                }
            return json_encode([
                "status" => "true",
                "message" => "Data updated successfully",
                "type"=>$type
            ]);
        }
    }

    function generateCombStoreandLocation() {
        $sessData = getSessionData();
        $combinations = array();

        $store = new StoreModel();
        $location = new Location();
        $array1 = $store->select('id')->where('pos_id',$sessData['pos_id'])->where('status',1)->findAll();
        $array2 = $location->select('id')->findAll();

        foreach ($array1 as $item1) {
            foreach ($array2 as $item2) {
                $combinations[] = array($item1['id'], $item2['id']);
            }
        }
        return $combinations;
    }

    public function getVariant(){
        $sessData = getSessionData();
        $vmModel = new VariantMatserModel();
        $variant = $vmModel->where('pos_id',$sessData['pos_id'])->findAll();
        if(empty($variant)){
            echo json_encode(['status'=>"false","message"=>"Sub Category Not Found",'data'=>""]);
        }else{
            $html = "";
            $html .= '<option value="0">Click to select item</option>';
            foreach($variant as $row){
                $html .= '<option value="'.$row["id"].'">'.$row["product_name"].'</option>';
            }
            $html .= '<option value="add" class="storeColor"><i class="fa fa-plus"></i>Add New Variants</option>';
            echo json_encode(['status'=>"true","message"=>"Data Fetch Successfully",'data'=>$html,'variant'=>$variant]);
        }
    }

    public function getComposite(){
        $cmModel = new CompositeMasterModel();
        $combo = $cmModel->findAll();
        if(empty($combo)){
            echo json_encode(['status'=>"false","message"=>"Sub Category Not Found",'data'=>""]);
        }else{
            $html = "";
            $html .= '<option value="0">Click to select item</option>';
            foreach($combo as $row){
                $html .= '<option value="'.$row["id"].'">'.$row["product_name"].'</option>';
            }
            $html .= '<option value="add" class="storeColor"><i class="fa fa-plus"></i>Add New Combo Items</option>';
            echo json_encode(['status'=>"true","message"=>"Data Fetch Successfully",'data'=>$html]);
        }
    }
    
    public function getDepartment()
    {
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
       ## Total number of records without filtering
       $i = new DepartmentModel();
       $ft = new DepartmentModel();

       $totalRecords = $i->select('id')->where('pos_id',$sessData['pos_id'])->countAllResults();
       $filterRec = $ft->select('id');

        $i->select('department.*');

        if(!empty($advancesearchValue['search'])){
            $searchValue = $advancesearchValue['search']; 
            $i->like('department_name', $searchValue);
            $ft->like('department_name', $searchValue);
        }
        if(!empty($advancesearchValue['status'])){
            $searchStatus = $advancesearchValue['status']; 
            if($searchStatus == 1){
                $i->where('status', 1);
                $ft->where('status', 1);
            }else{ 
                $i->where('status', 0);
                $ft->where('status', 0);
            }
        }
        $i->where('department.pos_id',$sessData['pos_id']);
        
        $ft->where('pos_id',$sessData['pos_id']);
        
        $i->orderBy($columnName,$columnSortOrder);
        $records = $i->findAll($rowperpage, $start);

        $totalRecordwithFilter = $ft->countAllResults();

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
    public function getCategory()
    {   
       $request = service('request');
       $postData = $request->getPost();
       $sessData = getSessionData();
       
       $dtpostData = $postData['data'];
       $response = array();
        ## Read value
       $draw = $dtpostData['draw'];
       $start = $dtpostData['start'];
       $rowperpage = 20; // Rows display per page
       $columnIndex = $dtpostData['order'][0]['column']; // Column index
       $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
       $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
       $advancesearchValue = $dtpostData['advFilter']; // Search value
       // $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $cm = new CategoryModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

        ## Fetch records
        $cm->select('categories.id,categories.category_name,categories.status,categories.prefix,(select COUNT(id) from subcategories as s where s.category_id = categories.id and s.status = 1) as total_subcategories');
        
        if(!empty($advancesearchValue['search'])){
            $searchValue = $advancesearchValue['search'];
            $cm->orlike('category_name', $searchValue);
        }
        if(!empty($advancesearchValue['category'])){
            $searchStatus = $advancesearchValue['category'];
            $cm->where('categories.id',$searchStatus);
        }
         if(!empty($advancesearchValue['status'])){
            $searchStatus = $advancesearchValue['status']; 
            if($searchStatus == 1){
                $cm->where('status', 1);
            }else{ 
                $cm->where('status', 0);
            }
        }
        $cm->where('pos_id',$sessData['pos_id']);
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);

        $subcategoryModel = new SubcategoryModel();
      
        $subcat = [];
        foreach($records as $key=>$row){
            $subcat = $subcategoryModel->GetSubCategoryData($row['id']);
            $records[$key]['sub_category'] = $subcat;
        }
        
        $totalRecordwithFilter = count($records);
       
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

    public function getSubcategory()
    {
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
       ## Total number of records without filtering
       $i = new SubcategoryModel();
       $ft = new SubcategoryModel();

       $totalRecords = $i->select('id')->where('pos_id',$sessData['pos_id'])->countAllResults();
       $filterRec = $ft->select('id');

        $i->select('subcategories.*');

        if(!empty($advancesearchValue['search'])){
            $searchValue = $advancesearchValue['search']; 
            $i->like('subcategory_name', $searchValue);
            $ft->like('subcategory_name', $searchValue);
        }
        if(!empty($advancesearchValue['status'])){
            $searchStatus = $advancesearchValue['status']; 
            if($searchStatus == 1){
                $i->where('status', 1);
                $ft->where('status', 1);
            }else{ 
                $i->where('status', 0);
                $ft->where('status', 0);
            }
        }
        $i->where('subcategories.pos_id',$sessData['pos_id']);
        
        $ft->where('pos_id',$sessData['pos_id']);
        
        $i->orderBy($columnName,$columnSortOrder);
        $records = $i->findAll($rowperpage, $start);

        $totalRecordwithFilter = $ft->countAllResults();

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
    
    public function getRecipe()
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
       $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $cm = new RecipeModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

       ## Fetch records
        
        $cm->select('recipes_master.*,(select COUNT(id) from recipe_items  where recipe_items.recipe_id = recipes_master.id and recipes_master.status = 1) as total_items,(select sum(total_cost) from recipe_items  where recipe_items.recipe_id = recipes_master.id and recipes_master.status = 1) as total, items.item_name');
        $cm->join('items','items.id = recipes_master.group_name');

        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search'];
            $cm->like('group_name', $searchValue);
        }
         if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $cm->where('status', 1);
            }else{ 
                $cm->where('status', 0);
            }
        }
        $cm->where('recipes_master.pos_id',$sessData['pos_id']);
        $cm->orderBy($columnName,$columnSortOrder);

        $records = $cm->findAll($rowperpage, $start);

        $recipeitemModel = new RecipeItemsModel();
      
        $subcat = [];
        foreach($records as $key=>$row){
            $subcat = $recipeitemModel->GetRecipeItemData($row['id']);
            $records[$key]['recipe_items'] = $subcat;
        }
        
        $totalRecordwithFilter = count($records);
       
        $data = array();
       
       // foreach($records as $record ){ 
       // $data[] = array( 
       //       "item_name"=>$record['item_name'],
       //       "unit"=>$record['unit'],
       //       "cost"=>$record['cost'],
       //    ); 
       // }

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
    
    public function getModifiers()
    {
        
        $request = service('request');
        $postData = $request->getPost();
        $sessData = getSessionData();
        $dtpostData = $postData['data'];
        $response = array();

        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = $dtpostData['length'];
        $columnIndex = $dtpostData['order'][0]['column'];
        $columnName = $dtpostData['columns'][$columnIndex]['data'];
        $columnSortOrder = $dtpostData['order'][0]['dir'];
        $advancesearchValue = $dtpostData['advFilter'];
        $searchValue = $advancesearchValue['match']['search'];
        
        $cm = new ModifiersModel();
        $cmItems = new ModifierItemsModel();
        $totalRecords = $cm->select('id')
                ->countAllResults();

        $cm->select('modifiers.*, (select COUNT(id) from modifier_items where modifier_items.modifier_id = modifiers.id and modifiers.status = 1) as groups');

        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('name', $searchValue);
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

        foreach($records as $key=>$row){
            $product = $cmItems->select('items.item_name')
                    ->join('items','items.id = modifier_items.item_id')->where('modifier_items.modifier_id',$row['id'])->first();

            $records[$key]['product'] = $product != '' ? $product['item_name'] : '-';
        }
       
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

    public function getUom()
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
       $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $cm = new UomModel();
       $totalRecords = $cm->select('id')->countAllResults();

       ## Fetch records
        
        $cm->select('*');
        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('formal_name', $searchValue);
            $cm->orlike('uom', $searchValue);
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
    public function getBrand()
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
       $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $cm = new BrandmasterModel();
       $totalRecords = $cm->select('id')
                ->countAllResults();

       ## Fetch records
        /*$brandmatserModel = new BrandmasterModel();
        $data['brand'] = $brandmatserModel->GetBrandData();
        foreach($data['brand'] as $k=>$row){
            $data['brand'][$k]['sub_item'] = $itemModel->GetItemsByBrandId($row['id']);
        }*/
        $cm->select('id,brand_name,status,(select count(id) as total from items where brand_id = brandmasters.id) as total_items,(select sum(items_price.inventory_value) as total from items_price left join items on items.id = items_price.items_id where items.brand_id = brandmasters.id) as total_price,(select sum(items_price.current_inventory) as total from items_price left join items on items.id = items_price.items_id where items.brand_id = brandmasters.id) as total_qty');
        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $cm->like('brand_name', $searchValue);
        }
        if(!empty($advancesearchValue['equal']['category'])){
            $searchStatus = $advancesearchValue['equal']['category'];
            $cm->where('id',$searchStatus);
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

        $subcategoryModel = new SubcategoryModel();
      
        $subcat = [];
        $itemModel = New ItemModel();
        foreach($records as $key=>$row){
            $subcat = $itemModel->GetItemsByBrandId($row['id']);
            $records[$key]['items'] = $subcat;
        }
        
        $totalRecordwithFilter = count($records);
       
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
    public function getVariants()
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
       $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $i = new VariantMatserModel();
       $ft = new VariantMatserModel();

       $totalRecords = $i->select('id')->countAllResults();
       $filterRec = $ft->select('id');

        $i->select('variant_master.*');

        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $i->like('product_name', $searchValue);
            $ft->like('product_name', $searchValue);
        }

        $i->where('pos_id',$sessData['pos_id']);
        $i->orderBy($columnName,$columnSortOrder);
        $records = $i->findAll($rowperpage, $start);

        $totalRecordwithFilter = $ft->countAllResults();
       
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
    public function getLocation()
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
       $searchValue = $advancesearchValue['match']['search'];
      
       ## Total number of records without filtering
       $i = new Location();
       $ft = new Location();

       $totalRecords = $i->select('id')->countAllResults();
       $filterRec = $ft->select('id');

        $i->select('location.*,location_type_master.location_type,stores.store_name');

        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $i->like('location_type', $searchValue);
            $ft->like('location_type', $searchValue);
        }
        
        $ft->join('location_type_master','location.location_type = location_type_master.id');
        $ft->join('stores','location.store_id = stores.id');
        $ft->where('location.pos_id',$sessData['pos_id']);
        $ft->where('location.status',1);

        $i->join('location_type_master','location.location_type = location_type_master.id');
        $i->join('stores','location.store_id = stores.id');

        $i->where('location.pos_id',$sessData['pos_id']);
        $i->where('location.status',1);
        $i->orderBy('location.id','ASC');
        $records = $i->findAll($rowperpage, $start);

        $totalRecordwithFilter = $ft->countAllResults();
       
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
    public function getItem()
    {
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
       $i = new ItemModel();
       $ft = new ItemModel();

       $totalRecords = $i->select('id')->where('pos_id',$sessData['pos_id'])->countAllResults();
       $filterRec = $ft->select('id');

        $i->select('items.*,pr.supply_price,pr.retail_price,pr.current_inventory,pr.inventory_value,u.uom,c.category_name,sb.subcategory_name,tax_master.tax_type');
        $i->join('items_price as pr','items.id = pr.items_id','left');
        $i->join('uom_master as u', 'u.id = items.uom_id','left');
        $i->join('categories as c', 'c.id = items.category_id','left');
        $i->join('subcategories as sb', 'sb.id = items.subcategory_id','left');
        $i->join('taxes', 'taxes.id = items.tax_id','left');
        $i->join('tax_master', 'tax_master.id = taxes.tax_type_id','left');

        if(!empty($advancesearchValue['match']['search'])){
            $searchValue = $advancesearchValue['match']['search']; 
            $i->like('items.item_name', $searchValue);
            $ft->like('items.item_name', $searchValue);
        }
        if(!empty($advancesearchValue['equal']['category_id'])){
            $searchStatus = $advancesearchValue['equal']['category_id'];
            $i->where('items.category_id',$searchStatus);
            $ft->where('items.category_id',$searchStatus);
        }
        if(!empty($advancesearchValue['equal']['brand_id'])){
            $searchStatus = $advancesearchValue['equal']['brand_id'];
            $i->where('items.brand_id',$searchStatus);
            $ft->where('items.brand_id',$searchStatus);
        }
         if(!empty($advancesearchValue['equal']['item_type'])){
            $searchStatus = $advancesearchValue['equal']['item_type'];
            $i->where('items.item_type',$searchStatus);
            $ft->where('items.item_type',$searchStatus);
        }
         if(!empty($advancesearchValue['equal']['status'])){
            $searchStatus = $advancesearchValue['equal']['status']; 
            if($searchStatus == 1){
                $i->where('items.status', 1);
                $ft->where('items.status', 1);
            }else{ 
                $i->where('items.status', 0);
                $ft->where('items.status', 0);
            }
        }
        $i->whereIn('items.item_type',[1,2,3]);
        $i->where('items.pos_id',$sessData['pos_id']);
        $i->groupBy('items.id');
        
        $ft->whereIn('items.item_type',[1,2,3]);
        $ft->where('pos_id',$sessData['pos_id']);
        $ft->groupBy('items.id');
        
        $i->orderBy($columnName,$columnSortOrder);
        $records = $i->findAll($rowperpage, $start);
        $subcategoryModel = new SubcategoryModel();

        $totalRecordwithFilter = $ft->countAllResults();
      
        $subcat = [];
        /*$itemModel = New ItemModel();
        foreach($records as $key=>$row){
            $subcat = $itemModel->GetItemsByBrandId($row['id']);
            $records[$key]['items'] = $subcat;
        }
        */
       
       $data = array();
   
       foreach($records as $record ){ 
           $item_options = json_decode($record['item_options']);
          $data[] = array( 
             "id"=>$record['id'],
             "sku_barcode"=>$record['sku_barcode'],
             "item_name"=>$record['item_name'],
             "item_type"=>$record['item_type'],
             "category_name"=>$record['category_name'],
             "subcategory_name"=>$record['subcategory_name'],
             "uom"=>$record['uom'],
             "hash_batch"=>CheckStatus(isset($item_options->weighing_scale)?$item_options->weighing_scale:0),
             "serial_no"=>CheckStatus(isset($item_options->weight_item)?$item_options->weight_item:0),
             "stockable"=>CheckStatus(isset($item_options->stockable)?$item_options->stockable:0),
             "can_sale"=>CheckStatus(isset($item_options->cansale)?$item_options->cansale:0),
             "sell_online"=>CheckStatus(isset($item_options->is_service)?$item_options->is_service:0),
             "tax_type"=>$record['tax_type'],
             "supply_price"=>$record['supply_price'],
             "retail_price"=>$record['retail_price'],
             "current_inventory"=>$record['current_inventory'],
             "inventory_value"=>$record['inventory_value'],
             "status"=>$record['status']
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
    public function getExpiryItems()
    {
        $request = service('request');
        $postData = $request->getPost();
        $dtpostData = $postData['data'];
        $response = array();
        $sessData = getSessionData();

        $db = db_connect();

        $sql = "SELECT
                i.item_name,
                i.sku_barcode,
                s.store_name,
                l.location_description,
                id.qty,
                id.lot_no,
                id.dom,
                id.expiry_date,
                DATEDIFF(id.expiry_date, CURDATE()) AS remaining_days
                FROM
                current_inventory_details id
                JOIN
                current_inventory iv ON id.current_inventory_id = iv.id
                JOIN
                items i ON iv.item_id = i.id
                JOIN
                location l ON iv.location_id = l.id
                JOIN
                stores s ON iv.store_id = s.id
                WHERE
                i.item_options LIKE '%\"track_expiry\":1%' AND 
                id.qty > 0 AND
                i.pos_id = '".$sessData['pos_id']."'
                AND id.expiry_date >= CURDATE()
                AND id.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 1 MONTH)";
        $query = $db->query($sql)->getResult();

        $sql2 = "SELECT
                i.item_name,
                i.sku_barcode,
                s.store_name,
                l.location_description,
                id.qty,
                id.lot_no,
                id.dom,
                id.expiry_date,
                DATEDIFF(CURDATE(), id.expiry_date) as overdue_days
            FROM
                current_inventory_details id
            JOIN
                current_inventory iv ON id.current_inventory_id = iv.id
            JOIN
                items i ON iv.item_id = i.id
            JOIN
                stores s ON iv.store_id = s.id
            JOIN
                location l ON iv.location_id = l.id
            WHERE
                i.item_options LIKE '%\"track_expiry\":1%' AND 
                id.qty > 0 AND
                i.pos_id = '".$sessData['pos_id']."'
                AND id.expiry_date <= CURDATE()";
        $query2 = $db->query($sql2)->getResult();

        $data = [];
        foreach($query as $k => $v) {
            $list['store_name'] = $v->store_name;
            $list['location_description'] = $v->location_description;
            $list['item_name'] = $v->item_name;
            $list['sku_barcode'] = $v->sku_barcode;
            $list['qty'] = $v->qty;
            $list['lot_no'] = $v->lot_no;
            $list['dom'] = $v->dom;
            $list['expiry_date'] = $v->expiry_date;
            $list['remaining_days'] = $v->remaining_days;
            $list['overdue_days'] = '-';
            $data[] = $list;
        }

        foreach($query2 as $k => $v) {
            $list['store_name'] = $v->store_name;
            $list['location_description'] = $v->location_description;
            $list['item_name'] = $v->item_name;
            $list['sku_barcode'] = $v->sku_barcode;
            $list['qty'] = $v->qty;
            $list['lot_no'] = $v->lot_no;
            $list['dom'] = $v->dom;
            $list['expiry_date'] = $v->expiry_date;
            $list['remaining_days'] = '-'.$v->overdue_days;           
            $list['overdue_days'] = $v->overdue_days;
            $data[] = $list;
        }

        $totalRecords = count($data);

        ## Response
        $response = array(
          "draw" => 10,
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecords,
          "aaData" => $data,
          "token" => csrf_hash() // New token hash
        );

       return $this->response->setJSON($response);
    }
    public function getMasterItemsList($id)
    {
        $cm = new ItemMasterModel();
        $data = $cm->orderBy('id','desc')->findAll();
        $html = "";
        $html .=  '<option value="">Please select</option>';
            
        if(!empty($data)){
           foreach($data as $row){
                $selected = "";
                if($row['id'] == $id) {
                    $selected = "selected";
                }
                $html .='<option value="'.$row["id"].' selected="'.$selected.' ">'.$row["item_name"].'</option>';
            }
            return $html; 
        }else{
            return $html; 
        }
    }
    public function getCategoryList()
    {
        $sessData = getSessionData();

        $cm = new CategoryModel();
        $data = $cm->where('pos_id',$sessData['pos_id'])->where('status',1)->orderBy('id','desc')->findAll();
         $html = "";
         $html .=  '<option value="">Please select</option>';
            
        if(!empty($data)){
           foreach($data as $row){ 
                $html .='<option value="'.$row["id"].'">'.$row["category_name"].'</option>';
            }
            $html .='<option value="category">Add Category</option>';
            return $html; 
        }else{
            return $html; 
        }
    }

    public function getUomList()
    {
        $sessData = getSessionData();
        $um = new UomModel();
        $data = $um->where('status',1)->where('pos_id',$sessData['pos_id'])->orderBy('id','desc')->findAll();
         $html = "";
         $html .=  '<option value="">Please select</option>';
            
        if(!empty($data)){
           foreach($data as $row){ 
                $html .='<option value="'.$row["id"].'">'.$row["uom"].'</option>';
            }
            $html .='<option value="uom">Add UOM</option>';
            return $html; 
        }else{
            return $html; 
        }
    }

    public function getTaxList()
    {
        $tm = new TaxMasterModel();
        $data = $tm->where('status',1)->orderBy('id','desc')->findAll();
         $html = "";
         $html .=  '<option value="">Please select</option>';
            
        if(!empty($data)){
           foreach($data as $row){ 
                $html .='<option value="'.$row["id"].'">'.$row["tax_type"].'</option>';
            }
            $html .='<option value="tax">Add Tax</option>';
            return $html; 
        }else{
            return $html; 
        }
    }

    public function getBrandList()
    {
        $sessData = getSessionData();

        $bm = new BrandMasterModel();
        $data = $bm->where('pos_id',$sessData['pos_id'])->where('status',1)->orderBy('id','desc')->findAll();
         $html = "";
         $html .=  '<option value="">Please select</option>';
            
        if(!empty($data)){
           foreach($data as $row){ 
                $html .='<option value="'.$row["id"].'">'.$row["brand_name"].'</option>';
            }
            $html .='<option value="brand">Add Brand</option>';
            return $html; 
        }else{
            return $html; 
        }
    }

    public function getModifierList()
    {
        $mm = new ModifiersModel();
        $data = $mm->where('status',1)->orderBy('id','desc')->findAll();
         $html = "";
         $html .=  '<option value="">Please select</option>';
            
        if(!empty($data)){
           foreach($data as $row){ 
                $html .='<option value="'.$row["id"].'">'.$row["name"].'</option>';
            }
            $html .='<option value="modifier">Add Modifier</option>';
            return $html; 
        }else{
            return $html; 
        }
    }
         
}
