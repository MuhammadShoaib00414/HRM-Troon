<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttandanceData extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'username',
        'uid',
        'status',
        'check_in',
        'check_out',
        'date',
        'late',
        'early_leaving',
        'overtime',
        'created_by',
        'created_at',
    ];
}
