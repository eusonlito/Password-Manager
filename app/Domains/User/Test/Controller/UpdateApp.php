<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

use App\Domains\App\Model\App as AppModel;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\User\Model\User as Model;

class UpdateApp extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.update.app';

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
    public function testGetOtherSuccess(): void
    {
        $auth = $this->authUserAdmin();

        $row = $this->factoryCreate(Model::class);

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertViewIs('domains.user.update-app');

        $app = $this->factoryCreate(AppModel::class);

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertDontSee($app->name);

        $app->user_id = $row->id;
        $app->save();

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertDontSee($app->name);

        $app->shared = true;
        $app->save();

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertSee($app->name);

        $app->shared = false;
        $app->save();

        $app = $this->factoryCreate(AppModel::class);
        $app->user_id = $auth->id;
        $app->save();

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertDontSee($app->name);

        $appAuth = $this->factoryCreate(AppModel::class);
        $appAuth->user_id = $auth->id;
        $appAuth->save();

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertDontSee($appAuth->name);

        $appAuth->shared = true;
        $appAuth->save();

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertDontSee($appAuth->name);

        $team = $this->factoryCreate(TeamModel::class);
        $team->users()->sync([$row->id]);

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertDontSee($appAuth->name);

        $appAuth->teams()->sync([$team->id]);

        $this->get($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertSee($appAuth->name);
    }

    /**
     * @return void
     */
    public function testGetMineSuccess(): void
    {
        $auth = $this->authUserAdmin();

        $this->get($this->route(null, $auth->id))
            ->assertStatus(200)
            ->assertViewIs('domains.user.update-app');

        $app = $this->factoryCreate(AppModel::class);

        $this->get($this->route(null, $auth->id))
            ->assertStatus(200)
            ->assertDontSee($app->name);

        $app->user_id = $auth->id;
        $app->save();

        $this->get($this->route(null, $auth->id))
            ->assertStatus(200)
            ->assertSee($app->name);

        $app->shared = true;
        $app->save();

        $this->get($this->route(null, $auth->id))
            ->assertStatus(200)
            ->assertSee($app->name);
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(200)
            ->assertViewIs('domains.user.update-app');
    }
}
