<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stores';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["pos_id","store_name","phone","country_code","tax_no","address","zip","city","features","status"];

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
    
    public function GetAllStore(){
      
          $this->select('*,(select count(id) as total from terminals where store_id = stores.id) as total_terminals');
          $this->orderBy('id desc');
          return $this->findAll();
   
    }
    public function GetStoreName($id)
    {
        $this->select('stores.store_name,stores.id as store_id');
        $this->table('stores');
        $this->where('stores.id',$id);
        $data = $this->findAll();
        return $data;

    }
}
