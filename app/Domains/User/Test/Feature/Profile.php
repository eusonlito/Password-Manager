<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

use App\Domains\User\Model\User as Model;

class Profile extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.profile';

    /**
     * @var string
     */
    protected string $action = 'profile';

    /**
     * @var array
     */
    protected array $validation = [
        'name' => ['bail', 'required'],
        'email' => ['bail', 'required', 'email:filter'],
        'certificate' => ['bail', 'nullable'],
        'password' => ['bail', 'min:8'],
        'password_enabled' => ['bail', 'boolean'],
        'password_current' => ['bail', 'required', 'current_password'],
        'api_key' => ['bail', 'nullable', 'uuid'],
        'tfa_enabled' => ['bail', 'boolean'],
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
    public function testGetSuccess(): void
    {
        $this->authUser();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.profile');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUser();

        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.profile');
    }

    /**
     * @return void
     */
    public function testPostEmptyWithActionFail(): void
    {
        $this->authUser();

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
        $this->authUser();

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['email']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo name es requerido');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo email es requerido');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo password current es requerido');
    }

    /**
     * @return void
     */
    public function testPostEmailFail(): void
    {
        $user = $this->authUser();

        $data = $user->toArray();
        $data['email'] = uniqid();
        $data['password_current'] = $user->email;

        $this->post($this->route(), $data + $this->action())
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
        $user = $this->authUser();

        $data = $user->toArray();
        $data['password'] = '123';
        $data['password_current'] = $user->email;

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo password debe tener al menos 8 caracteres');

        $data['certificate'] = '';
        $data['password'] = '';
        $data['password_enabled'] = '';

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('No se puede desactivar el acceso por contraseña si no se ha definido un certificado');
    }

    /**
     * @return void
     */
    public function testPostApiKeyFail(): void
    {
        $user = $this->authUser();

        $data = $user->toArray();
        $data['api_key'] = uniqid();
        $data['password_current'] = $user->email;

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El api key debe ser un UUID valido');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $user = $this->authUser();

        $data = $this->factoryMake(Model::class)->toArray();
        $data['password'] = $data['email'];
        $data['password_current'] = $user->email;

        $this->followingRedirects()
            ->post($this->route(), $data + $this->action())
            ->assertStatus(200)
            ->assertSee('Tu perfil ha sido actualizado correctmente');

        $user = $this->user();

        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->email, $data['email']);
        $this->assertEquals($user->certificate, $data['certificate']);
        $this->assertEquals($user->api_key, $data['api_key']);
        $this->assertEquals($user->password_enabled, $data['password_enabled']);

        $this->get(route('user.logout'))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));

        $this->post(route('user.auth.credentials'), $data + $this->action('authCredentials'))
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));

        $this->get(route('user.logout'))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));

        $this->withServerVariables(['SSL_CLIENT_S_DN' => '/serialNumber='.$data['certificate']])
            ->post(route('user.auth.certificate'), $this->action('authCertificate'))
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostEmailExistsFail(): void
    {
        $user = $this->authUser();

        $data = $this->factoryCreate(Model::class)->toArray();
        $data['password_current'] = $user->email;

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Ya existe otro usuario con ese mismo email');
    }
}
