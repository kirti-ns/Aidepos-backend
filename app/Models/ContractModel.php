<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'layby_contract';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['pos_id','store_id','customer_id','first_name','last_name','city','address','phone','zipcode','contract_date','exchange_rate','status'];

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

    public function laybyReports($records){
        $contractTxnData = new ContractTransactionModel();
        $data = array();
        foreach($records as $record){
            $balance = $contractTxnData->checkContractDepositAmt($record['id']);
            $checkRefundAmt = $contractTxnData->checkContractRefundAmt($record['id']);
            $date_last_paid = $contractTxnData->where('contract_id',$record['id'])->orderBy('id','DESC')->first();
            $status = "In Process";
            if($record['contract_status'] == 1) {
                $status = "Payment Complete";
            } else if($record['contract_status'] == 2) {
                $status = "Partially Paid";
            } else if($record['contract_status'] == 3) {
                $status = "Cancelled";
            } else if($record['contract_status'] == 4) {
                $status = "Refunded";
            } else if($record['contract_status'] == 5) {
                $status = "Cancellation Refund";
            }
            $data[] = array(
               "contract"=>$record['id'],
               "store_name"=>$record['store_name'],
               "customer_name"=>$record['registerd_name'],
               "amount"=>$record['total_amount'],
               "balance"=>number_format((float)$record['total_amount'] - ((float)$balance['amount'] + $checkRefundAmt['amount']),2),
               "paid_amount"=>$balance['amount'] != "" || $balance['amount'] > 0 ? $balance['amount'] : "0.00",
               "date_last_paid"=>$date_last_paid != "" ? $date_last_paid['date'] : "-",
               "due_date"=>$record['due_date'],
               "status"=>$status
            ); 
        }
        return $data;
    }

    public function laybyReportswithBalance($records,$amount){
        $contractTxnData = new ContractTransactionModel();
        $data = array();
        foreach($records as $record){
            $balance = $contractTxnData->checkContractDepositAmt($record['id']);
            $checkRefundAmt = $contractTxnData->checkContractRefundAmt($record['id']);
            $date_last_paid = $contractTxnData->where('contract_id',$record['id'])->orderBy('id','DESC')->first();
            $status = "In Process";
            if($record['contract_status'] == 1) {
                $status = "Payment Complete";
            } else if($record['contract_status'] == 2) {
                $status = "Partially Paid";
            } else if($record['contract_status'] == 3) {
                $status = "Cancelled";
            } else if($record['contract_status'] == 4) {
                $status = "Refunded";
            } else if($record['contract_status'] == 5) {
                $status = "Cancellation Refund";
            }
            $bal = "";
            if(!empty($balance)) {
                $bal = number_format((float)$record['total_amount'] - ((float)$balance['amount'] + $checkRefundAmt['amount']),2);
            }

            if(!$bal != "" && $bal < $amount) {
                $data[] = array(
                   "contract"=>$record['id'],
                   "store_name"=>$record['store_name'],
                   "customer_name"=>$record['registerd_name'],
                   "amount"=>$record['total_amount'],
                   "balance"=>$bal,
                   "paid_amount"=>$balance['amount'] != "" || $balance['amount'] > 0 ? $balance['amount'] : "0.00",
                   "date_last_paid"=>$date_last_paid != "" ? $date_last_paid['date'] : "-",
                   "due_date"=>$record['due_date'],
                   "status"=>$status
                );
            }
        }
        return $data;
    }

}
