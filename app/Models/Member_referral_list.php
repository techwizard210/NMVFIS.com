<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Member_referral_list extends Model
{
    use HasFactory;
    protected $table = 'member_referral_lists';
    protected $fillable = [
        'userId',
        'otherUserId',
        'depositId',
        'amount',
    ];

    public function create($referral_amount)
    {
        $user = Session::get('user');   // Session User Data
        $userId = $user->userId;
        $sponsorId = $user->sponsorId;

        return Member_referral_list::create([
            'userId' => $userId,
            'otherUserId' => $sponsorId,
            'amount' => $referral_amount,
        ]);
    }
}
