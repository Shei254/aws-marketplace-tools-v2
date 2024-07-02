<?php

namespace Shei\AwsMarketplaceTools\Models;

use Illuminate\Database\Eloquent\Model;

class AwsCustomer extends Model
{
    protected $fillable = ["customer_id", "user_id"];

    public function assignUser (int $userId) {
        $this->user_id = $userId;
        $this->save();
    }
}
