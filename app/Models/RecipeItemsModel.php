<?php

namespace App\Models;

use CodeIgniter\Model;

class RecipeItemsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'recipe_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['recipe_id','unit','cost'];

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

    public function GetRecipeItemData($id) {
            $this->table('recipe_items')->select('recipe_items.*,items.item_name');
            $this->join('recipes_master','recipe_items.recipe_id = recipes_master.id');
            $this->join('items','recipe_items.item_id = items.id');
            $this->where('recipe_id',$id);
            return $this->findAll();
    }
}
