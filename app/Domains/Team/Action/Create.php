<?php declare(strict_types=1);

namespace App\Domains\Team\Action;

use App\Domains\Team\Model\Team as Model;
use App\Exceptions\ValidatorException;

class Create extends ActionAbstract
{
    /**
     * @return \App\Domains\Team\Model\Team
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['code'] = str_slug($this->data['name']);
        $this->data['name'] = trim($this->data['name']);
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkCode();
        $this->checkName();
    }

    /**
     * @return void
     */
    protected function checkCode(): void
    {
        if (Model::byCode($this->data['code'])->count()) {
            throw new ValidatorException(__('team-create.error.code-exists'));
        }
    }

    /**
     * @return void
     */
    protected function checkName(): void
    {
        if (Model::byName($this->data['name'])->count()) {
            throw new ValidatorException(__('team-create.error.name-exists'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::create([
            'code' => $this->data['code'],
            'name' => $this->data['name'],
            'color' => $this->data['color'],
            'default' => $this->data['default'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
