<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\Member_referral_list;

// class DirectIncomeController extends Controller
// {
//     public function index()
//     {
//         $user = Session::get('user');   // Session User Data
//         $userId = $user->userId;

//         $datas = Member_referral_list::where('otherUserId', $userId)->get()->toarray();
//         return view('pages.income.direct')->with(['datas' => $datas]);
//     }
// }
