<?php declare(strict_types=1);

namespace App\Domains\Tag\Test\Controller;

use App\Domains\Tag\Model\Tag as Model;

class Create extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'tag.create';

    /**
     * @var string
     */
    protected string $action = 'create';

    /**
     * @var array
     */
    protected array $validation = [
        'name' => ['bail', 'required', 'string'],
        'color' => ['bail', 'string', 'required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
    ];

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetNotAdminFail(): void
    {
        $this->authUserAdmin(false);

        $this->get($this->route())
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testPostNotAdminFail(): void
    {
        $this->authUserAdmin(false);

        $this->post($this->route())
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.tag.create');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.tag.create');
    }

    /**
     * @return void
     */
    public function testPostEmptyWithActionFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(), $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostWithoutActionSuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name'], false))
            ->assertStatus(200)
            ->assertViewIs('domains.tag.create');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $data = $this->factoryMake(Model::class)->toArray();

        $this->followingRedirects()
            ->post($this->route(), $data + $this->action())
            ->assertStatus(200)
            ->assertSee('La Etiqueta ha sido creada correctamente')
            ->assertSee($data['name']);

        $row = $this->rowLast(Model::class);

        $this->assertEquals($row->name, $data['name']);
        $this->assertEquals($row->color, $data['color']);

        $new = $this->factoryMake(Model::class)->toArray();
        $new['name'] = $row->name;

        $this->post($this->route(), $new + $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El código ya existe para otra Etiqueta');
    }
}
