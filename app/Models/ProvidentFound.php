<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvidentFound extends Model
{
    protected $fillable = [
        'employee_id',
        'employee_name',
        'employee_amount',
        'employee_date',
        'employer_amout',
        'employer_date',
        'note',

        'created_by',
    ];

    public function employee()
    {
        return $this->hasMany('App\Models\Employee', 'id', 'employee_id')->first();
    }
}
