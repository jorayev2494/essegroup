<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Auth;

use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthManager
{
    public static function getCompanyUuid(): ?string
    {
        return JWTAuth::parseToken()->getPayload()->get('company_uuid');
    }

    public static function getCompany(): ?Company
    {
        return app()->make(CompanyRepositoryInterface::class)
            ->findByUuid(Uuid::fromValue(self::getCompanyUuid()));
    }
}
