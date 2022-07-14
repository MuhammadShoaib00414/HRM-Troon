<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EOBI extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'employee_amount',
        'employer_amount',
        'eobi_date',
        'created_by',
    ];

    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id')->first();
    }
}
