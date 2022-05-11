<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member_investforother_list extends Model
{
    use HasFactory;
    protected $table = 'member_investforother_lists';
    protected $fillable = [
        'userId',
        'otherUserId',
        'amount',
        'package',
    ];
}
