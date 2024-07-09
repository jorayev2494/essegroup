<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Uuid as CurrencyUuid;
use Project\Domains\Admin\Language\Domain\Language\LanguageRepositoryInterface;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid as LanguageUuid;
use Project\Domains\Admin\University\Domain\Alias\AliasRepositoryInterface;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Uuid as AliasUuid;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Name\ValueObjects\Uuid as DepartmentNameUuid;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\DiscountPrice;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Price;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid as FacultyUuid;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid as UniversityUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid as DegreeUuid;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DegreeRepositoryInterface $degreeRepository,
        private DepartmentNameRepositoryInterface $nameRepository,
        private UniversityRepositoryInterface $universityRepository,
        private FacultyRepositoryInterface $facultyRepository,
        private DepartmentRepositoryInterface $departmentRepository,
        private AliasRepositoryInterface $aliasRepository,
        private LanguageRepositoryInterface $languageRepository,
        private CurrencyRepositoryInterface $currencyRepository,
        private TranslationColumnServiceInterface $translationService
    ) { }

    public function __invoke(Command $command): void
    {
        $department = $this->departmentRepository->findByUuid(Uuid::fromValue($command->uuid));

        $department ?? throw new ModelNotFoundException();

        $degree = $this->degreeRepository->findByUuid(DegreeUuid::fromValue($command->degreeUuid));
        $name = $this->nameRepository->findByUuid(DepartmentNameUuid::fromValue($command->nameUuid));
        $university = $this->universityRepository->findByUuid(UniversityUuid::fromValue($command->universityUuid));
        $faculty = $this->facultyRepository->findByUuid(FacultyUuid::fromValue($command->facultyUuid));
        $alias = $this->aliasRepository->findByUuid(AliasUuid::fromValue($command->aliasUuid));
        $language = $this->languageRepository->findByUuid(LanguageUuid::fromValue($command->languageUuid));
        $currency = $this->currencyRepository->findByUuid(CurrencyUuid::fromValue($command->priceCurrencyUuid));

        $department->changeName($name);
        $department->changeFaculty($faculty);
        $department->changeUniversity($university);
        $department->changeAlias($alias);
        $department->changeLanguage($language);
        $department->changeDegree($degree);
        $department->changePrice(Price::fromValue($command->price));
        $department->changeDiscountPrice(DiscountPrice::fromValue($command->discountPrice));
        $department->changePriceCurrency($currency);
        $department->changeIsFilled($command->isFilled);
        $department->setIsActive($command->isActive);

        $this->translationService->addTranslations($department, $command->translations);

        $this->departmentRepository->save($department);
    }
}
