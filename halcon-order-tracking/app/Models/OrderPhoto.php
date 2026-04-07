<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPhoto extends Model
{
    const TYPE_LOADING  = 'loading';
    const TYPE_DELIVERY = 'delivery';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'photo_type',
        'photo_url',
        'uploaded_by',
        'uploaded_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
