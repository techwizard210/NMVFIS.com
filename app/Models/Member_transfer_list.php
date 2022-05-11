<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member_transfer_list extends Model
{
    use HasFactory;
    protected $table = 'member_transfer_lists';
    protected $fillable = [
        'userId',
        'otherUserId',
        'amount',
    ];
}
