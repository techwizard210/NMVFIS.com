<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member_wallet_balance extends Model
{
    use HasFactory;
    protected $table = 'member_wallet_balances';
    protected $fillable = [
        'userId',
        'cash_balance',
        'investment',
        'investforother',
        'transfertoother',
        'income_amount',
    ];
}
