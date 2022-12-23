<?php declare(strict_types=1);

namespace App\Domains\File\Action;

use App\Domains\App\Model\App as AppModel;
use App\Domains\File\Model\File as Model;

class Create extends ActionAbstract
{
    /**
     * @var \App\Domains\App\Model\App
     */
    protected AppModel $app;

    /**
     * @return \App\Domains\File\Model\File
     */
    public function handle(): Model
    {
        $this->app();
        $this->data();
        $this->save();
        $this->log();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function app(): void
    {
        $this->app = AppModel::byId($this->data['app_id'])
            ->byUserAllowed($this->auth)
            ->firstOrFail();
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataName();
        $this->dataPath();
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
    protected function dataPath(): void
    {
        $this->data['path'] = $this->app->id.'/'.helper()->uniqidReal(48);
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
        Model::fileContentsSet($this->data['path'], $this->data['file']->getContent());
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row = Model::create([
            'name' => $this->data['name'],
            'path' => $this->data['path'],
            'app_id' => $this->app->id,
        ]);
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'file',
            'action' => 'create',
            'app_id' => $this->app->id,
            'file_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
