<?php 
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class CommonModel extends Model {
	
	protected $db;
	public function __construct(ConnectionInterface &$db) {
		$this->db =& $db;
	}

    public function getLastID($table) {
        $query = $this->db->table($table)->select('id')->orderby('ID','DESC')
                      ->get();
        $row = $query->getRow();

        if($row){
            $idPostfix = (int)$row->id+1;
            $nextId = $idPostfix;
        }
        else{$nextId = 1;}
        return $nextId;
    }

	function AddData($table,$data) {		
		$this->db
                ->table($table)
                ->insert($data);
        return $this->db->insertID();
	}	
	public function UpdateData($table,$id,$data) {
		return $this->db
                ->table($table)
                ->where(["id" => $id])
                ->set($data)
                ->update();
	}
	public function UpdateDataByField($table,$field,$field_value, $field_value2,$data) {
		return $this->db
                ->table($table)
                ->where([$field => $field_value])
                ->where(['created_at' => $field_value2])
                ->set($data)
                ->update();
	}
	public function DeleteData($table,$id) {
		return $this->db
                ->table($table)
                ->where(["id" => $id])
                ->delete();
	}
	public function DeleteMultipleDataByField($table,$field,$field_value,$date) {
		return $this->db
                ->table($table)
                ->where('created_at <=',$date)
                ->whereIn($field,$field_value)
                ->delete();
	}
    public function DeleteMultipleData($table,$field,$field_value) {
        return $this->db
                ->table($table)
                ->whereIn($field,$field_value)
                ->delete();
    }
	public function GetTableDataByIDwithQty($table,$where) {
        $query = $this->db->table($table)->select("*")
        		->where('store_id',$where['store_id'])
        		->where('item_id',$where['item_id'])
        		->where('location_id',$where['location_id'])
        		->where('quantity >', 0)->get();
        return $query->getRow();
    }
    public function GetTableDataByID($table,$where) {
        $query = $this->db->table($table)->select("*")
        		->where('store_id',$where['store_id'])
        		->where('item_id',$where['item_id'])
        		->where('location_id',$where['location_id'])
        		->get();
        return $query->getRow();
    }

	public function GetTableDataByKey($table,$key,$val) {
        return $this->db->table($table)->select("*")
        		->where($key,$val)->get()->getResult();
    }
	public function GetTableData($table,$where) { 
            $this->db->table($table)->select("*");
            if (isset($where)) {
				foreach ($where as $k => $v) { 
					$this->db->where($k, $v, true);
				}
			}
            //$this->db->where($where);
            return $this->findAll();
    }

}