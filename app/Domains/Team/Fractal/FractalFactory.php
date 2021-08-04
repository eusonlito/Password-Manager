<?php declare(strict_types=1);

namespace App\Domains\Team\Fractal;

use App\Domains\Shared\Fractal\FractalAbstract;
use App\Domains\Team\Model\Team as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Team\Model\Team $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return $row->only('id', 'code', 'name', 'default');
    }
}
