<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket(){
        return $this->hasMany(Ticket::class);
    }
}
