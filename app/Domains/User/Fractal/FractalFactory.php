<?php declare(strict_types=1);

namespace App\Domains\User\Fractal;

use App\Domains\Shared\Fractal\FractalAbstract;
use App\Domains\User\Model\User as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\User\Model\User $row
     *
     * @return array
     */
    protected function api(Model $row): array
    {
        return $row->only('id', 'name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled');
    }

    /**
     * @param \App\Domains\User\Model\User $row
     *
     * @return array
     */
    protected function apiDetail(Model $row): array
    {
        return $row->only('id', 'name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled') + [
            'apps' => $this->from('App', 'api', $row->apps),
            'teams' => $this->from('Team', 'simple', $row->teams),
        ];
    }

    /**
     * @param \App\Domains\User\Model\User $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return $row->only('id', 'name', 'email', 'admin', 'readonly', 'enabled');
    }
}
