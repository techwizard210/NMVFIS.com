<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direct_Referral_Percentage extends Model
{
    use HasFactory;
    protected $table = 'direct_referral_percentage';
    protected $fillable = [
        'percent',
    ];
}
