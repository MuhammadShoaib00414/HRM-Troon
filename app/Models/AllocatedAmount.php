<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocatedAmount extends Model
{
    protected $fillable = [
        'set_total_opd',
        'set_total_employee_opd',
        'year',
        'created_by',
    ];

}
