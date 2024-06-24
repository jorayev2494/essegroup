<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Infrastructure\Mails\Employee;

use Project\Infrastructure\Services\Mailer\Contracts\MailMessageInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;

readonly class EmployeeCreatedMailMessage extends MailMessageInterface
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $password
    )
    {
        // parent::__construct();
    }

    protected function build(Email $message): void
    {
        $template = view('mails.company.employee.created', [
            'dashboardLink' => $this->makeDashboardLink(),
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
        ])->render();

        $message
            ->to($this->email)
            ->subject('Time for Symfony Mailer!')
            ->html($template);

        // return $message;
    }

    private static function makeDashboardLink(): string
    {
        return config('company_dashboard.url') . config('company_dashboard.page_routers.login');
    }
}
