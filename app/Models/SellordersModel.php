<?php

namespace App\Models;

use CodeIgniter\Model;

class SellordersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sell_orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','invoice_type','main_invoice_id','store_id','customer_id','order_number','invoice_date','due_date','currency_id','order_status','status','payment_status','is_include_tax','total_tax','sub_total','adjustment_value','total_amount','customer_note','created_at','updated_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    public function getRowCounts($pos_id)
    {
        $this->select('id')->where('pos_id',$pos_id);
        return $this->countAll();
    }
    public function GetInvoiceData()
    {
        $this->select('sell_orders.*,customers.registerd_name,currencies.currency_name,currencies.currency_code');
        $this->join('customers', 'customers.id = sell_orders.customer_id');
        $this->join('currencies', 'currencies.id = sell_orders.currency_id');

        return $this->findAll();
    }
    public function today_sale($value='',$store_id='',$owner_id='')
    {
        $date = date('Y-m-d');
        $this->select('sum(total_amount) as total');
        if($store_id != '') {
            $this->where('store_id',$store_id);
        }
        if($owner_id != '') {
            $this->join('stores','stores.id = sell_orders.store_id');
            $this->where('sell_orders.pos_id',$owner_id);
        }
       
        if($value == 1){
            $this->where('sell_orders.created_at >',$date.' 00:00:00');
            $this->where('sell_orders.created_at <',$date.' 23:59:59');
        }else if($value == 2){
            $yesterday = date('Y-m-d',strtotime('-1 day',strtotime($date)));
            $this->where('sell_orders.created_at >',$yesterday.' 00:00:00');
            $this->where('sell_orders.created_at <',$yesterday.' 23:59:59');
        }
        else if($value == 3){
            $this->where('MONTH(sell_orders.created_at)', date('m'));
            $this->where('YEAR(sell_orders.created_at)', date('Y'));
        }
        else if($value == 4){
            $month = date('Y-m-d',strtotime('-1 month',strtotime($date)));
            $this->where('MONTH(sell_orders.created_at)', date('m',strtotime($month)));
            $this->where('YEAR(sell_orders.created_at)', date('Y',strtotime($month)));
        }
       
        $result =  $this->first();
        if(empty($result['total'])){
            $result['total'] = 0;
        }
        return number_format((float)$result['total'], 2, '.', '');
    }
    public function getSalesByYear($year)
    {
       
        $this->select('sum(total_amount) as total,month(created_at) as month,date_format(created_at,"%b") as month_name,year(created_at) as year');
        $this->where('YEAR(created_at)',$year);
        $this->groupBy('month(created_at)');
        $result =  $this->findAll();
        return $result;
    }
     public function getTotalSalesByYear($year)
    {
        
        $this->select('sum(total_amount) as total');
        $this->where('YEAR(created_at)',$year);
        $result =  $this->first();
        return $result;
    }
    public function getSalesByMonths($month)
    { 
        $this->select('sum(total_amount) as total,date_format(created_at,"%d") as date');
        $this->where('month(created_at)',$month);
        $this->groupBy('date(created_at)');
        $result =  $this->findAll();
        return $result;
    }
    public function getTotalSalesByMonths($month)
    { 
        $this->select('sum(total_amount) as total');
        $this->where('month(created_at)',$month);
        $result =  $this->first();
        return $result;
    }
    public function getSalesByWeek($start_date,$end_date)
    {
        $this->select('sum(total_amount) as total,WEEKDAY(created_at) as day,date_format(created_at,"%a") as day_name');
        $this->where('created_at >= ',$start_date);
        $this->where('created_at <= ',$end_date);
        $this->groupBy('DAYOFWEEK(date)');
        $result =  $this->findAll();
        return $result;
    }
     public function getTotalSalesByWeek($start_date,$end_date)
    {
        $this->select('sum(total_amount) as total');
        $this->where('created_at >= ',$start_date);
        $this->where('created_at <= ',$end_date);
        $result =  $this->first();
        return $result;
    }
    public function getStoresByMonth($month)
    {
        $this->select('sum(total_amount) as total,stores.store_name,stores.phone,stores.id');
        $this->join('stores','sell_orders.store_id = stores.id');
        $this->where('month(sell_orders.created_at)',$month);
        $this->groupBy('sell_orders.store_id');
        $result =  $this->findAll();
        return $result;
    }
    
    public function getDailyTerminalSalesData()
    {  
        $date = date('Y-m-d');
        $this->select('sum(total_amount) as total,stores.store_name,sell_orders.terminal_id,terminals.terminal_name,stores.id');
        $this->join('terminals','sell_orders.terminal_id = terminals.id');
        $this->join('stores','sell_orders.store_id = stores.id');
        $this->where('sell_orders.created_at >= ',$date .' 00:00:00');
        $this->where('sell_orders.created_at <= ',$date .' 23:59:59');
        $this->groupBy('sell_orders.terminal_id');
        $result =  $this->findAll();
        return $result;
    }

      
}
