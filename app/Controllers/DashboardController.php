<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use App\Models\SellordersModel;
use App\Models\ItemModel;
use App\Models\CategoryModel;
use App\Models\BrandMasterModel;
use App\Models\SellItemsModel;
use App\Models\TerminalsModel;

class DashboardController extends BaseController
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

        $sessData = getSessionData();
        $store_id = '';
        $pos_id = $sessData['pos_id'];

        if($sessData['role_name'] == "Admin") {
            $pos_id = $sessData['pos_id'];
        } else {
            $store_id = $sessData['store_id'];
        }
        
        $sellOrderModel = new SellordersModel();
        
        $data['today'] = $sellOrderModel->today_sale(1,$store_id,$pos_id);
        $data['yesterday'] = $sellOrderModel->today_sale(2,$store_id,$pos_id);
        $data['current_month'] = $sellOrderModel->today_sale(3,$store_id,$pos_id);
        $data['last_month'] = $sellOrderModel->today_sale(4,$store_id,$pos_id);
        
        $itemModel = new ItemModel();
        $data['total_items'] = $itemModel->where('pos_id',$pos_id)->countAllResults();
        $data['active_items'] = $itemModel->where('pos_id',$pos_id)->where('status',1)->countAllResults();
        $data['inactive_items'] = $itemModel->where('pos_id',$pos_id)->where('status',0)->countAllResults();

        $categoryModel = new CategoryModel();
        $data['total_categories'] = $categoryModel->where('pos_id',$pos_id)->where('status',1)->countAllResults();
        $brandModel = new BrandMasterModel();
        $data['total_brands'] = $brandModel->where('pos_id',$pos_id)->where('status',1)->countAllResults();
        
        $data['top_items'] = [];
        for($i = 1; $i <=  date('t'); $i++)
        {
           $dates_array[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        $date = date('Y-m-01'); // first day of current month
        $month = date('m');
        $sales = $sellOrderModel->getSalesByMonths($month);
         $sale = array();
         foreach($dates_array as $key=>$row){
            $sale[$key]['date'] = $row;
            $sale[$key]['current'] = "0";
            $sale[$key]['previous'] = "0.00";
               
            foreach ($sales as $k => $v) {
              if($row == $v['date']){
                 $sale[$key]['date'] = $row;
                 $sale[$key]['current']= number_format((float)$v['total'], 2, '.', '');
               }
            }
        }

        $previouse_month = date("m",strtotime("-1 month"));

        $previous_sales = $sellOrderModel->getSalesByMonths($previouse_month);
        
        $previous_sale = array();
        foreach($sale as $key=>$row){ 
                  $previous_sale[$key]['date'] = $row['date'];
                  $previous_sale[$key]['current'] = number_format((float)$row['current'], 2, '.', '');
                  $previous_sale[$key]['previous'] = "0.00";
              foreach ($previous_sales as $k => $v) {
                if($row['date'] == $v['date']){
                  $previous_sale[$key]['date'] = $row['date'];
                  $previous_sale[$key]['current'] = number_format((float)$row['current'], 2, '.', '');
                  $previous_sale[$key]['previous'] = number_format((float)$v['total'], 2, '.', '');;
                 }
               }
        }
        $total_sale = '';
        
        $data['sales'] = json_encode($previous_sale);  
        $sales_text = array("Current Month","Previous Month");
        $data['sales_text'] = json_encode($sales_text);
        $month = date('m');
        $data['top_items'] = [];
        $sellItemsModel = new SellItemsModel();
        $sales_items = $sellItemsModel->getSaleItemsByMonths($month,$sessData['pos_id']);
        $top_items = $top_items_total = [];
        foreach($sales_items as $row){
            $top_items[] = $row['item_name'];
            $top_items_total[] = $row['total_qty'];
        }
       
        $data['top_items']['top_items'] = json_encode($top_items);
        $data['top_items']['top_items_total'] = json_encode($top_items_total);

        $sellOrderModel = new SellordersModel();
        $date = date('Y-m-01'); 
        $month = date('m');
        $data['sale'] = $sellOrderModel->getStoresByMonth($month,$sessData['pos_id']);
        
        $data['daily_sales'] = $sellOrderModel->getDailyTerminalSalesData($sessData['pos_id']);
        
        $data['current_year'] = $sellOrderModel->getTotalSalesByMonths($month);
        $data['previous_year'] = $sellOrderModel->getTotalSalesByMonths($previouse_month);
        
        return $this->template->render('index',$data);
    }
    
}