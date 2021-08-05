<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

class AuthCertificate extends FeatureAbstract
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
        $user = $this->user();
        $user->enabled = false;
        $user->save();

        $this->withServerVariables(['SSL_CLIENT_S_DN' => '/serialNumber='.$user->certificate])
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
