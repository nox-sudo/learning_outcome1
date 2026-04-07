<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'old_status',
        'new_status',
        'changed_by',
        'changed_at',
    ];

    public static function log(int $orderId, ?string $oldStatus, string $newStatus, int $userId): self
    {
        return static::create([
            'order_id'   => $orderId,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => $userId,
            'changed_at' => now(),
        ]);
    }

    public static function getHistory(int $orderId)
    {
        return static::where('order_id', $orderId)->orderBy('changed_at')->get();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
