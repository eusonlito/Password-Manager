<?php declare(strict_types=1);

namespace App\Domains\Team\Action;

use App\Domains\Team\Model\Team as Model;

class UpdateBoolean extends ActionAbstract
{
    /**
     * @return \App\Domains\Team\Model\Team
     */
    public function handle(): Model
    {
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['value'] = !$this->row->{$this->data['column']};
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->{$this->data['column']} = $this->data['value'];
        $this->row->save();
    }
}
