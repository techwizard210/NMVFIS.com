<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Withdrawal_fee extends Model
{
    use HasFactory;
    protected $table = 'withdrawal_fees';
    protected $fillable = [
        'userId',
        'depositId',
        'amount',
        'fee',
        'status',
    ];

    public function getAdminTransferReport($today)
    {
        $datas = DB::table('withdrawal_fees as t1')
            ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
            ->where([
                't1.created_at' => $today,
            ])
            ->select('t1.*', 't2.name', 't2.wallet_address')
            ->orderBy('t1.created_at', 'DESC')
            ->get();

        return $datas;
    }
}
