<?php

declare(strict_types=1);

namespace App\Http\Controllers\Preview\PDF;

use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

readonly class StudentController
{
    public function __construct(
        private ResponseFactory $response
    ) { }

    public function preview(): Response
    {
        $data = [
            'user_info' => [
                'name_and_surname' => 'ALEX PETROV',
                'birthday' => 'birthday',
                'email' => 'student@gmail.com',
                'nationality' => 'Turkmenistan',
                'passport_number' => 'A12345678',
                'date_of_issue' => '12.05.2024',
                'date_of_expiry' => '12.05.2024',
                'phone' => '+12345678',
                'friend_phone' => '+1234567890',
                'country_of_residence' => 'Turkmenistan',
                'home_address' => 'Home address, Turkmenistan, Ahal, Buzmeyin, 20/4',
                'gender' => 'Male',
                'marital_type' => 'Single',
                'father_name' => 'Father name',
                'mother_name' => 'Mother name',
                'high_school_country_uuid' => 'Turkmenistan',
                'high_school_name' => '30 orta mekdebi',
                'high_school_grade_average' => '15.5',
            ]
        ];

        return  $this->response->view('pdfs.preview.student.invoice', compact('data'));
    }
}
