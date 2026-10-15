<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Ticket extends Model
{
   use HasFactory;

   protected $table = 'tickets'; // Pastikan ini benar
   protected $primaryKey = 'id';

   protected $fillable = ['event_id', 'category_id', 'name', 'stock'];

   public function getIsExpiredAttribute()
   {
      return Carbon::parse($this->event->start_date)->isPast();
   }

   public function event()
   {
      return $this->belongsTo(Event::class);
   }

   public function category()
   {
      return $this->belongsTo(Category::class);
   }

   public function fees()
   {
       return $this->belongsToMany(Fee::class, 'ticket_fees')->withPivot('id');
   }
   

   public function user()
   {
      return $this->belongsTo(User::class);
   }

   public function orderItems()
   {
      return $this->hasMany(OrderItem::class);
   }
}
