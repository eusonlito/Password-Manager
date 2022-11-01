<?php declare(strict_types=1);

namespace App\Domains\Icon\Action;

use App\Domains\Icon\Model\Icon as Model;
use App\Domains\App\Service\Icon\Image;

class Update extends ActionAbstract
{
    /**
     * @return \App\Domains\Icon\Model\Icon
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
        Image::save($this->row->file, $this->data['icon']->get());
    }
}
