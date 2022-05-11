<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Member_withdrawal_balance extends Model
{
    use HasFactory;
    protected $table = 'member_withdrawal_balances';
    protected $fillable = [
        'userId',
        'depositId',
        'input_amount',
        'withdrawal_amount',
        'status',
    ];


    public function getWithdrawalReports($userId)
    {
        $datas = DB::table('member_withdrawal_balances as t1')
            ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
            ->where([
                't1.userId' => $userId,
            ])
            ->select('t1.*', 't2.name', 't2.wallet_address')
            ->orderBy('t1.created_at', 'DESC')
            ->get();

        return $datas;
    }

    public function getWithdrawalReports_Admin($today)
    {
        $datas = DB::table('member_withdrawal_balances as t1')
            ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
            ->where([
                't1.created_at' => $today,
            ])
            ->select('t1.*', 't2.name', 't2.wallet_address')
            ->get();

        return $datas;
    }
}
