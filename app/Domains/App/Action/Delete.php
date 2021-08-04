<?php declare(strict_types=1);

namespace App\Domains\App\Action;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->save();
        $this->log();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->delete();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'app',
            'action' => 'delete',
            'payload' => $this->row->toArray(),
            'app_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
