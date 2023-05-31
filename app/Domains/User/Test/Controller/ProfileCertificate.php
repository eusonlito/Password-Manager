<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

use App\Domains\User\Model\User as Model;

class ProfileCertificate extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.profile.certificate';

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
    public function testGetEmptyFail(): void
    {
        $this->authUser();

        $this->followingRedirects()
            ->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.profile')
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('No ha sido posible acceder a ningún certificado');
    }

    /**
     * @return void
     */
    public function testPostEmptyFail(): void
    {
        $this->authUser();

        $this->followingRedirects()
            ->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.profile')
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('No ha sido posible acceder a ningún certificado');
    }

    /**
     * @return void
     */
    public function testGetFail(): void
    {
        $this->authUser();

        $this->followingRedirects()
            ->withServerVariables(['SSL_CLIENT_S_DN' => '/serialNumber='.$this->factoryCreate(Model::class)->certificate])
            ->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.profile')
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Ya existe otro usuario con este mismo certificado');
    }

    /**
     * @return void
     */
    public function testPostFail(): void
    {
        $this->authUser();

        $this->followingRedirects()
            ->withServerVariables(['SSL_CLIENT_S_DN' => '/serialNumber='.$this->factoryCreate(Model::class)->certificate])
            ->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.profile')
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Ya existe otro usuario con este mismo certificado');
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUser();

        $this->followingRedirects()
            ->withServerVariables(['SSL_CLIENT_S_DN' => '/serialNumber='.$this->factoryMake(Model::class)->certificate])
            ->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.profile')
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El certificado se ha actualizado correctamente');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUser();

        $this->followingRedirects()
            ->withServerVariables(['SSL_CLIENT_S_DN' => '/serialNumber='.$this->factoryMake(Model::class)->certificate])
            ->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.profile')
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El certificado se ha actualizado correctamente');
    }
}
