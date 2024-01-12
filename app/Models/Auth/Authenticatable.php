<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Authenticatable extends JWTAuthenticatable
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'uuid';

    protected $table = 'auth_members';

    public $timestamps = false;

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
