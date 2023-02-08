<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

use App\Domains\User\Model\User as Model;

class Update extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.update';

    /**
     * @var string
     */
    protected string $action = 'update';

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
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetNoAdminFail(): void
    {
        $this->get($this->route(null, $this->authUserAdmin(false)->id))
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostNoAdminFail(): void
    {
        $this->post($this->route(null, $this->authUserAdmin(false)->id))
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(200)
            ->assertViewIs('domains.user.update');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(200)
            ->assertViewIs('domains.user.update');
    }

    /**
     * @return void
     */
    public function testPostEmptyWithActionFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id), $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostEmptyFail(): void
    {
        $this->authUserAdmin();

        $id = $this->factoryCreate(Model::class)->id;

        $this->post($this->route(null, $id), $this->factoryWhitelist(Model::class, ['email', 'password', 'password_enabled']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo name es requerido');

        $this->post($this->route(null, $id), $this->factoryWhitelist(Model::class, ['name', 'password', 'password_enabled']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo email es requerido');
    }

    /**
     * @return void
     */
    public function testPostEmailFail(): void
    {
        $this->authUserAdmin();

        $id = $this->factoryCreate(Model::class)->id;

        $data = $this->factoryWhitelist(Model::class, ['name', 'password']);
        $data['email'] = uniqid();

        $this->post($this->route(null, $id), $data)
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
        $this->authUserAdmin();

        $id = $this->factoryCreate(Model::class)->id;

        $data = $this->factoryWhitelist(Model::class, ['name', 'email']);
        $data['password'] = '123';

        $this->post($this->route(null, $id), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo password debe tener al menos 8 caracteres');

        $this->post($this->route(null, $id), $this->factoryWhitelist(Model::class, ['name', 'email']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('No se puede desactivar el acceso por contraseña si no se ha definido un certificado');
    }

    /**
     * @return void
     */
    public function testPostWithoutActionSuccess(): void
    {
        $this->authUserAdmin();

        $id = $this->factoryCreate(Model::class)->id;

        $this->post($this->route(null, $id), $this->factoryWhitelist(Model::class, ['name', 'email', 'password'], false))
            ->assertStatus(200)
            ->assertViewIs('domains.user.update');
    }

    /**
     * @return void
     */
    public function testPostSelfFail(): void
    {
        $data = $this->authUserAdmin()->toArray();

        $this->post($this->route(null, $data['id']), ['enabled' => false] + $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('No es posible desactivar a tu propio usuario');

        $this->post($this->route(null, $data['id']), ['admin' => false] + $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('No es posible desactivar la opción de administrador de tu propio usuario');

        $this->post($this->route(null, $data['id']), ['readonly' => true] + $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('No es posible marcar la opción de sólo lectura para tu propio usuario');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $id = $this->factoryCreate(Model::class)->id;

        $data = $this->factoryMake(Model::class)->toArray();
        $data['password'] = uniqid();

        $this->followingRedirects()
            ->post($this->route(null, $id), $data + $this->action())
            ->assertStatus(200)
            ->assertSee('Los datos del usuario han sido actualizados correctamente')
            ->assertSee($data['name']);

        $row = $this->userLast();

        $this->assertEquals($row->name, $data['name']);
        $this->assertEquals($row->email, $data['email']);
        $this->assertEquals($row->password_enabled, $data['password_enabled']);
        $this->assertEquals($row->certificate, $data['certificate']);
        $this->assertEquals($row->admin, $data['admin']);
        $this->assertEquals($row->readonly, $data['readonly']);
        $this->assertEquals($row->enabled, $data['enabled']);

        $new = $this->factoryCreate(Model::class);
        $data['email'] = $new->email;
        $data['certificate'] = $row->certificate;

        $this->post($this->route(null, $id), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Ya existe otro usuario con ese mismo email');

        $new = $this->factoryCreate(Model::class);
        $data['email'] = $row->email;
        $data['certificate'] = $new->certificate;

        $this->post($this->route(null, $id), $data + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Ya existe otro usuario con ese mismo certificado');

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
    public function testPostCertificateNoPasswordSuccess(): void
    {
        $this->authUserAdmin();

        $id = $this->factoryCreate(Model::class)->id;

        $this->post($this->route(null, $id), $this->factoryWhitelist(Model::class, ['name', 'email', 'certificate']))
            ->assertStatus(302)
            ->assertRedirect(route('user.update', $id));
    }
}
