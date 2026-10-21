<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    // Setkan nama Primary Key sebab kau tak guna 'id' biasa
    protected $primaryKey = 'bill_id';

    // Buka kunci untuk column yang kita nak simpan data nanti
    protected $fillable = [
        'user_id',
        'biller_id',
        'link_id',
        'invoice_no',
        'tajuk_emel',
        'amount',
        'due_date',
        'payment_status',
    ];
    public function biller()
    {
        // Parameter: (Nama Model, Foreign Key dalam jadual bills, Primary Key dalam jadual billers)
        return $this->belongsTo(Biller::class, 'biller_id', 'biller_id');
    }
    
}