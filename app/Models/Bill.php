<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    // Setkan nama Primary Key sebab tak guna 'id' biasa
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
        'paid_at',
    ];
    public function biller()
    {
        // Parameter: (Nama Model, Foreign Key dalam jadual bills, Primary Key dalam jadual billers)
        return $this->belongsTo(Biller::class, 'biller_id', 'biller_id');
    }

    public function getPaymentUrlAttribute()
{
    // Pastikan letak nama column yang betul 
    return match(strtolower($this->biller_id)) { 
        '1' => 'https://myaccount.mytnb.com.my/Payment/QuickPay/',
        '2' => 'https://support.apple.com/billing',
        '3' => 'https://selfcare.unifi.com.my/billing/pay-for-anyone',
        '4' => 'https://support.apple.com/billing',
        default => '#'
    };
}
    
}
