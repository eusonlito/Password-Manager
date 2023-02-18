<?php declare(strict_types=1);

namespace App\Domains\App\Test\Controller;

use Illuminate\Testing\TestResponse;
use App\Domains\App\Model\App as Model;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\User\Model\User as UserModel;

class ApiSearch extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'app.api.search';

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

        $row = $this->rowCreateWithUser();

        $query = ['q' => $row->payload('url')];

        $this->post($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(401)
            ->assertSee('Para esta consulta es necesario el API Secret');

        $this->postJson($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(401)
            ->assertExactJson(json_decode('{"code":401,"status":"api_secret_required","message":"Para esta consulta es necesario el API Secret"}', true));

        $query = [
            'q' => $row->payload('url'),
            'api_secret' => uniqid(),
        ];

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
    public function testPostSecretDisabledSuccess(): void
    {
        config(['auth.api.secret_enabled' => false]);

        $this->authUser();

        $row = $this->rowCreateWithUser();

        $query = ['q' => $row->payload('url')];

        $this->post($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(200)
            ->assertExactJson([$row->only('id', 'name')]);

        $this->postJson($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(200)
            ->assertExactJson([$row->only('id', 'name')]);
    }

    /**
     * @return void
     */
    public function testPostNoSecretSuccess(): void
    {
        $this->authUser();

        $row = $this->rowCreateWithUser();

        $query = ['q' => $row->payload('url')];

        $this->postJsonAuthorized($query)
            ->assertStatus(200)
            ->assertExactJson([$row->only('id', 'name')]);

        $this->post($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(200)
            ->assertExactJson([$row->only('id', 'name')]);

        $this->postJson($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(200)
            ->assertExactJson([$row->only('id', 'name')]);
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

        $this->postAuthorized(['q' => $row->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([]);

        $this->postJsonAuthorized(['q' => $row->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([]);

        $row->shared = true;
        $row->save();

        $this->postAuthorized(['q' => $row->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([]);

        $this->postJsonAuthorized(['q' => $row->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([]);
    }

    /**
     * @return void
     */
    public function testPostArchivedFail(): void
    {
        $this->authUser();

        $row = $this->rowCreateWithUser();

        $query = ['q' => $row->payload('url')];

        $this->postJsonAuthorized($query)
            ->assertStatus(200)
            ->assertExactJson([$row->only('id', 'name')]);

        $this->post($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(200)
            ->assertExactJson([$row->only('id', 'name')]);

        $this->postJson($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(200)
            ->assertExactJson([$row->only('id', 'name')]);

        $row->archived = true;
        $row->save();

        $this->postJsonAuthorized($query)
            ->assertStatus(200)
            ->assertExactJson([]);

        $this->post($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(200)
            ->assertExactJson([]);

        $this->postJson($this->route(), $query, $this->apiAuthorization())
            ->assertStatus(200)
            ->assertExactJson([]);
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $user = $this->authUser();
        $row = $this->rowCreateWithUser();

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

        $first = $this->rowCreateWithUser();

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

        $second = $this->rowCreateWithUserAndTeam();

        $second->user_id = $this->factoryCreate(UserModel::class)->id;
        $second->shared = true;

        $second->save();

        $this->postAuthorized(['q' => $second->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([$first->only('id', 'name'), $second->only('id', 'name')]);

        $this->postJsonAuthorized(['q' => $second->payload('url')])
            ->assertStatus(200)
            ->assertExactJson([$first->only('id', 'name'), $second->only('id', 'name')]);

        $third = $this->rowCreateWithUserAndTeam();

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
