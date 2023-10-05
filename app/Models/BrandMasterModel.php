<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandMasterModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'brandmasters';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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

    public function GetBrandData() {
          $this->select('id,brand_name,status,(select count(id) as total from items where brand_id = brandmasters.id) as total_items,(select sum(inventory_value) as total from items where brand_id = brandmasters.id) as total_price,,(select sum(current_inventory) as total from items where brand_id = brandmasters.id) as total_qty');
          $this->orderBy('id desc');
          return $this->findAll();
    }
   
}
