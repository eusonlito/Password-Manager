<?php declare(strict_types=1);

namespace App\Domains\User\Test\ControllerApi;

use App\Domains\User\Model\User as Model;

class Create extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.api.create';

    /**
     * @var array
     */
    protected array $validation = [
        'name' => ['bail', 'required'],
        'email' => ['bail', 'required', 'email:filter'],
        'certificate' => ['bail', 'required_without:password', 'nullable'],
        'password' => ['bail', 'required_with:password_enabled', 'min:8'],
        'password_enabled' => ['bail', 'nullable', 'boolean'],
        'readonly' => ['bail', 'nullable', 'boolean'],
        'admin' => ['bail', 'nullable', 'boolean'],
        'enabled' => ['bail', 'nullable', 'boolean'],
        'teams' => ['bail', 'array'],
    ];

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
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->postJsonAuthorized($this->route())
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"name|email|certificate"}', true));
    }

    /**
     * @return void
     */
    public function testPostEmptyFail(): void
    {
        $this->authUserAdmin();

        $this->postJsonAuthorized($this->route(), $this->factoryWhitelist(Model::class, ['email', 'password'], false))
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"name"}', true));

        $this->postJsonAuthorized($this->route(), $this->factoryWhitelist(Model::class, ['name', 'password'], false))
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"email"}', true));

        $this->postJsonAuthorized($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email'], false))
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"certificate"}', true));
    }

    /**
     * @return void
     */
    public function testPostEmailFail(): void
    {
        $this->authUserAdmin();

        $data = $this->factoryWhitelist(Model::class, ['name', 'password'], false);
        $data['email'] = uniqid();

        $this->postJsonAuthorized($this->route(), $data)
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"email"}', true));
    }

    /**
     * @return void
     */
    public function testPostPasswordFail(): void
    {
        $this->authUserAdmin();

        $data = $this->factoryWhitelist(Model::class, ['name', 'email'], false);
        $data['password'] = '123';

        $this->postJsonAuthorized($this->route(), $data)
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"password"}', true));

        $this->postJsonAuthorized($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email', 'password_enabled'], false))
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"certificate|password"}', true));

        $this->postJsonAuthorized($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email', 'certificate', 'password_enabled'], false))
            ->assertStatus(422)
            ->assertJson(json_decode('{"code":422,"status":"password"}', true));
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $row = $this->factoryMake(Model::class);

        $this->postJsonAuthorized($this->route(), ['password' => uniqid()] + $row->only(['name', 'email', 'certificate']))
            ->assertStatus(200)
            ->assertExactJson(['id' => 2] + $row->only('name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled'));
    }

    /**
     * @return void
     */
    public function testPostCertificateNoPasswordSuccess(): void
    {
        $this->authUserAdmin();

        $row = $this->factoryMake(Model::class);

        $this->postJsonAuthorized($this->route(), $row->only(['name', 'email', 'certificate']))
            ->assertStatus(200)
            ->assertExactJson(['id' => 2] + $row->only('name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled'));
    }
}
