<?php declare(strict_types = 1);

namespace App\Domains\Shared\Test\Feature;

use App\Domains\Shared\Test\TestAbstract;
use App\Domains\User\Model\User as UserModel;

abstract class FeatureAbstract extends TestAbstract
{
    /**
     * @var string
     */
    protected string $route;

    /**
     * @var string
     */
    protected string $action;

    /**
     * @param string $name = ''
     * @param mixed ...$params
     *
     * @return string
     */
    protected function route(string $name = '', ...$params): string
    {
        return (string)route($this->route.($name ? ('.'.$name) : ''), $params);
    }

    /**
     * @param string $name = ''
     *
     * @return array
     */
    protected function action(string $name = ''): array
    {
        return ['_action' => $name ?: $this->action];
    }

    /**
     * @param bool $confirm
     * @param \App\Domains\User\Model\User $user = null
     *
     * @return void
     */
    protected function userConfirm(bool $confirm, UserModel $user = null): void
    {
        $user = $user ?: $this->user();
        $user->confirmed_at = $confirm ? date('Y-m-d H:i:s') : null;
        $user->save();
    }
}
