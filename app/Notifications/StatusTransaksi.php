<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StatusTransaksi extends Notification
{
    use Queueable;

    public function __construct(public Transaction $transaction) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $status = Transaction::$statuses[$this->transaction->status] ?? [];
        return [
            'transaction_id' => $this->transaction->id,
            'invoice'        => $this->transaction->invoice_number,
            'status'         => $this->transaction->status,
            'label'          => $status['label'] ?? $this->transaction->status,
            'icon'           => $status['icon'] ?? '📢',
            'admin_notes'    => $this->transaction->admin_notes,
            'message'        => 'Pesanan ' . $this->transaction->invoice_number . ' ' . ($status['label'] ?? $this->transaction->status),
        ];
    }
}