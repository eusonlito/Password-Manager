<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

class AuthTFA extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.auth.tfa';

    /**
     * @var string
     */
    protected string $action = 'authTFA';

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
    public function testGetDisabledSuccess(): void
    {
        $this->authUser(['tfa_enabled' => false]);

        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostDisabledSuccess(): void
    {
        $this->authUser(['tfa_enabled' => false]);

        $this->post($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostEmptyFail(): void
    {
        $this->authUser(['tfa_enabled' => true]);

        $this->post($this->route(), $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo code es requerido');
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $this->authUser(['tfa_enabled' => true]);

        $this->post($this->route(), ['code' => uniqid()] + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo code debe ser de 6 dígitos');

        $this->post($this->route(), ['code' => '123456'] + $this->action())
            ->assertStatus(401)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El código de Doble Factor no es correcto');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUser(['tfa_enabled' => true]);

        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.auth-tfa');
    }
}
