<?php

namespace App\Domains\User\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['firstName', 'lastName', 'email'];
}
