<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

use Illuminate\Testing\TestResponse;
use App\Domains\App\Model\App as AppModel;
use App\Domains\User\Model\User as Model;
use App\Domains\Team\Model\Team as TeamModel;

class ApiIndex extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.api.index';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route())
            ->assertStatus(422)
            ->assertSee('El campo api key es requerido.');

        $this->postJson($this->route())
            ->assertStatus(422)
            ->assertExactJson(json_decode('{"code":422,"status":"api_key","message":"El campo api key es requerido."}', true));

        $this->post($this->route(), [], ['Authorization' => uniqid()])
            ->assertStatus(401)
            ->assertSee('Las credenciales indicadas no son correctas');

        $this->postJson($this->route(), [], ['Authorization' => uniqid()])
            ->assertStatus(401)
            ->assertExactJson(json_decode('{"code":401,"status":"user_error","message":"Las credenciales indicadas no son correctas"}', true));
    }

    /**
     * @return void
     */
    public function testGetFail(): void
    {
        $this->authUser();

        $this->get($this->route())
            ->assertStatus(405)
            ->assertSee('Método no Permitido');

        $this->getJson($this->route())
            ->assertStatus(405)
            ->assertExactJson(json_decode('{"code":405,"status":"method_not_allowed","message":"Método no Permitido"}', true));
    }

    /**
     * @return void
     */
    public function testPostNoSecretFail(): void
    {
        $this->authUser();

        $this->post($this->route(), [], $this->apiAuthorization())
            ->assertStatus(401)
            ->assertSee('Para esta consulta es necesario el API Secret');

        $this->postJson($this->route(), [], $this->apiAuthorization())
            ->assertStatus(401)
            ->assertExactJson(json_decode('{"code":401,"status":"api_secret_required","message":"Para esta consulta es necesario el API Secret"}', true));

        $query = ['api_secret' => uniqid()];

        $this->post($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(401)
            ->assertSee('Las credenciales indicadas no son correctas');

        $this->postJson($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(401)
            ->assertExactJson(json_decode('{"code":401,"status":"user_error","message":"Las credenciales indicadas no son correctas"}', true));
    }

    /**
     * @return void
     */
    public function testPostSecretDisabledFail(): void
    {
        config(['auth.api.secret_enabled' => false]);

        $this->authUser();

        $app = $this->appCreateWithUser();

        $this->post($this->route(), [], $this->apiAuthorization())
            ->assertStatus(302);

        $this->postJson($this->route(), [], $this->apiAuthorization())
            ->assertStatus(401)
            ->assertExactJson(json_decode('{"code":401,"status":"unauthorized","message":"Unauthorized"}', true));
    }

    /**
     * @return void
     */
    public function testPostNoAdminFail(): void
    {
        $this->authUser();

        $this->postJsonAuthorized()
            ->assertStatus(401)
            ->assertExactJson(json_decode('{"code":401,"status":"unauthorized","message":"Unauthorized"}', true));
    }

    /**
     * @return void
     */
    public function testPostNoSecretSuccess(): void
    {
        $user = $this->authUserAdmin();

        $json = [$user->only('id', 'name', 'email', 'certificate', 'tfa_enabled', 'admin', 'readonly', 'enabled')];

        $this->postJsonAuthorized()
            ->assertStatus(200)
            ->assertExactJson($json);

        $this->post($this->route(), [], $this->apiAuthorization())
            ->assertStatus(200)
            ->assertExactJson($json);

        $this->postJson($this->route(), [], $this->apiAuthorization())
            ->assertStatus(200)
            ->assertExactJson($json);
    }

    /**
     * @return void
     */
    public function testPostOtherFail(): void
    {
        $user = $this->authUser();

        $team = $this->factoryCreate(TeamModel::class);
        $team->users()->sync([$user->id]);

        $app = $this->factoryCreate(AppModel::class);

        $this->postAuthorized(['q' => $app->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([]);

        $this->postJsonAuthorized(['q' => $app->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([]);

        $app->shared = true;
        $app->save();

        $this->postAuthorized(['q' => $app->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([]);

        $this->postJsonAuthorized(['q' => $app->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([]);
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $user = $this->authUser();
        $app = $this->appCreateWithUser();

        $this->postAuthorized()
            ->assertStatus(422)
            ->assertSee('El campo q es requerido.');

        $this->postJsonAuthorized()
            ->assertStatus(422)
            ->assertExactJson(json_decode('{"code":422,"status":"q","message":"El campo q es requerido."}', true));
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $user = $this->authUser();

        $first = $this->appCreateWithUser();

        $first->shared = false;
        $first->editable = false;

        $first->save();

        $this->assertEquals($first->payload('url'), 'https://google.es');

        $this->postAuthorized(['q' => $first->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([$first->only('id', 'name')]);

        $this->postJsonAuthorized(['q' => $first->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([$first->only('id', 'name')]);

        $second = $this->appCreateWithUserAndTeam();

        $second->user_id = $this->factoryCreate(UserModel::class)->id;
        $second->shared = true;

        $second->save();

        $this->postAuthorized(['q' => $second->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([$first->only('id', 'name'), $second->only('id', 'name')]);

        $this->postJsonAuthorized(['q' => $second->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([$first->only('id', 'name'), $second->only('id', 'name')]);

        $third = $this->appCreateWithUserAndTeam();

        $third->type = 'server';

        $third->save();

        $this->postAuthorized(['q' => $third->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([$first->only('id', 'name'), $second->only('id', 'name')]);

        $this->postJsonAuthorized(['q' => $third->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([$first->only('id', 'name'), $second->only('id', 'name')]);
    }

    /**
     * @param array $body = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    protected function postAuthorized(array $body = []): TestResponse
    {
        return $this->post($this->route(), $this->postAuthorizedBody($body), $this->apiAuthorization());
    }

    /**
     * @param array $body = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    protected function postJsonAuthorized(array $body = []): TestResponse
    {
        return $this->postJson($this->route(), $this->postAuthorizedBody($body), $this->apiAuthorization());
    }

    /**
     * @param array $body
     *
     * @return array
     */
    protected function postAuthorizedBody(array $body): array
    {
        return ['api_secret' => $this->authUser()->api_key] + $body;
    }
}
