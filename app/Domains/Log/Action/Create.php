<?php declare(strict_types=1);

namespace App\Domains\Log\Action;

use App\Domains\Log\Model\Log as Model;

class Create extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->store();
    }

    /**
     * @return void
     */
    protected function store(): void
    {
        Model::insert($this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return [
            'table' => $this->data['table'],
            'action' => $this->data['action'],
            'payload' => helper()->jsonEncode($this->data['payload']),
            'user_from_id' => $this->data['user_from_id'],
        ] + array_filter(array_map('intval', $this->data));
    }
}
