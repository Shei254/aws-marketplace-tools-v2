<?php

namespace Shei\AwsMarketplaceTools\Models;

use Illuminate\Database\Eloquent\Model;

class AwsSubscription extends Model
{
    protected $fillable = ["aws_customer_id", "dimension", "quantity"];
}
