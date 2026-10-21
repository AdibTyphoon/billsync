<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biller extends Model
{
    protected $primaryKey = 'biller_id';
    protected $fillable = ['biller_name', 'category', 'sender_email', 'status'];

    public function bills()
    {
        return $this->hasMany(Bill::class, 'biller_id', 'biller_id');
    }
}