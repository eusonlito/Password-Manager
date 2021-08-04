<?php declare(strict_types=1);

namespace App\Domains\App\Fractal;

use App\Domains\Shared\Fractal\FractalAbstract;
use App\Domains\App\Model\App as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\App\Model\App $row
     *
     * @return array
     */
    protected function api(Model $row): array
    {
        return $row->only('id', 'name');
    }
}
