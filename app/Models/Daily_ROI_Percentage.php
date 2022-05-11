<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily_ROI_Percentage extends Model
{
    use HasFactory;
    protected $table = 'daily_roi_percentage';
    protected $fillable = [
        'percent',
    ];
}
