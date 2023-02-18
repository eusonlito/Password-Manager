<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use Illuminate\Support\Collection;
use App\Domains\App\Model\App as Model;
use App\Exceptions\UnexpectedValueException;

class SearchUrl extends ActionAbstract
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
        $this->data();
        $this->check();
        $this->list();
        $this->log();

        return $this->list;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['host'] = str_replace('www.', '', (string)parse_url($this->data['url'], PHP_URL_HOST));
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (empty($this->data['host'])) {
            throw new UnexpectedValueException(__('app-api.error.host-invalid'));
        }
    }

    /**
     * @return void
     */
    protected function list(): void
    {
        $this->list = Model::byUserAllowed($this->auth)
            ->byType('website')
            ->whereArchived(false)
            ->get()
            ->filter(fn ($value) => $this->listFilter($value));
    }

    /**
     * @param \App\Domains\App\Model\App $row
     *
     * @return bool
     */
    protected function listFilter(Model $row): bool
    {
        return str_contains(str_replace('www.', '', $row->payload('url')), $this->data['host']);
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'app',
            'action' => 'search-url',
            'payload' => $this->data,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
