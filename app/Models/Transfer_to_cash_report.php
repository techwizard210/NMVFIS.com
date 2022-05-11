<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Transfer_to_cash_report extends Model
{
    use HasFactory;
    protected $table = 'transfer_to_cash_reports';
    protected $fillable = [
        'userId',
        'amount',
    ];

    public function create($request)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $amount = $request->amount;

        return Transfer_to_cash_report::create([
            'userId' => $userId,
            'amount' => $amount,
        ]);
    }
}
