<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

use Illuminate\Support\Facades\Hash;
use App\Domains\User\Model\User as Model;

class Profile extends ControllerAbstract
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
        'api_secret' => ['bail', 'nullable', 'min:8'],
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
        $row = $this->authUser();

        $data = $row->toArray();
        $data['email'] = uniqid();
        $data['password_current'] = $row->email;

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
        $row = $this->authUser();

        $data = $row->toArray();
        $data['password'] = '123';
        $data['password_current'] = $row->email;

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
        $row = $this->authUser();

        $data = $row->toArray();
        $data['api_key'] = uniqid();
        $data['password_current'] = $row->email;

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El api key debe ser un UUID valido');
    }

    /**
     * @return void
     */
    public function testPostApiSecretFail(): void
    {
        $row = $this->authUser();

        $data = $row->toArray();
        $data['api_secret'] = 'A';
        $data['password_current'] = $row->email;

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo api secret debe tener al menos 8 caracteres.');

        $data['api_secret'] = $row->email;

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('La contraseña y el API Secret no pueden ser iguales');

        $data['password'] = $row->email;
        $data['api_secret'] = $row->email;

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('La contraseña y el API Secret no pueden ser iguales');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $row = $this->authUser();

        $data = $this->factoryMake(Model::class)->toArray();
        $data['password'] = $data['email'];
        $data['password_current'] = $row->email;
        $data['api_secret'] = $data['api_key'];

        $this->followingRedirects()
            ->post($this->route(), $data + $this->action())
            ->assertStatus(200)
            ->assertSee('Tu perfil ha sido actualizado correctmente');

        $row = $this->user();

        $this->assertEquals($row->name, $data['name']);
        $this->assertEquals($row->email, $data['email']);
        $this->assertEquals($row->certificate, $data['certificate']);
        $this->assertEquals($row->api_key, $data['api_key']);
        $this->assertEquals($row->password_enabled, $data['password_enabled']);

        $this->assertTrue(Hash::check($data['password'], $row->password));
        $this->assertTrue(Hash::check($data['api_secret'], $row->api_secret));

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
        $row = $this->authUser();

        $data = $this->factoryCreate(Model::class)->toArray();
        $data['certificate'] = $row->certificate;
        $data['password_current'] = $row->email;

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Ya existe otro usuario con ese mismo email');

        $data = $this->factoryCreate(Model::class)->toArray();
        $data['email'] = $row->email;
        $data['password_current'] = $row->email;

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Ya existe otro usuario con este mismo certificado');
    }
}
