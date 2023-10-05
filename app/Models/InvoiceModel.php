<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'invoices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['customer_id','invoice','order_number','due_date','invoice_date','terms','subject','currency_id','invoice_type'];

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

    public function GetInvoiceData()
    {
        $this->select('invoices.*,customers.registerd_name,currencies.currency_name,currencies.currency_code');
        $this->join('customers', 'customers.id = invoices.customer_id');
        $this->join('currencies', 'currencies.id = invoices.currency_id');
        
        return $this->findAll();
    }
    
      public function GetSellDataById($id)
    {
        $this->select('invoices.*,payment_type_master.payment_mode');
        $this->join('payment_type_master','payment_type_master.id = invoices.payment_mode');
        return $this->first();
    }
   
}
