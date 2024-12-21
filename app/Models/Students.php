<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Students extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'address',
        'dept_id'
    ];


    public function department(): BelongsTo
    {
        return $this->belongsTo(Departments::class, 'dept_id', 'id');
    }
}
