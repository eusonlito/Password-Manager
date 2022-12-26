<?php declare(strict_types=1);

namespace App\Domains\Team\Action;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->delete();
        $this->log();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->row->delete();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'team',
            'action' => 'delete',
            'payload' => $this->row->only('id', 'name', 'created_at'),
            'team_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
