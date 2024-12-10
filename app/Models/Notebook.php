<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notebook extends Model
{
    protected $table = 'notebook';
    //
    protected $fillable = [
        'fullname',
        'company',
        'phone',
        'email',
        'birthdate',
        'photo',
    ];
}
