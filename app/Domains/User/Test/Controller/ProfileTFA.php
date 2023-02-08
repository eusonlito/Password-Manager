<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

use App\Domains\User\Model\User as Model;

class ProfileTFA extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.profile.tfa';

    /**
     * @var string
     */
    protected string $action = 'profileTFA';

    /**
     * @var array
     */
    protected array $validation = [
        'tfa_enabled' => ['bail', 'boolean'],
        'password_current' => ['bail', 'required', 'current_password'],
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
            ->assertViewIs('domains.user.profile-tfa');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUser();

        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.profile-tfa');
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
    public function testPostSuccess(): void
    {
        $row = $this->authUser();

        $data = $this->factoryMake(Model::class)->toArray();
        $data['password_current'] = $row->email;
        $data['tfa_enabled'] = true;

        $this->post($this->route(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect($this->route());
    }
}
