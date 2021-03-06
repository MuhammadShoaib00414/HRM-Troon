<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provident extends Model
{
    protected $fillable = [
        'employee_id',
        'employee_amount',
        'employee_date',
        'employer_amout',
        'employer_date',
        'created_by',
    ];

    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id')->first();
    }
}
