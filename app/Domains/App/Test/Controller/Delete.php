<?php declare(strict_types=1);

namespace App\Domains\App\Test\Controller;

use App\Domains\App\Model\App as Model;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\User\Model\User as UserModel;

class Delete extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'app.delete';

    /**
     * @var string
     */
    protected string $action = 'delete';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(405);
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
    public function testGetFail(): void
    {
        $this->authUser();

        $this->get($this->route(null, $this->rowCreateWithUser()->id))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostOtherFail(): void
    {
        $user = $this->authUser();

        $team = $this->factoryCreate(TeamModel::class);
        $team->users()->sync([$user->id]);

        $row = $this->factoryCreate(Model::class);

        $this->post($this->route(null, $row->id))
            ->assertStatus(404);

        $row->shared = true;
        $row->save();

        $this->post($this->route(null, $row->id))
            ->assertStatus(404);

        $row->editable = false;
        $row->save();

        $row->teams()->sync([$team->id]);

        $this->followingRedirects()
            ->post($this->route(null, $row->id), $this->action())
            ->assertStatus(200)
            ->assertSee('No dispones de permisos para poder eliminar esta aplicación.');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUser();

        $row = $this->rowCreateWithUser();

        $this->followingRedirects()
            ->post($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertSee($row->name);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUser();

        $row = $this->rowCreateWithUser();

        $row->shared = false;
        $row->editable = false;

        $row->save();

        $this->followingRedirects()
            ->post($this->route(null, $row->id), $this->action())
            ->assertStatus(200)
            ->assertSee('La aplicación ha sido borrada correctamente')
            ->assertDontSee($row->name);

        $row = $this->rowCreateWithUserAndTeam();
        $row->user_id = $this->factoryCreate(UserModel::class)->id;
        $row->editable = true;
        $row->shared = true;
        $row->save();

        $this->followingRedirects()
            ->post($this->route(null, $row->id), $this->action())
            ->assertStatus(200)
            ->assertSee('La aplicación ha sido borrada correctamente')
            ->assertDontSee($row->name);
    }
}
