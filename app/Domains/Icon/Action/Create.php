<?php declare(strict_types=1);

namespace App\Domains\Icon\Action;

use App\Domains\Icon\Model\Icon as Model;
use App\Domains\App\Service\Icon\Image;
use App\Exceptions\ValidatorException;

class Create extends ActionAbstract
{
    /**
     * @return \App\Domains\Icon\Model\Icon
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();
        $this->row();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataPublic();
        $this->dataFile();
    }

    /**
     * @return void
     */
    protected function dataPublic(): void
    {
        $this->data['public'] = Model::publicByName($this->data['name']);
    }

    /**
     * @return void
     */
    protected function dataFile(): void
    {
        $this->data['file'] = Model::fileByName($this->data['name']);
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (is_file($this->data['file'])) {
            throw new ValidatorException(__('icon-create.error.name-exists'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        Image::save($this->data['file'], $this->data['icon']->get());
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::byFile($this->data['file']);
    }
}
