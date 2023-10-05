<?php

namespace App\Models;

use CodeIgniter\Model;

class GiftCardModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'giftcards';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['batch_id','voucher_card_no','expiry_date','amount'];

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
    
    public function GetGiftCardDataById($id)
    {
        $this->select('giftcards.*,giftcardmasters.batch_name');
        $this->join('giftcardmasters','giftcardmasters.id = giftcards.batch_id');
        $this->where("giftcards.id",$id);
        return $this->first();
    }
}
