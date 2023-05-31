<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\Team\Model\TeamUser as TeamUserModel;
use App\Domains\User\Model\User as Model;

class Create extends ControllerAbstract
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
        $this->authUserAdmin(false);

        $this->get($this->route())
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testPostNotAdminFail(): void
    {
        $this->authUserAdmin(false);

        $this->post($this->route())
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.create');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.create');
    }

    /**
     * @return void
     */
    public function testPostEmptyWithActionFail(): void
    {
        $this->authUserAdmin();

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
        $this->authUserAdmin();

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
        $this->authUserAdmin();

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
        $this->authUserAdmin();

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
    public function testPostWithoutActionSuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email', 'password'], false))
            ->assertStatus(200)
            ->assertViewIs('domains.user.create');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $data = $this->factoryMake(Model::class)->toArray();
        $data['password'] = uniqid();

        $this->followingRedirects()
            ->post($this->route(), $data + $this->action())
            ->assertStatus(200)
            ->assertSee('El usuario ha sido creado correctamente')
            ->assertSee($data['name']);

        $row = $this->userLast();

        $this->assertEquals($row->name, $data['name']);
        $this->assertEquals($row->email, $data['email']);
        $this->assertEquals($row->password_enabled, $data['password_enabled']);
        $this->assertEquals($row->certificate, $data['certificate']);
        $this->assertEquals($row->admin, $data['admin']);
        $this->assertEquals($row->readonly, $data['readonly']);
        $this->assertEquals($row->enabled, $data['enabled']);

        $new = $this->factoryMake(Model::class)->toArray();
        $new['password'] = uniqid();
        $new['email'] = $row->email;

        $this->post($this->route(), $new + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Ya existe otro usuario con ese mismo email');

        $new = $this->factoryMake(Model::class)->toArray();
        $new['password'] = uniqid();
        $new['certificate'] = $row->certificate;

        $this->post($this->route(), $new + $this->action())
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
    public function testPostTeamsSuccess(): void
    {
        $this->authUserAdmin();

        $team = $this->factoryCreate(TeamModel::class);

        $data = $this->factoryMake(Model::class)->toArray();
        $data['password'] = uniqid();
        $data['teams'] = [$team->id];

        $this->followingRedirects()
            ->post($this->route(), $data + $this->action())
            ->assertStatus(200)
            ->assertSee('El usuario ha sido creado correctamente')
            ->assertSee($data['name']);

        $this->assertEquals(TeamUserModel::count(), 1);

        $relation = TeamUserModel::first();

        $this->assertEquals($relation->team_id, $team->id);
        $this->assertEquals($relation->user_id, $this->userLast()->id);
    }

    /**
     * @return void
     */
    public function testPostCertificateNoPasswordSuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email', 'certificate']))
            ->assertStatus(302)
            ->assertRedirect(route('user.update.team', $this->userLast()->id));
    }
}
