<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Auth\Authenticatable;

class Employee extends Authenticatable
{
    protected $table = 'company_employees';

    protected $connection = 'admin_db';
}
