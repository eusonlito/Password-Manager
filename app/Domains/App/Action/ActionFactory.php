<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use Illuminate\Support\Collection;
use App\Domains\App\Model\App as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\App\Model\App
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\App\Model\App
     */
    public function create(): Model
    {
        return $this->actionHandleTransaction(Create::class, $this->validate()->create());
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandle(Delete::class);
    }

    /**
     * @return string
     */
    public function export(): string
    {
        return $this->actionHandle(Export::class, $this->validate()->export());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function search(): Collection
    {
        return $this->actionHandle(Search::class, $this->validate()->search());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function searchUrl(): Collection
    {
        return $this->actionHandle(SearchUrl::class, $this->validate()->searchUrl());
    }

    /**
     * @return \App\Domains\App\Model\App
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\App\Model\App
     */
    public function view(): Model
    {
        return $this->actionHandle(View::class);
    }

    /**
     * @return \App\Domains\App\Model\App
     */
    public function viewKey(): Model
    {
        return $this->actionHandle(ViewKey::class, $this->validate()->viewKey());
    }
}
