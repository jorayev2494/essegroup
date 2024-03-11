<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Auth\Authenticatable;

class Admin extends Authenticatable
{
    protected $connection = 'admin_db';
}
