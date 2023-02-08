<?php declare(strict_types=1);

namespace App\Domains\User\Test\ControllerApi;

class Middleware extends ControllerApiAbstract
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

        $this->postJsonAuthorized($this->route())
            ->assertStatus(401)
            ->assertExactJson(json_decode('{"code":401,"status":"unauthorized","message":"Unauthorized"}', true));
    }

    /**
     * @return void
     */
    public function testPostSecretSuccess(): void
    {
        $this->authUserAdmin();

        $this->postJsonAuthorized($this->route())
            ->assertStatus(200);

        $this->post($this->route(), [], $this->apiAuthorization())
            ->assertStatus(200);

        $this->postJson($this->route(), [], $this->apiAuthorization())
            ->assertStatus(200);
    }
}
