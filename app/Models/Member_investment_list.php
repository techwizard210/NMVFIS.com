<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Member_investment_list extends Model
{
    use HasFactory;
    protected $table = 'member_investment_lists';
    protected $fillable = [
        'depositId',
        'userId',
        'amount',
        'package',
        'income_percent',
        'invest_status',
    ];

    public function create(array $request)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $amount = $request['amount'];
        $package = $request['package'];

        $randomDepositId = uniqid();

        return Member_investment_list::create([
            'depositId' => $randomDepositId,
            'userId' => $userId,
            'amount' => $amount,
            'package' => $package,
            'invest_status' => 0,
        ]);
    }

    public function getUserInvestData($userId)
    {
        $invest_datas = DB::table('member_investment_lists')
            ->where([
                'userId' => $userId,
                'invest_status' => 0,
            ])
            ->first();
        return $invest_datas;
    }

    public function updateUserIncomePercent($userId, $percent)
    {
        return Member_investment_list::where('userId', $userId)
            ->update([
                'income_percent' =>  $percent,
            ]);
    }

    public function getInvestmentReports($userId)
    {
        $temp_data = DB::table('member_roi_lists as a1')
            ->where([
                'a1.userId' => '"' . $userId . '"',
            ])
            ->selectRaw('a1.userId, sum(a1.roi_amount) as total_roi, sum(a1.percent) as total_percent')
            ->groupBy('a1.userId', 'a1.depositId');

        $datas = DB::table('member_investment_lists as t1')
            ->leftJoin('member_investforother_lists as t3', function ($q) {
                $q->on('t1.userId', '=', 't3.otherUserId')
                    ->on('t1.created_at', '=', 't3.created_at');
            })
            ->leftJoin('users as t4', 't3.userId', '=', 't4.userId')
            ->leftJoinSub($temp_data, 't2', function ($join) {
                $join->on('t1.userId', '=', 't2.userId');
            })
            ->where(['t1.userId' => $userId,])
            ->select('t1.*', 't2.total_roi', 't2.total_percent', 't4.name')
            // ->orderBy('menu_sort', 'ASC')
            ->get();
        return $datas;
    }
}
