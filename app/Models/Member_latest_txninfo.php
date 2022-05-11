<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Member_latest_txninfo extends Model
{
    use HasFactory;
    protected $table = 'member_latest_txninfos';
    protected $fillable = [
        'userId',
        'txn_id',
        'date',
        'funds_amount',
    ];

    public function getUserLatestTxnInfo($userId)
    {
        $latestTxnInfo = DB::table('member_latest_txninfos')
            ->where([
                'userId' => $userId,
                // 'invest_status' => 0,
            ])
            // ->orderBy('menu_sort', 'ASC')
            ->get();

        return $latestTxnInfo;
    }
}
