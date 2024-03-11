<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Auth\Authenticatable;

class Client extends Authenticatable
{
    protected $connection = 'client_db';
}
