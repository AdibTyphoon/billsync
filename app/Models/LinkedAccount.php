<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedAccount extends Model
{
    protected $primaryKey = 'link_id';
    protected $fillable = ['user_id', 'provider_type', 'connected_email', 'sync_status', 'last_synced_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'link_id', 'link_id');
    }
}