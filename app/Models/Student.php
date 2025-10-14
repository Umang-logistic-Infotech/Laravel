<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    // For hiding columns
    // protected $hidden = [
    //     'studentName'
    // ];

    public function scopeMale($query)
    {
        return $query->where('gender', 'male');
    }
}
