<?php

namespace phpunit\Unit\Filter\FilterType;

use Lle\CruditBundle\Filter\FilterType\EntityFilterType;
use PHPUnit\Framework\TestCase;

class EntityFilterTypeTest extends TestCase
{

    public function testDataRoute(): void
    {
        $filterType = EntityFilterType::new('test', 'App\\Entity\\Test');
        self::assertEquals('app_crudit_test_autocomplete', $filterType->getDataRoute());
    }

    public function testCustomRoute(): void
    {
        $dataRoute = 'lle_hermes_test_autocomplete';
        $filterType = EntityFilterType::new('test', 'App\\Entity\\Test', $dataRoute);
        self::assertEquals($dataRoute, $filterType->getDataRoute());
    }
}
