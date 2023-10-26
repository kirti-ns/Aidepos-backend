<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesPaymentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sales_payment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['customer_id,amount_received,bank_charge,payment_date,payment_id,payment_mode,reference_id,currency_id,tax_deduction','invoice_id'];

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

    public function GetSalesInvoiceData()
    {
        $this->select('sales_payment.*,customers.registerd_name,currencies.currency_name,currencies.currency_code');
        $this->join('customers', 'customers.id = sales_payment.customer_id');
        $this->join('currencies', 'currencies.id = sales_payment.currency_id');
        // $this->join('invoices', 'invoices.id = sales_payment.invoice_id');

        return $this->findAll();
    }
    //View Payment
    public function GetSalesInvoiceDataById($id)
    {
        $this->select('sales_payment.*,customers.registerd_name,sell_orders.invoice_date,sell_orders.total_amount,payment_type_master.payment_type');
        $this->join('customers', 'customers.id = sales_payment.customer_id');
        $this->join('sell_orders', 'sell_orders.id = sales_payment.invoice_id');
        $this->join('payment_type_master', 'sales_payment.payment_id = payment_type_master.id');
        $this->where('sales_payment.id',$id);
        return $this->first();

        
    }
    
}
