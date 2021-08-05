<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

use App\Domains\User\Model\User as Model;

class AuthCredentials extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.auth.credentials';

    /**
     * @var string
     */
    protected string $action = 'authCredentials';

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->get($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testGetLoggedSuccess(): void
    {
        $this->auth();

        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->post($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $this->post($this->route(), $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo email es requerido');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['password']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo email es requerido');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['email']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo password es requerido');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['email', 'password']))
            ->assertStatus(401)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Error de autenticación');
    }

    /**
     * @return void
     */
    public function testPostLockedFail(): void
    {
        $data = $this->factoryWhitelist(Model::class, ['email', 'password']);

        for ($i = 0; $i < 3; $i++) {
            $this->post($this->route(), $data)
                ->assertStatus(401)
                ->assertDontSee('validation.')
                ->assertDontSee('validator.')
                ->assertSee('Error de autenticación');
        }

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('IP Bloqueada');
    }

    /**
     * @return void
     */
    public function testPostPasswordDisabledFail(): void
    {
        $user = $this->user();
        $user->password_enabled = false;
        $user->save();

        $this->post($this->route(), ['email' => $user->email, 'password' => $user->email] + $this->action())
            ->assertStatus(401)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Error de autenticación');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $user = $this->user();
        $user->password_enabled = true;
        $user->save();

        $this->post($this->route(), ['email' => $user->email, 'password' => $user->email] + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }
}
