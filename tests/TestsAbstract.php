<?php declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestsAbstract extends TestCase
{
    use RefreshDatabase;

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function authAdmin(): Authenticatable
    {
        $user = $this->user();
        $user->admin = 1;
        $user->save();

        $this->auth($user);

        return $user;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function authNotAdmin(): Authenticatable
    {
        $user = $this->user();
        $user->admin = 0;
        $user->save();

        $this->auth($user);

        return $user;
    }
}
