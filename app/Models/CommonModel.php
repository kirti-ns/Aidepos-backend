<?php 
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class CommonModel extends Model {
	
	protected $db;
	public function __construct(ConnectionInterface &$db) {
		$this->db =& $db;
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
	public function UpdateDataByField($table,$field,$field_value,$data) {
		return $this->db
                ->table($table)
                ->where([$field => $field_value])
                ->set($data)
                ->update();
	}
	public function DeleteData($table,$id) {
		return $this->db
                ->table($table)
                ->where(["id" => $id])
                ->delete();
	}
	public function DeleteMultipleDataByField($table,$field,$field_value) {
		return $this->db
                ->table($table)
                ->whereIn($field,$field_value)
                ->delete();
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