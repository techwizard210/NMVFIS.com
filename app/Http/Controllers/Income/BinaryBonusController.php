<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\Member_binarybonus_list;
use App\Models\Binary_Bonus_Percentage;

class BinaryBonusController extends Controller
{
    public function index()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $binaryBonusModel = new Member_binarybonus_list();
        $getUserBinaryData = $binaryBonusModel->getUserBinaryData($userId);
        $userBinaryBonus = $getUserBinaryData->toArray();
        // dump($userBinaryBonus);exit;
        return view('pages.income.binary')->with(['userBinaryBonus' => $userBinaryBonus]);
    }


    // public function setNewPercentage(Request $request)
    // {
    //     $percent = $request->percent;

    //     try {
    //         $check = Binary_Bonus_Percentage::where('created_at', date('Y-m-d'))->first();
    //         if ($check) {
    //             Binary_Bonus_Percentage::where('created_at', date('Y-m-d'))
    //                 ->update([
    //                     'percent' =>  $percent,
    //                 ]);
    //         } else {
    //             $binaryBonusModel = new Binary_Bonus_Percentage();
    //             $binaryBonusModel->percent =  $percent;
    //             $binaryBonusModel->save();
    //         }
    //         return response()->json(['status' => 200]);
    //     } catch (\Exception $e) {
    //         $error = 'Error: ' . $e->getMessage();
    //         return response()->json(['status' => 400, 'error' => $error]);
    //     }
    // }
}
