<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

use App\Domains\User\Model\User as Model;
use App\Exceptions\ValidatorException;
use App\Services\Validator\Exception as ValidatorServiceException;

class UpdateBoolean extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.update.boolean';

    /**
     * @var string
     */
    protected string $action = 'updateBoolean';

    /**
     * @var array
     */
    protected array $validation = [
        'column' => 'bail|required|string|in:admin,readonly,enabled',
    ];

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route(null, 1, 'enabled'))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route(null, 1, 'enabled'))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetNoAdminFail(): void
    {
        $this->get($this->route(null, $this->authUserAdmin(false)->id, 'enabled'))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostNoAdminFail(): void
    {
        $this->post($this->route(null, $this->authUserAdmin(false)->id, 'enabled'))
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testGetFail(): void
    {
        $this->authUserAdmin();

        $this->get($this->route(null, $this->factoryCreate(Model::class)->id, 'enabled'))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $this->authUserAdmin();

        $this->postJson($this->route(null, $this->factoryCreate(Model::class)->id, uniqid()))
            ->assertStatus(422)
            ->assertJson(['message' => 'El campo column seleccionado es inválido.']);

        try {
            $this->post($this->route(null, $this->factoryCreate(Model::class)->id, uniqid()))
                ->assertStatus(422)
                ->assertJson(['message' => 'El campo column seleccionado es inválido.']);
        } catch (ValidatorServiceException $e) {
            $this->assertEquals($e->getMessage(), 'El campo column seleccionado es inválido.');
        }
    }

    /**
     * @return void
     */
    public function testPostSelfFail(): void
    {
        $user = $this->authUserAdmin();

        $this->postJson($this->route(null, $user->id, 'enabled'))
            ->assertStatus(422)
            ->assertJson(['message' => 'No es posible desactivar a tu propio usuario']);

        $this->postJson($this->route(null, $user->id, 'admin'))
            ->assertStatus(422)
            ->assertJson(['message' => 'No es posible desactivar la opción de administrador de tu propio usuario']);

        $this->postJson($this->route(null, $user->id, 'readonly'))
            ->assertStatus(422)
            ->assertJson(['message' => 'No es posible marcar la opción de sólo lectura para tu propio usuario']);

        try {
            $this->post($this->route(null, $user->id, 'enabled'))
                ->assertStatus(422)
                ->assertJson(['message' => 'No es posible desactivar a tu propio usuario']);
        } catch (ValidatorException $e) {
            $this->assertEquals($e->getMessage(), 'No es posible desactivar a tu propio usuario');
        }

        try {
            $this->post($this->route(null, $user->id, 'admin'))
                ->assertStatus(422)
                ->assertJson(['message' => 'No es posible desactivar la opción de administrador de tu propio usuario']);
        } catch (ValidatorException $e) {
            $this->assertEquals($e->getMessage(), 'No es posible desactivar la opción de administrador de tu propio usuario');
        }

        try {
            $this->post($this->route(null, $user->id, 'readonly'))
                ->assertStatus(422)
                ->assertJson(['message' => 'No es posible marcar la opción de sólo lectura para tu propio usuario']);
        } catch (ValidatorException $e) {
            $this->assertEquals($e->getMessage(), 'No es posible marcar la opción de sólo lectura para tu propio usuario');
        }
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $user = $this->factoryCreate(Model::class);

        $user->admin = true;
        $user->readonly = true;
        $user->enabled = true;
        $user->save();

        $this->post($this->route(null, $user->id, 'admin'))
            ->assertStatus(200)
            ->assertJson([
                'admin' => false,
                'readonly' => true,
                'enabled' => true,
            ]);

        $user = $this->userLast();

        $this->assertEquals($user->admin, false);
        $this->assertEquals($user->readonly, true);
        $this->assertEquals($user->enabled, true);

        $this->post($this->route(null, $user->id, 'readonly'))
            ->assertStatus(200)
            ->assertJson([
                'admin' => false,
                'readonly' => false,
                'enabled' => true,
            ]);

        $user = $this->userLast();

        $this->assertEquals($user->admin, false);
        $this->assertEquals($user->readonly, false);
        $this->assertEquals($user->enabled, true);

        $this->post($this->route(null, $user->id, 'enabled'))
            ->assertStatus(200)
            ->assertJson([
                'admin' => false,
                'readonly' => false,
                'enabled' => false,
            ]);

        $user = $this->userLast();

        $this->assertEquals($user->admin, false);
        $this->assertEquals($user->readonly, false);
        $this->assertEquals($user->enabled, false);
    }
}