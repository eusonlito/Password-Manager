<?php declare(strict_types=1);

namespace App\Domains\Tag\Action;

use Illuminate\Support\Collection;
use App\Domains\Tag\Model\Tag as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Tag\Model\Tag
     */
    protected ?Model $row;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOrCreate(): Collection
    {
        return $this->actionHandle(GetOrCreate::class, $this->validate()->getOrCreate());
    }
}
