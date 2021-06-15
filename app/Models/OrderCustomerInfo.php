<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCustomerInfo extends Model
{
    use HasFactory;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id','id');
    }
}
