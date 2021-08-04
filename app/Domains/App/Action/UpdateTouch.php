<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use App\Domains\App\Model\App as Model;

class UpdateTouch extends ActionAbstract
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
        $this->row->updated_at = date('Y-m-d H:i:s');
        $this->row->save();
    }
}
