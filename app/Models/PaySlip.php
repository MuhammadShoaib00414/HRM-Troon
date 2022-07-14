<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaySlip extends Model
{
    protected $fillable = [
        'employee_id',
        'net_payble',
        'basic_salary',
        'salary_month',
        'status',
        'allowance',
        'commission',
        'loan',
        'eobi',
        'tax',
        'provident',
        'saturation_deduction',
        'other_payment',
        'overtime',
        'created_by',
    ];

    protected $casts = [
        'allowance' => 'array',
        'loan' => 'array',
        'commission' => 'array',
        'overtime' => 'array',
        'other_payment' => 'array',
        'eobi' => 'array',
        'tax' => 'array',
        'provident' => 'array',
        'saturation_deduction' => 'array',
    ];

    public static function employee($id)
    {
        return Employee::find($id);
    }

    /**
     * Get the user that owns the phone.
     */
    public function employeeUser()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function employees()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }
}
