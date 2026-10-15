<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $fillable = ['order_id', 'payment_method', 'amount_paid', 'status', 'bank_name', 'account_number', 'phone_number'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
