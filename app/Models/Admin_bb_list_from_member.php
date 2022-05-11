<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_bb_list_from_member extends Model
{
    use HasFactory;
    protected $table = 'admin_bb_list_from_member';
    protected $fillable = [
        'memberId',
        'amount',
        'investMember',
        'investAmount',
        'flag',
    ];
}
