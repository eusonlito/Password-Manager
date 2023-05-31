<?php declare(strict_types=1);

namespace App\Domains\Team\Test\Controller;

use App\Domains\Team\Model\Team as Model;
use App\Domains\Team\Model\TeamUser as TeamUserModel;
use App\Domains\User\Model\User as UserModel;

class UpdateUser extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'team.update.user';

    /**
     * @var string
     */
    protected string $action = 'updateUser';

    /**
     * @var array
     */
    protected array $validation = [
        'user_ids' => ['bail', 'array'],
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
            ->assertViewIs('domains.team.update-user');
    }

    /**
     * @return void
     */
    public function testPostEmptyNoActionSuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(200)
            ->assertViewIs('domains.team.update-user');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->followingRedirects()
            ->post($this->route(null, $this->factoryCreate(Model::class)->id), $this->action())
            ->assertStatus(200)
            ->assertSee('Los usuarios se han relacionado correctamente');
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id), ['user_ids' => 1] + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo user ids debe ser un array.');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $row = $this->factoryCreate(Model::class);
        $user = $this->factoryCreate(UserModel::class);

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertSee($user->name);

        $this->followingRedirects()
            ->post($this->route(null, $row->id), ['user_ids' => [$user->id]] + $this->action())
            ->assertStatus(200)
            ->assertSee('Los usuarios se han relacionado correctamente')
            ->assertSee($user->name);

        $this->assertEquals(TeamUserModel::count(), 1);

        $relation = TeamUserModel::first();

        $this->assertEquals($relation->team_id, $row->id);
        $this->assertEquals($relation->user_id, $user->id);
    }
}
