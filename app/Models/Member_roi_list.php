<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Member_roi_list extends Model
{
    use HasFactory;

    protected $table = 'member_roi_lists';
    protected $fillable = [
        'userId',
        'depositId',
        'package_amount',
        'roi_amount',
        'percent',
        'created_at',
        'updated_at',
    ];

    public function getUserRoiData($userId)
    {
        $userRoiDatas = DB::table('member_roi_lists')
            ->where([
                'userId' => $userId,
            ])
            // ->orderBy('menu_sort', 'ASC')
            ->get();

        return $userRoiDatas;
    }
}
