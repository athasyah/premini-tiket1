<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketFee extends Model
{
    use HasFactory;

    protected $table = 'ticket_fees'; 
    protected $fillable = ['ticket_id', 'fee_id'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }
}
