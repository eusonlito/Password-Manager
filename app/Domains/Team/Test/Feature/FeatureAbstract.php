<?php declare(strict_types=1);

namespace App\Domains\Team\Test\Feature;

use App\Domains\Shared\Test\Feature\FeatureAbstract as FeatureAbstractShared;
use App\Domains\Team\Model\Team as Model;

abstract class FeatureAbstract extends FeatureAbstractShared
{
    /**
     * @return \App\Domains\Team\Model\Team
     */
    protected function rowCreate(): Model
    {
        return $this->factoryCreate(Model::class);
    }
}
