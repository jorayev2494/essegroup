<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\Company\Domain\Employee\Employee;
use Project\Domains\Admin\Company\Domain\Employee\EmployeeRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Uuid as EmployeeUuid;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid as ManagerUuid;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Project\Shared\Domain\ValueObject\UuidValueObject;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthManager
{
    public static function uuid(GuardType $guard): UuidValueObject
    {
        return UuidValueObject::fromValue(Auth::guard($guard->value)->id());
    }

    public static function companyUuid(): ?UuidValueObject
    {
        return UuidValueObject::fromValue(JWTAuth::parseToken()->getPayload()->get('company_uuid'));
    }

    public static function company(): ?Company
    {
        return app()->make(CompanyRepositoryInterface::class)
            ->findByUuid(Uuid::fromValue(self::companyUuid()));
    }

    public static function hasCompany(): bool
    {
        return JWTAuth::parseToken()->getPayload()->get('company_uuid') !== null;
    }

    public static function employee(): ?Employee
    {
        /** @var EmployeeRepositoryInterface $employeeRepository */
        $employeeRepository = app()->make(EmployeeRepositoryInterface::class);

        return $employeeRepository->findByUuid(EmployeeUuid::fromValue(self::uuid(GuardType::COMPANY)->value));
    }

    public static function manager(): ?Manager
    {
        /** @var ManagerRepositoryInterface $managerRepository */
        $managerRepository = app()->make(ManagerRepositoryInterface::class);

        return $managerRepository->findByUuid(ManagerUuid::fromValue(self::uuid(GuardType::MANAGER)->value));
    }
}
