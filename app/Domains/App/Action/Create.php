<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use App\Domains\App\Model\App as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::create([
            'type' => $this->data['type'],
            'name' => $this->data['name'],
            'shared' => $this->data['shared'],
            'editable' => $this->data['editable'],
            'archived' => $this->data['archived'],
            'payload' => $this->data['payload'],

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'user_id' => $this->auth->id,
        ]);
    }
}
