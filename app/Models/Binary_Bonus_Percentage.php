<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binary_Bonus_Percentage extends Model
{
    use HasFactory;
    protected $table = 'binary_bonus_percentage';
    protected $fillable = [
        'percent',
    ];
}
