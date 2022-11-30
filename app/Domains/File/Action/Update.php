<?php declare(strict_types=1);

namespace App\Domains\File\Action;

use App\Domains\File\Model\File as Model;

class Update extends ActionAbstract
{
    /**
     * @return \App\Domains\File\Model\File
     */
    public function handle(): Model
    {
        $this->data();
        $this->save();
        $this->log();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataName();
    }

    /**
     * @return void
     */
    protected function dataName(): void
    {
        $this->data['name'] = $this->data['file']->getClientOriginalName();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveFile();
        $this->saveRow();
    }

    /**
     * @return void
     */
    protected function saveFile(): void
    {
        Model::fileContentsSet($this->row->path, $this->data['file']->getContent());
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->save();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'file',
            'action' => 'update',
            'app_id' => $this->row->app->id,
            'file_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
