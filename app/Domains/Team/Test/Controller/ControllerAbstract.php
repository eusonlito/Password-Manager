<?php declare(strict_types=1);

namespace App\Domains\Team\Test\Controller;

use App\Domains\Shared\Test\Feature\FeatureAbstract;
use App\Domains\Team\Model\Team as Model;

abstract class ControllerAbstract extends FeatureAbstract
{
    /**
     * @return \App\Domains\Team\Model\Team
     */
    protected function rowCreate(): Model
    {
        return $this->factoryCreate(Model::class);
    }
}
