<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

use App\Domains\User\Model\User as Model;

class Create extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.create';

    /**
     * @var string
     */
    protected string $action = 'create';

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
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetNotAdminFail(): void
    {
        $this->authNotAdmin();

        $this->get($this->route())
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testPostNotAdminFail(): void
    {
        $this->authNotAdmin();

        $this->post($this->route())
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authAdmin();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.create');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authAdmin();

        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.create');
    }

    /**
     * @return void
     */
    public function testPostEmptyWithActionFail(): void
    {
        $this->authAdmin();

        $this->post($this->route(), $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostEmptyFail(): void
    {
        $this->authAdmin();

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['email', 'password']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo name es requerido');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'password']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo email es requerido');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo certificate es requerido cuando password no está presente');
    }

    /**
     * @return void
     */
    public function testPostEmailFail(): void
    {
        $this->authAdmin();

        $data = $this->factoryWhitelist(Model::class, ['name', 'password']);
        $data['email'] = uniqid();

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El formato del email es inválido');
    }

    /**
     * @return void
     */
    public function testPostPasswordFail(): void
    {
        $this->authAdmin();

        $data = $this->factoryWhitelist(Model::class, ['name', 'email']);
        $data['password'] = '123';

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo password debe tener al menos 8 caracteres');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email', 'password_enabled']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo certificate es requerido cuando password no está presente');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email', 'certificate', 'password_enabled']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo password es requerido cuando password enabled está presente');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authAdmin();

        $data = $this->factoryMake(Model::class)->toArray() + $this->action();
        $data['password'] = uniqid();

        $this->followingRedirects()
            ->post($this->route(), $data)
            ->assertStatus(200)
            ->assertSee('El usuario ha sido creado correctamente')
            ->assertSee($data['name']);

        $user = $this->userLast();

        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->email, $data['email']);
        $this->assertEquals($user->password_enabled, $data['password_enabled']);
        $this->assertEquals($user->admin, $data['admin']);
        $this->assertEquals($user->readonly, $data['readonly']);
        $this->assertEquals($user->enabled, $data['enabled']);

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Ya existe otro usuario con ese mismo email');
    }

    /**
     * @return void
     */
    public function testPostSuccessCertificateNoPassword(): void
    {
        $this->authAdmin();

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email', 'certificate']))
            ->assertStatus(302)
            ->assertRedirect(route('user.update.team', $this->userLast()->id));
    }

    /**
     * @return void
     */
    public function testPostWithoutActionSuccess(): void
    {
        $this->authAdmin();

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email', 'password'], false))
            ->assertStatus(200)
            ->assertViewIs('domains.user.create');
    }
}
