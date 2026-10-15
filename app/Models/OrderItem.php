<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'ticket_id', 'quantity', 'price', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    protected static function booted()
{
    static::created(function ($orderItem) {
        $order = Order::find($orderItem->order_id);
        if ($order && $order->orderItems()->count() > 0) {
            $order->update(['status' => 'success']);
        }
    });
}

}

