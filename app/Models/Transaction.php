<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'userId',
        'txn_id',
        'depositId',
        'address',
        'amount',
        'timeout',
        'confirms_needed',
        'checkout_url',
        'status_url',
        'qrcode_url',
        'status',
        'status_text',
        'type',
        'coin',
        'amount',
        'amountf',
        'received',
        'receivedf',
        'recv_confirms',
        'payment_address',
        'created_at',
        'updated_at',
    ];
}
