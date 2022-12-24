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
     * @return \App\Domains\Tag\Model\Tag
     */
    public function create(): Model
    {
        return $this->actionHandle(Create::class, $this->validate()->create());
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandle(Delete::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOrCreate(): Collection
    {
        return $this->actionHandle(GetOrCreate::class, $this->validate()->getOrCreate());
    }

    /**
     * @return \App\Domains\Tag\Model\Tag
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }
}
