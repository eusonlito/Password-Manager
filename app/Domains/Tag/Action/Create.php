<?php declare(strict_types=1);

namespace App\Domains\Tag\Action;

use App\Domains\Tag\Model\Tag as Model;
use App\Exceptions\ValidatorException;

class Create extends ActionAbstract
{
    /**
     * @return \App\Domains\Tag\Model\Tag
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();
        $this->log();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['code'] = str_slug($this->data['name']);
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
            throw new ValidatorException(__('tag-create.error.code-exists'));
        }
    }

    /**
     * @return void
     */
    protected function checkName(): void
    {
        if (Model::byName($this->data['name'])->count()) {
            throw new ValidatorException(__('tag-create.error.name-exists'));
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
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'tag',
            'action' => 'create',
            'payload' => $this->row->only('id', 'name', 'created_at'),
            'tag_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
