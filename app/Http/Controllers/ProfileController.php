<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\Member_wallet_balance;
use App\Models\Users_affiliate_structure;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;

        $userData = User::where('userId', $userId)->first();
        return view('profile.edit')->with(['userData' => $userData]);
    }

    public function memberprofile()
    {
        $datas = DB::table('users as t1')
            ->leftJoin('member_wallet_balances as t2', 't1.userId', '=', 't2.userId')
            ->where('t1.role', 'user')
            ->select('t1.*', 't2.cash_balance', 't2.income_amount')
            ->get()
            ->toArray();
        
        return view('profile.member')->with(['datas' => $datas]);
    }

    public function initializePWD(Request $request)
    {
        try {
            $userId = $request->userId;

            $new_pwd = Hash::make($userId);
            User::where('userId', $userId)
                ->update([
                    'password' =>  $new_pwd,
                    'pwd' =>  $userId,
                ]);
            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }


    public function deleteUser(Request $request)
    {
        try {
            $userId = $request->userId;

            User::where('userId', $userId)->delete();
            Member_wallet_balance::where('userId', $userId)->delete();
            Users_affiliate_structure::where('userId', $userId)->delete();
            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }

    public function upload(Request $req)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        // $req->validate([
        //     'file' => 'required|mimes:jpg,png,csv,txt,xlx,xls,pdf|max:2048'
        // ]);
        if ($req->file()) {
            $fileName = time() . '_' . $req->file->getClientOriginalName();
            $req->file->move(public_path('avatar'), $fileName);
            $filePath = $fileName;
            // $filePath = $req->file('file')->storeAs($path, $fileName, 'public');
            User::where('userId', $userId)
                ->update([
                    'imgUrl' => $filePath,
                ]);
            return back()
                ->with('success', 'Image has been uploaded!')
                ->with('file', $fileName);
        }
    }

    public function changeUserInfo(Request $request)
    {
        try {
            $user = Session::get('user');   // Session User Data
            $userId = $user->userId;

            $name = $request->name;
            $email = $request->email;
            $phone = $request->phone;

            User::where('userId', $userId)
                ->update([
                    'name' =>  $name,
                    'email' =>  $email,
                    'phone' =>  $phone,
                ]);
            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }

    public function changePwd(Request $request)
    {
        try {
            $user = Session::get('user');   // Session User Data
            $userId = $user->userId;
            $user_old_pass = $user->password;

            $old_pass = $request->old_pass;
            $new_pass = $request->new_pass;

            $check_result = Hash::check($old_pass, $user_old_pass);
            if ($check_result == true) {
                $new_pwd = Hash::make($new_pass);
                User::where('userId', $userId)
                    ->update([
                        'password' =>  $new_pwd,
                    ]);
                return response()->json(['status' => 200]);
            } else {
                return response()->json(['status' => 401]);
            }
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 404, 'error' => $error]);
        }
    }


    public function changeWalletAddress(Request $request)
    {
        try {
            $user = Session::get('user');   // Session User Data
            $userId = $user->userId;

            $wallet_address = $request->wallet_address;

            User::where('userId', $userId)
                ->update([
                    'wallet_address' =>  $wallet_address,
                ]);
            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return response()->json(['status' => 400, 'error' => $error]);
        }
    }
}
