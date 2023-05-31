<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

class AuthCertificate extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.auth.certificate';

    /**
     * @var string
     */
    protected string $action = 'authCertificate';

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
    public function testPostInvalidFail(): void
    {
        $this->withServerVariables(['SSL_CLIENT_S_DN' => $this->user()->certificate])
            ->post($this->route(), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostDisabledFail(): void
    {
        $row = $this->user();
        $row->enabled = false;
        $row->save();

        $this->withServerVariables(['SSL_CLIENT_S_DN' => '/serialNumber='.$row->certificate])
            ->post($this->route(), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostInvalidSuccess(): void
    {
        $this->withServerVariables(['SSL_CLIENT_S_DN' => '/serialNumber='.$this->user()->certificate])
            ->post($this->route(), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }
}
