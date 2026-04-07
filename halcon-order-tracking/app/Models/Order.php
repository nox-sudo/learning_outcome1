<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_ORDERED    = 'ordered';
    const STATUS_IN_PROCESS = 'in_process';
    const STATUS_IN_ROUTE   = 'in_route';
    const STATUS_DELIVERED  = 'delivered';

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'customer_number',
        'rfc',
        'fiscal_address',
        'fiscal_email',
        'delivery_address',
        'notes',
        'order_date',
        'status',
        'deleted',
        'created_by',
    ];

    public function changeStatus(string $newStatus, int $userId): void
    {
        $oldStatus = $this->status;
        $this->status = $newStatus;
        $this->save();

        StatusHistory::log($this->id, $oldStatus, $newStatus, $userId);
    }

    public function softDelete(): void
    {
        $this->deleted = true;
        $this->save();
    }

    public function restore(): void
    {
        $this->deleted = false;
        $this->save();
    }

    public function scopeActive($query)
    {
        return $query->where('deleted', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('deleted', true);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function photos()
    {
        return $this->hasMany(OrderPhoto::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(StatusHistory::class);
    }
}
