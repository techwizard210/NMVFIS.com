<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\Controller;
use App\Models\Member_investment_list;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Daily_ROI_Percentage;
use App\Models\Member_roi_list;
use App\Models\Member_wallet_balance;

class RoiIncomeController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $userData = User::where('userId', $userId)->first();

        $roiModel = new Member_roi_list();
        $userRoiDatas = $roiModel->getUserRoiData($userId);
        return view('pages.income.roi')->with(['userData' => $userData, 'userRoiDatas' => $userRoiDatas]);
    }

    public function roiIncome(Request $request)
    {
        $percent = $request->percent;

        $investmentModel = new Member_investment_list();

        $user_rows = User::where('role', 'user')->get();
        try {
            $dailyROIModel = new Daily_ROI_Percentage();
            $dailyROIModel->percent =  $percent;
            $dailyROIModel->save();

            $admin_wallet_balance = DB::table('member_wallet_balances as t1')
                ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
                ->where('t2.role', 'admin')
                ->select('t1.*')
                ->first();

            // foreach ($user_rows as $key => $user) {
            //     $userId = $user->userId;
            //     $user_invest_data = $investmentModel->getUserInvestData($userId);
            //     if ($user_invest_data) {
            //         $depositId = $user_invest_data->depositId;
            //         $package_amount = $user_invest_data->amount;
            //         $roi_amount = $user_invest_data->amount * 1 * ($percent * 1 / 100);

            //         $newInvestAmount = $user_invest_data->income_amount * 1 + $roi_amount * 1;
            //         $newInvestPercent = $user_invest_data->income_percent * 1 + $percent * 1;
            //         $userTargetInvest = $user_invest_data->amount * 1 * 4.5;

            //         $beforeUserWalletBalance = Member_wallet_balance::where('userId', $userId)->first();

            //         if ($newInvestAmount * 1 < $userTargetInvest * 1) {
            //             Member_investment_list::where('userId', $userId)
            //                 ->where('id', $user_invest_data->id)
            //                 ->update([
            //                     'income_amount' =>  $newInvestAmount,
            //                     'income_percent' =>  $newInvestPercent,
            //                 ]);

            //             $added_income = $beforeUserWalletBalance->income_amount * 1 + $roi_amount * 1;
            //             Member_wallet_balance::where('userId', $userId)
            //                 ->update([
            //                     'income_amount' =>  $added_income,
            //                 ]);

            //             $new_member_roi = new Member_roi_list;
            //             $new_member_roi->userId =  $userId;
            //             $new_member_roi->depositId =  $depositId;
            //             $new_member_roi->package_amount =  $package_amount;
            //             $new_member_roi->roi_amount =  $roi_amount;
            //             $new_member_roi->percent =  $percent;
            //             $new_member_roi->save();
            //         } else {
            //             $add_roi_amount = $userTargetInvest * 1 - $user_invest_data->income_amount * 1;
            //             $new_wallet_income = $beforeUserWalletBalance->income_amount * 1 + $add_roi_amount * 1;

            //             Member_investment_list::where('userId', $userId)
            //                 ->where('id', $user_invest_data->id)
            //                 ->update([
            //                     'income_amount' =>  $userTargetInvest,
            //                     'income_percent' =>  450,
            //                     'invest_status' =>  1,
            //                 ]);

            //             Member_wallet_balance::where('userId', $userId)
            //                 ->update([
            //                     'income_amount' =>  $new_wallet_income,
            //                 ]);

            //             $adminUserId = $admin_wallet_balance->userId;
            //             $extraAmount = $newInvestAmount * 1 - $userTargetInvest * 1;
            //             $new_admin_income_amount = $admin_wallet_balance->income_amount * 1 + $extraAmount * 1;
            //             Member_wallet_balance::where('userId', $adminUserId)
            //                 ->update([
            //                     'income_amount' =>  $new_admin_income_amount,
            //                 ]);

            //             $new_member_roi = new Member_roi_list;
            //             $new_member_roi->userId =  $userId;
            //             $new_member_roi->depositId =  $depositId;
            //             $new_member_roi->package_amount =  $package_amount;
            //             $new_member_roi->roi_amount =  $add_roi_amount;
            //             $new_member_roi->percent =  $percent;
            //             $new_member_roi->save();
            //         }
            //     }
            // }
            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }
}
