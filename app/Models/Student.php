<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Auth\Authenticatable;

class Student extends Authenticatable
{
    protected $table = 'student_students';

    protected $connection = 'admin_db';
}
