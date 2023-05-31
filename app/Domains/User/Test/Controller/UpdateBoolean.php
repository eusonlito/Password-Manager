<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

use App\Domains\User\Model\User as Model;
use App\Exceptions\ValidatorException;
use App\Services\Validator\Exception as ValidatorServiceException;

class UpdateBoolean extends ControllerAbstract
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
        $this->get($this->route(null, $this->factoryCreate(Model::class)->id, 'enabled'))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route(null, $this->factoryCreate(Model::class)->id, 'enabled'))
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
        $row = $this->authUserAdmin();

        $this->postJson($this->route(null, $row->id, 'enabled'))
            ->assertStatus(422)
            ->assertJson(['message' => 'No es posible desactivar a tu propio usuario']);

        $this->postJson($this->route(null, $row->id, 'admin'))
            ->assertStatus(422)
            ->assertJson(['message' => 'No es posible desactivar la opción de administrador de tu propio usuario']);

        $this->postJson($this->route(null, $row->id, 'readonly'))
            ->assertStatus(422)
            ->assertJson(['message' => 'No es posible marcar la opción de sólo lectura para tu propio usuario']);

        try {
            $this->post($this->route(null, $row->id, 'enabled'))
                ->assertStatus(422)
                ->assertJson(['message' => 'No es posible desactivar a tu propio usuario']);
        } catch (ValidatorException $e) {
            $this->assertEquals($e->getMessage(), 'No es posible desactivar a tu propio usuario');
        }

        try {
            $this->post($this->route(null, $row->id, 'admin'))
                ->assertStatus(422)
                ->assertJson(['message' => 'No es posible desactivar la opción de administrador de tu propio usuario']);
        } catch (ValidatorException $e) {
            $this->assertEquals($e->getMessage(), 'No es posible desactivar la opción de administrador de tu propio usuario');
        }

        try {
            $this->post($this->route(null, $row->id, 'readonly'))
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

        $row = $this->factoryCreate(Model::class);

        $row->admin = true;
        $row->readonly = true;
        $row->enabled = true;
        $row->save();

        $this->post($this->route(null, $row->id, 'admin'))
            ->assertStatus(200)
            ->assertJson([
                'admin' => false,
                'readonly' => true,
                'enabled' => true,
            ]);

        $row = $this->userLast();

        $this->assertEquals($row->admin, false);
        $this->assertEquals($row->readonly, true);
        $this->assertEquals($row->enabled, true);

        $this->post($this->route(null, $row->id, 'readonly'))
            ->assertStatus(200)
            ->assertJson([
                'admin' => false,
                'readonly' => false,
                'enabled' => true,
            ]);

        $row = $this->userLast();

        $this->assertEquals($row->admin, false);
        $this->assertEquals($row->readonly, false);
        $this->assertEquals($row->enabled, true);

        $this->post($this->route(null, $row->id, 'enabled'))
            ->assertStatus(200)
            ->assertJson([
                'admin' => false,
                'readonly' => false,
                'enabled' => false,
            ]);

        $row = $this->userLast();

        $this->assertEquals($row->admin, false);
        $this->assertEquals($row->readonly, false);
        $this->assertEquals($row->enabled, false);

        $this->post($this->route(null, $row->id, 'admin'))
            ->assertStatus(200)
            ->assertJson([
                'admin' => true,
                'readonly' => false,
                'enabled' => false,
            ]);

        $row = $this->userLast();

        $this->assertEquals($row->admin, true);
        $this->assertEquals($row->readonly, false);
        $this->assertEquals($row->enabled, false);

        $this->post($this->route(null, $row->id, 'readonly'))
            ->assertStatus(200)
            ->assertJson([
                'admin' => true,
                'readonly' => true,
                'enabled' => false,
            ]);

        $row = $this->userLast();

        $this->assertEquals($row->admin, true);
        $this->assertEquals($row->readonly, true);
        $this->assertEquals($row->enabled, false);

        $this->post($this->route(null, $row->id, 'enabled'))
            ->assertStatus(200)
            ->assertJson([
                'admin' => true,
                'readonly' => true,
                'enabled' => true,
            ]);

        $row = $this->userLast();

        $this->assertEquals($row->admin, true);
        $this->assertEquals($row->readonly, true);
        $this->assertEquals($row->enabled, true);
    }
}
