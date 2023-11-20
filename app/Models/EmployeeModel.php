<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\StoreModel;

class EmployeeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employees';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['first_name','last_name','role_id','primary_email','country_code','phone','secondary_email','address','zip','city','password','store_id','forgot_password_token','status','state','country','time_zone','language','gender','nick_name','profile','contract','contract_date'];

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

    public function GetAllEmployeeData()
    {
        $this->select('employees.*,r.role_name');
        $this->join('role as r', 'r.id = employees.role_id');
        return $this->findAll();
    }
    public function UpdateData($table,$id,$data) 
    {
        return $this->db
                ->table($table)
                ->where(["id" => $id])
                ->set($data)
                ->update();
    }
    public function GetEmployeeData($id)
    {
        $sm = new StoreModel();
        $this->select('employees.*,employees.role_id,role.role_name');
        $this->join('role', 'role.id = employees.role_id');
        $this->where('employees.status',1);
        $this->where("employees.id",$id);
        $data=$this->first();
        $data['stores'] = "";
       
        if(!empty($data['store_id'])){
            $store_id = json_decode($data['store_id']);
            $store_data = $sm->GetStoreName($store_id[0]);
            $data['stores'] = $store_data;
        }
      
        return $data;
    }
    
}
