<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;

    protected $appends = ['seat_map_url'];

    public function getSeatMapUrlAttribute()
    {
        return asset('storage/' . $this->seat_map);
    }

    protected $fillable = ['name', 'image', 'description', 'start_date', 'end_date', 'seat_map', 'location'];

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Ticket::class, 'event_id', 'ticket_id');
    }
}
