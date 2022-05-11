<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Users_affiliate_structure extends Model
{
    use HasFactory;
    protected $table = 'users_affiliate_structures';
    protected $fillable = [
        'userId',
        'leftUser',
        'leftside_funds',
        'rightUser',
        'rightside_funds',
    ];

    public function getAllUsersAffiliate()
    {
        $datas = DB::table('users_affiliate_structures as t1')
            ->leftJoin('users as t2', 't2.userId', '=', 't1.userId')
            ->select('t1.*', 't2.name', 't2.rank')
            ->get();

        return $datas;
    }
}
