<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_number',
        'user_id',
        'total',
        'status',
        'notes',
        'admin_notes',
        'payment_method',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'total'       => 'decimal:2',
    ];

    public static $statuses = [
        'pending'   => ['label' => 'Menunggu Konfirmasi', 'color' => 'warning',  'icon' => '⏳'],
        'approved'  => ['label' => 'Disetujui',           'color' => 'info',     'icon' => '✅'],
        'completed' => ['label' => 'Selesai',              'color' => 'success',  'icon' => '🌸'],
        'rejected'  => ['label' => 'Ditolak',              'color' => 'danger',   'icon' => '❌'],
    ];

    public function getStatusBadgeAttribute(): string
    {
        $s = self::$statuses[$this->status] ?? ['label' => $this->status, 'color' => 'secondary', 'icon' => '❓'];
        return '<span class="badge bg-' . $s['color'] . '">' . $s['icon'] . ' ' . $s['label'] . '</span>';
    }

    public static function generateInvoice(): string
    {
        $prefix = 'BLM-' . date('Ymd');
        $last   = self::where('invoice_number', 'like', $prefix . '%')->count() + 1;
        return $prefix . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}