<?php declare(strict_types=1);

namespace App\Domains\Tag\Test\Controller;

use App\Domains\Shared\Test\Feature\FeatureAbstractTestCase;
use App\Domains\Tag\Model\Tag as Model;

abstract class ControllerAbstractTestCase extends FeatureAbstractTestCase
{
    /**
     * @return \App\Domains\Tag\Model\Tag
     */
    protected function rowCreate(): Model
    {
        return $this->factoryCreate(Model::class);
    }
}
