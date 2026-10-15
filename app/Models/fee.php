<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',     
        'type',      
        'amount',    
        'percentage' 
    ];

    /**
     * Hitung fee berdasarkan tipe (fixed atau percent).
     *
     * @param float $price Harga dasar yang dikenakan fee
     * @return float Jumlah fee yang harus dibayar
     */
    public function calculateFee(float $price): float
    {
        if ($this->type === 'fixed') {
            return $this->amount ?? 0;
        } elseif ($this->type === 'percent') {
            return ($this->percentage / 100) * $price;
        }
        return 0;
    }

    public function tickets()
{
    return $this->belongsToMany(Ticket::class, 'ticket_fees');
}

}
