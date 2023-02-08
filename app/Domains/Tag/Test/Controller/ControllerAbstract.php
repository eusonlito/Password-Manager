<?php declare(strict_types=1);

namespace App\Domains\Tag\Test\Controller;

use App\Domains\Shared\Test\Feature\FeatureAbstract;
use App\Domains\Tag\Model\Tag as Model;

abstract class ControllerAbstract extends FeatureAbstract
{
    /**
     * @return \App\Domains\Tag\Model\Tag
     */
    protected function rowCreate(): Model
    {
        return $this->factoryCreate(Model::class);
    }
}
