<?php declare(strict_types=1);

namespace App\Domains\User\Test\ControllerApi;

use App\Domains\User\Model\User as Model;

class Index extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.api.index';

    /**
     * @return void
     */
    public function testGetFail(): void
    {
        $this->authUserAdmin();

        $this->get($this->route(), $this->apiAuthorization())
            ->assertStatus(405);

        $this->getJson($this->route(), $this->apiAuthorization())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->postJsonAuthorized($this->route(), $this->factoryWhitelist(Model::class, ['email', 'password', 'password_enabled'], false))
            ->assertStatus(401);

        $this->postJsonAuthorized($this->route(), $this->factoryWhitelist(Model::class, ['name', 'password', 'password_enabled'], false))
            ->assertStatus(401);
    }

    /**
     * @return void
     */
    public function testPostUserUnauthorizedFail(): void
    {
        $this->authUser();

        $this->postJsonAuthorized($this->route(), $this->factoryWhitelist(Model::class, ['email', 'password', 'password_enabled'], false))
            ->assertStatus(401);

        $this->postJsonAuthorized($this->route(), $this->factoryWhitelist(Model::class, ['name', 'password', 'password_enabled'], false))
            ->assertStatus(401);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $auth = $this->authUserAdmin();

        $json = [$auth->only('id', 'name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled')];

        $this->postJsonAuthorized($this->route())
            ->assertStatus(200)
            ->assertExactJson($json);

        $row = $this->factoryCreate(Model::class);
        $row->name = 'ZZ'.$row['name'];
        $row->save();

        $json[] = $row->only('id', 'name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled');

        $this->postJsonAuthorized($this->route())
            ->assertStatus(200)
            ->assertExactJson($json);
    }
}
