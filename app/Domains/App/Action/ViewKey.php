<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use App\Domains\App\Model\App as Model;

class ViewKey extends ActionAbstract
{
    /**
     * @return \App\Domains\App\Model\App
     */
    public function handle(): Model
    {
        $this->save();
        $this->log();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        Model::where('id', $this->row->id)->update(['updated_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'app',
            'action' => 'view-key',
            'payload' => ['key' => $this->data['key']],
            'app_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
