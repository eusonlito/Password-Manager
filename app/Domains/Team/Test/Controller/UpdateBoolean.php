<?php declare(strict_types=1);

namespace App\Domains\Team\Test\Controller;

use App\Domains\Team\Model\Team as Model;
use App\Services\Validator\Exception as ValidatorServiceException;

class UpdateBoolean extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'team.update.boolean';

    /**
     * @var string
     */
    protected string $action = 'updateBoolean';

    /**
     * @var array
     */
    protected array $validation = [
        'column' => 'bail|required|string|in:default',
    ];

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route(null, $this->factoryCreate(Model::class)->id, 'default'))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route(null, $this->factoryCreate(Model::class)->id, 'default'))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetNoAdminFail(): void
    {
        $this->authUserAdmin(false);

        $this->get($this->route(null, $this->factoryCreate(Model::class)->id, 'default'))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostNoAdminFail(): void
    {
        $this->authUserAdmin(false);

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id, 'default'))
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testGetFail(): void
    {
        $this->authUserAdmin();

        $this->get($this->route(null, $this->factoryCreate(Model::class)->id, 'default'))
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
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $row = $this->factoryCreate(Model::class);

        $row->default = true;
        $row->save();

        $this->post($this->route(null, $row->id, 'default'))
            ->assertStatus(200)
            ->assertJson(['default' => false]);

        $this->assertEquals($this->rowLast(Model::class)->default, false);

        $this->post($this->route(null, $row->id, 'default'))
            ->assertStatus(200)
            ->assertJson(['default' => true]);

        $this->assertEquals($this->rowLast(Model::class)->default, true);
    }
}
