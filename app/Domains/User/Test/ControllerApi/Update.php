<?php declare(strict_types=1);

namespace App\Domains\User\Test\ControllerApi;

use App\Domains\User\Model\User as Model;

class Update extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.api.update';

    /**
     * @var array
     */
    protected array $validation = [
        'name' => ['bail', 'required'],
        'email' => ['bail', 'required', 'email:filter'],
        'certificate' => ['bail', 'nullable'],
        'password' => ['bail', 'min:8'],
        'password_enabled' => ['bail', 'boolean'],
        'readonly' => ['bail', 'boolean'],
        'admin' => ['bail', 'boolean'],
        'enabled' => ['bail', 'boolean'],
    ];

    /**
     * @return void
     */
    public function testGetFail(): void
    {
        $this->authUserAdmin();

        $this->get($this->route(null, $this->factoryCreate(Model::class)->id), $this->apiAuthorization())
            ->assertStatus(405);

        $this->getJson($this->route(null, $this->factoryCreate(Model::class)->id), $this->apiAuthorization())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $id = $this->factoryCreate(Model::class)->id;

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['email', 'password', 'password_enabled'], false))
            ->assertStatus(401);

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['name', 'password', 'password_enabled'], false))
            ->assertStatus(401);
    }

    /**
     * @return void
     */
    public function testPostUserUnauthorizedFail(): void
    {
        $this->authUser();

        $id = $this->factoryCreate(Model::class)->id;

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['email', 'password', 'password_enabled'], false))
            ->assertStatus(401);

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['name', 'password', 'password_enabled'], false))
            ->assertStatus(401);
    }

    /**
     * @return void
     */
    public function testPostEmptyFail(): void
    {
        $this->authUserAdmin();

        $id = $this->factoryCreate(Model::class)->id;

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['email', 'password', 'password_enabled'], false))
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"name"}', true));

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['name', 'password', 'password_enabled'], false))
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"email"}', true));
    }

    /**
     * @return void
     */
    public function testPostEmailFail(): void
    {
        $this->authUserAdmin();

        $id = $this->factoryCreate(Model::class)->id;

        $data = $this->factoryWhitelist(Model::class, ['name', 'password'], false);
        $data['email'] = uniqid();

        $this->postJsonAuthorized($this->route(null, $id), $data)
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"email"}', true));
    }

    /**
     * @return void
     */
    public function testPostPasswordFail(): void
    {
        $this->authUserAdmin();

        $id = $this->factoryCreate(Model::class)->id;

        $data = $this->factoryWhitelist(Model::class, ['name', 'email'], false);
        $data['password'] = '123';

        $this->postJsonAuthorized($this->route(null, $id), $data)
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"password"}', true));

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['name', 'email'], false))
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"validator_error"}', true));
    }

    /**
     * @return void
     */
    public function testPostSelfFail(): void
    {
        $data = $this->authUserAdmin()->toArray();

        $this->postJsonAuthorized($this->route(null, $data['id']), ['enabled' => false] + $data)
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"validator_error"}', true));

        $this->postJsonAuthorized($this->route(null, $data['id']), ['admin' => false] + $data)
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"validator_error"}', true));

        $this->postJsonAuthorized($this->route(null, $data['id']), ['readonly' => true] + $data)
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"validator_error"}', true));
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $id = $this->factoryCreate(Model::class)->id;

        $row = $this->factoryMake(Model::class);
        $row->password = uniqid();

        $this->postJsonAuthorized($this->route(null, $id), $row->only('name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled'))
            ->assertStatus(200)
            ->assertExactJson(['id' => 2] + $row->only('name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled'));
    }

    /**
     * @return void
     */
    public function testPostCertificateNoPasswordSuccess(): void
    {
        $this->authUserAdmin();

        $row = $this->factoryCreate(Model::class);

        $this->postJsonAuthorized($this->route(null, $row->id), $row->only(['name', 'email', 'certificate', 'enabled']))
            ->assertStatus(200)
            ->assertExactJson($row->only('id', 'name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled'));
    }
}
