<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Member_binarybonus_list extends Model
{
    use HasFactory;
    protected $table = 'member_binarybonus_lists';
    protected $fillable = [
        'userId',
        'bonus',
        'lap_amount',
        'left_bv',
        'right_bv',
        'carry_left_bv',
        'carry_right_bv',
    ];

    public function create($data)
    {
        return Member_binarybonus_list::create([
            'userId' => $data['userId'],
            'bonus' => $data['bonus'],
            'lap_amount' => $data['amount'],
            'left_bv' => $data['leftside_funds'],
            'right_bv' => $data['rightside_funds'],
            'carry_left_bv' => '',
            'carry_right_bv' => '',
        ]);
    }

    public function getUserBinaryData($userId)
    {
        $datas = DB::table('member_binarybonus_lists')
            ->where('userId', $userId)
            ->where('bonus', '>', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $datas;
    }
}
