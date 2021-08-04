<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use App\Domains\App\Model\App as Model;

class View extends ActionAbstract
{
    /**
     * @return \App\Domains\App\Model\App
     */
    public function handle(): Model
    {
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->factory('Log')->action([
            'table' => 'app',
            'action' => 'view',
            'app_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
