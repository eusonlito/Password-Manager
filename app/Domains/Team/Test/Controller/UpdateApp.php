<?php declare(strict_types=1);

namespace App\Domains\Team\Test\Controller;

use App\Domains\Team\Model\Team as Model;
use App\Domains\Team\Model\TeamApp as TeamAppModel;
use App\Domains\App\Model\App as AppModel;

class UpdateApp extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'team.update.app';

    /**
     * @var string
     */
    protected string $action = 'updateApp';

    /**
     * @var array
     */
    protected array $validation = [
        'app_ids' => ['bail', 'array'],
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
            ->assertViewIs('domains.team.update-app');
    }

    /**
     * @return void
     */
    public function testPostEmptyNoActionSuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(200)
            ->assertViewIs('domains.team.update-app');
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
            ->assertSee('Las aplicaciones se han relacionado correctamente');
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id), ['app_ids' => 1] + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo app ids debe ser un array.');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $user = $this->authUserAdmin();

        $row = $this->factoryCreate(Model::class);
        $app = $this->factoryCreate(AppModel::class);

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertDontSee($app->name);

        $app->user_id = $user->id;
        $app->save();

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertDontSee($app->name);

        $app->shared = true;
        $app->save();

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertSee($app->name);

        $this->followingRedirects()
            ->post($this->route(null, $row->id), ['app_ids' => [$app->id]] + $this->action())
            ->assertStatus(200)
            ->assertSee('Las aplicaciones se han relacionado correctamente')
            ->assertSee($app->name);

        $this->assertEquals(TeamAppModel::count(), 1);

        $relation = TeamAppModel::first();

        $this->assertEquals($relation->app_id, $app->id);
        $this->assertEquals($relation->team_id, $row->id);
    }
}
