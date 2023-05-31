<?php declare(strict_types=1);

namespace App\Domains\User\Test\ControllerApi;

use App\Domains\App\Model\App as AppModel;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\User\Model\User as Model;

class Detail extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.api.detail';

    /**
     * @return void
     */
    public function testGetFail(): void
    {
        $auth = $this->authUserAdmin();

        $this->get($this->route(null, $auth->id), $this->apiAuthorization())
            ->assertStatus(405);

        $this->getJson($this->route(null, $auth->id), $this->apiAuthorization())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $id = $this->factoryCreate(Model::class)->id;

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['email', 'password', 'password_enabled'], false))
            ->assertStatus(401);

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['name', 'password', 'password_enabled'], false))
            ->assertStatus(401);
    }

    /**
     * @return void
     */
    public function testPostUserUnauthorizedFail(): void
    {
        $this->authUser();

        $id = $this->factoryCreate(Model::class)->id;

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['email', 'password', 'password_enabled'], false))
            ->assertStatus(401);

        $this->postJsonAuthorized($this->route(null, $id), $this->factoryWhitelist(Model::class, ['name', 'password', 'password_enabled'], false))
            ->assertStatus(401);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $auth = $this->authUserAdmin();

        $json = $auth->only('id', 'name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled')
            + ['apps' => [], 'teams' => []];

        $this->postJsonAuthorized($this->route(null, $auth->id))
            ->assertStatus(200)
            ->assertExactJson($json);
    }

    /**
     * @return void
     */
    public function testPostAppTeamSuccess(): void
    {
        $auth = $this->authUserAdmin();

        $row = $this->factoryCreate(Model::class);
        $data = $row->only('id', 'name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled');

        $this->postJsonAuthorized($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertExactJson($data + ['apps' => [], 'teams' => []]);

        $app = $this->factoryCreate(AppModel::class);

        $this->postJsonAuthorized($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertExactJson($data + ['apps' => [], 'teams' => []]);

        $app->user_id = $row->id;
        $app->save();

        $this->postJsonAuthorized($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertExactJson($data + ['apps' => [], 'teams' => []]);

        $app->shared = true;
        $app->save();

        $this->postJsonAuthorized($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertExactJson($data + ['apps' => [$app->only('id', 'name')], 'teams' => []]);

        $appAuth = $this->factoryCreate(AppModel::class);
        $appAuth->user_id = $auth->id;
        $appAuth->save();

        $this->postJsonAuthorized($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertExactJson($data + ['apps' => [$app->only('id', 'name')], 'teams' => []]);

        $appAuth->shared = true;
        $appAuth->save();

        $this->postJsonAuthorized($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertExactJson($data + ['apps' => [$app->only('id', 'name')], 'teams' => []]);

        $team = $this->factoryCreate(TeamModel::class);
        $team->users()->sync([$row->id]);

        $json = $data + [
            'apps' => [$app->only('id', 'name')],
            'teams' => [$team->only('id', 'code', 'name', 'default')],
        ];

        $this->postJsonAuthorized($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertExactJson($json);

        $appAuth->teams()->sync([$team->id]);

        $apps = collect([$app, $appAuth])
            ->sortByDesc('updated_at')
            ->map(static fn ($app) => $app->only('id', 'name'));

        $json = $data + [
            'apps' => $apps->toArray(),
            'teams' => [$team->only('id', 'code', 'name', 'default')],
        ];

        $this->postJsonAuthorized($this->route(null, $row->id))
            ->assertStatus(200)
            ->assertExactJson($json);
    }
}
