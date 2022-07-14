<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxDeduction extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'tax_amount',
        'tax_date',
        'created_by',
    ];

    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id')->first();
    }
}
