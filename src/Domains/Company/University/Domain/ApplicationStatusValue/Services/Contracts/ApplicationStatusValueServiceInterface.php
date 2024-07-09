<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Domain\ApplicationStatusValue\Services\Contracts;

use Project\Domains\Company\University\Application\ApplicationStatusValue\Queries\List\Query as ListQuery;
use Project\Domains\Company\University\Application\ApplicationStatusValue\Queries\WidgetList\Query as WidgetListQuery;

interface ApplicationStatusValueServiceInterface
{
    public function list(ListQuery $httpQuery): array;

    public function widgetList(WidgetListQuery $httpQuery): array;
}
