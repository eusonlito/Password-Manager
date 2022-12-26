<?php declare(strict_types=1);

namespace App\Domains\Tag\Test\Feature;

use App\Domains\Shared\Test\Feature\FeatureAbstract as FeatureAbstractShared;
use App\Domains\Tag\Model\Tag as Model;

abstract class FeatureAbstract extends FeatureAbstractShared
{
    /**
     * @return \App\Domains\Tag\Model\Tag
     */
    protected function rowCreate(): Model
    {
        return $this->factoryCreate(Model::class);
    }
}
