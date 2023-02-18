<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use Illuminate\Support\Collection;
use App\Domains\App\Model\App as Model;

class Search extends ActionAbstract
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $list;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function handle(): Collection
    {
        if (str_starts_with($this->data['q'], 'http')) {
            return $this->searchUrl();
        }

        $this->list();
        $this->log();

        return $this->list;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function searchUrl(): Collection
    {
        return $this->factory()->action(['url' => $this->data['q']])->searchUrl();
    }

    /**
     * @return void
     */
    protected function list(): void
    {
        $this->list = Model::byUserAllowed($this->auth)
            ->byType('website')
            ->whereArchived(false)
            ->search($this->data['q'])
            ->orderByName()
            ->limit(10)
            ->get();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'app',
            'action' => 'search',
            'payload' => $this->data,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
