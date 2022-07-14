<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPDPayment extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'amount',
        'date',
        'description',
        'attachment',
        'created_by',
    ];

    public function employee()
    {
        return $this->hasMany('App\Models\Employee', 'id', 'employee_id')->first();
    }
}
