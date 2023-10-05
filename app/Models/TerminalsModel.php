<?php

namespace App\Models;

use CodeIgniter\Model;

class TerminalsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'terminals';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['terminal_name','store_id','type','sales_invoice_prefix','sales_invoice_starting_no','sales_return_prefix','sales_return_starting_no','status','created_at','updated_at'];

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
    
    public function GetTerminalData()
    {
        $this->select('terminals.*,stores.store_name');
        $this->join('stores','stores.id = terminals.store_id');
        return $this->findAll();
    }
    
    public function GetTerminalsData($id) {
            $this->table('terminals')->select("*");
            $this->where('store_id',$id);
            return $this->findAll();
    }
}
