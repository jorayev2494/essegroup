<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Auth\Authenticatable;

class Company extends Authenticatable
{
    protected $connection = 'company_db';
}
