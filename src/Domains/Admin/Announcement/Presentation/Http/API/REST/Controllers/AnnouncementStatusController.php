<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\ForItemEnum;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class AnnouncementStatusController
{
    public function __construct(
        private ResponseFactory $response
    ) { }

    public function list(): JsonResponse
    {
        $result = [];

        foreach (ForItemEnum::cases() as $case) {
            $result[] = [
                'label' => $case->value,
                'value' => $case->value,
            ];
        }

        return $this->response->json($result);
    }
}
