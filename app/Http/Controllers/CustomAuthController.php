<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Users_affiliate_structure;
use App\Models\Member_wallet_balance;
use Symfony\Component\Console\Input\Input;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'userId' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('userId', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::User();
            Session::put('user', $user);
            return redirect(route('dashboard'))->withSuccess('Signed in');
        }
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        $randomId = uniqid();
        $userId = strtoupper(substr($randomId, -9));
        return view('auth.register')->with([
            'userId' => $userId,
            'referralStatus' => false,
        ]);
    }

    public function registrationwithlink($sponsorId, $position)
    {
        $randomId = uniqid();
        $userId = strtoupper(substr($randomId, -9));

        return view('auth.register')->with([
            'userId' => $userId,
            'sponsorId' => $sponsorId,
            'position' => $position,
            'referralStatus' => true,
        ]);
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $sponsorId = $data['sponsorId'];
        if ($sponsorId) {
            $this->newUser($data);
        } else {
            $this->newNetUser($data);
        }

        //Register new User in member_wallet_balances.
        Member_wallet_balance::create([
            'userId' => $data['userId'],
        ]);

        //Register new User in users_affiliate_structures.
        Users_affiliate_structure::create([
            'userId' => $data['userId'],
        ]);

        // //Register user's position
        // $position = $data['position'];
        // $sponsorId = $data['sponsorId'];

        // if ($position !== "none") {
        //     if ($position == "Left") {
        //         Users_affiliate_structure::where('userId', $sponsorId)
        //             ->update([
        //                 'leftUser' =>  $data['userId'],
        //             ]);
        //     } else if ($position == "Right") {
        //         Users_affiliate_structure::where('userId', $sponsorId)
        //             ->update([
        //                 'rightUser' =>  $data['userId'],
        //             ]);
        //     }
        // }

        return redirect("login")->withSuccess('You have signed-in');
    }

    public function newNetUser(array $data)
    {
        $networkId = $data['userId'];
        $order = 0;

        return User::create([
            'userId' => $data['userId'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => 'user',
            'networkId' => $networkId,
            'order' => $order,
            'wallet_address' => $data['wallet_address'],
            'password' => Hash::make($data['password']),
            'pwd' => $data['password'],
        ]);
    }

    public function findPlacementId($networkId, $placementId, $position)
    {
        global $g_placementId;

        $findChildData = User::where('networkId', $networkId)
            ->where('placementId', $placementId)
            ->where('position', $position)
            ->first();
        if ($findChildData) {
            $this->findPlacementId($networkId, $findChildData->userId, $position);
        } else {
            $g_placementId = $placementId;
            return;
        }
    }

    public function newUser(array $data)
    {
        global $g_placementId;
        $g_placementId = '';

        if ($data['position'] == 'Left') {
            $p_num = 1;
        } else {
            $p_num = 2;
        }
        //J E Left
        $sponsorId = $data['sponsorId'];
        $nidOfSponsor = User::where('userId', $sponsorId)->first()->networkId; //NetworkId of Sponsor

        $placementId = $this->findPlacementId($nidOfSponsor, $sponsorId, $data['position']);

        $placementUser = User::where('networkId', $nidOfSponsor)
            ->where('userId', $g_placementId)
            ->first();

        $order = $placementUser->order * 1 + 1;

        return User::create([
            'userId' => $data['userId'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'position' => $data['position'],
            'sponsorId' => $sponsorId,
            'placementId' => $g_placementId,
            'networkId' => $nidOfSponsor,
            'order' => $order,
            'p_num' => $p_num,
            'role' => 'user',
            'wallet_address' => $data['wallet_address'],
            'password' => Hash::make($data['password']),
            'pwd' => $data['password'],
        ]);
    }



    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function logOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
