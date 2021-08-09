<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

use App\Domains\User\Model\User as Model;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\Team\Model\TeamUser as TeamUserModel;

class UpdateTeam extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.update.team';

    /**
     * @var string
     */
    protected string $action = 'updateTeam';

    /**
     * @var array
     */
    protected array $validation = [
        'team_ids' => ['bail', 'array', 'required'],
    ];

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route(null, 1))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route(null, 1))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetNoAdminFail(): void
    {
        $row = $this->authUserAdmin(false);

        $this->get($this->route(null, $row->id))
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostNoAdminFail(): void
    {
        $row = $this->authUserAdmin(false);

        $this->post($this->route(null, $row->id))
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
            ->assertViewIs('domains.user.update-team');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(200)
            ->assertViewIs('domains.user.update-team');
    }

    /**
     * @return void
     */
    public function testPostEmptyFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id), $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo team ids es requerido.');
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id), ['team_ids' => 1] + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo team ids debe ser un array.');

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id), ['team_ids' => [1]] + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('No se ha indicado ningún equipo');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $row = $this->factoryCreate(Model::class);
        $team = $this->factoryCreate(TeamModel::class);

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertSee($team->name);

        $this->followingRedirects()
            ->post($this->route(null, $row->id), ['team_ids' => [$team->id]] + $this->action())
            ->assertStatus(200)
            ->assertSee('La relación con los equipos se ha guardado correctamente')
            ->assertSee($team->name);

        $this->assertEquals(TeamUserModel::count(), 1);

        $relation = TeamUserModel::first();

        $this->assertEquals($relation->team_id, $team->id);
        $this->assertEquals($relation->user_id, $row->id);
    }
}
