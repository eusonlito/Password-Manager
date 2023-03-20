<?php declare(strict_types=1);

namespace App\Domains\App\Test\Controller;

use Illuminate\Http\UploadedFile;
use App\Domains\App\Model\App as Model;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\User\Model\User as UserModel;

class Create extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'app.create';

    /**
     * @var string
     */
    protected string $action = 'create';

    /**
     * @var array
     */
    protected array $validation = [
        'type' => ['bail', 'required', 'in:card,password,phone,ssh,server,text,user-password,website,wifi'],

        'name' => ['bail', 'required', 'string'],
        'icon' => ['bail', 'file', 'mimetypes:image/png'],
        'icon_reset' => ['bail', 'boolean'],

        'teams' => ['bail', 'array', 'required'],
        'tags' => ['bail', 'array'],

        'shared' => ['bail', 'boolean'],
        'editable' => ['bail', 'boolean'],

        'payload' => ['bail', 'array'],
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
    public function testGetSuccess(): void
    {
        $this->authUser();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.app.create');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUser();

        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.app.create');
    }

    /**
     * @return void
     */
    public function testPostEmptyWithActionFail(): void
    {
        $this->authUser();

        $this->post($this->route(), $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['type']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo name es requerido.');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo type es requerido.');

        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['type', 'name']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo teams es requerido.');
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $this->authUser();

        $data = $this->factoryWhitelist(Model::class);
        $data['payload'] = [];
        $data['type'] = uniqid();

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo type seleccionado es inválido.');

        $data = $this->factoryWhitelist(Model::class);
        $data['payload'] = [];
        $data['teams'] = [1];

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Es necesario seleccionar algún equipo.');

        $data = $this->factoryWhitelist(Model::class);
        $data['payload'] = [];
        $data['teams'] = [$this->factoryCreate(TeamModel::class)->id];

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('Es necesario seleccionar algún equipo.');

        $data = $this->factoryWhitelist(Model::class);
        $data['payload'] = [];
        $data['icon'] = uniqid();

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo icon debe ser un archivo.');

        $data = $this->factoryWhitelist(Model::class);
        $data['payload'] = [];
        $data['icon'] = UploadedFile::fake()->image('icon.jpg');

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo icon debe ser un archivo de tipo: image/png.');

        $data = $this->factoryWhitelist(Model::class);
        $data['payload'] = [];
        $data['icon'] = UploadedFile::fake()->create('icon.png', 150, 'application/pdf');

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo icon debe ser un archivo de tipo: image/png.');

        $data = $this->factoryWhitelist(Model::class);
        $data['teams'] = [1];

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.')
            ->assertSee('El campo payload debe ser un array.');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $user = $this->authUser();

        $team = $this->factoryCreate(TeamModel::class);
        $team->users()->sync([$user->id]);

        $data = $this->factoryWhitelist(Model::class);
        $data['payload'] = [1];
        $data['tags'] = ['Work', 'Shops'];
        $data['teams'] = [$team->id];

        $this->followingRedirects()
            ->post($this->route(), $data)
            ->assertStatus(200)
            ->assertSee('La aplicación ha sido creada correctamente')
            ->assertSee($data['name']);

        $row = $this->rowLast(Model::class);

        $this->assertEquals($row->name, $data['name']);
        $this->assertEquals($row->type, $data['type']);
        $this->assertEquals($row->shared, $data['shared']);
        $this->assertEquals($row->editable, $data['editable']);
        $this->assertEquals($row->teams()->count(), 1);
        $this->assertEquals($row->tags()->count(), 2);

        $row->user_id = $this->factoryCreate(UserModel::class)->id;
        $row->save();

        $this->get(route('app.update', $row->id))
            ->assertStatus(404);

        $row->shared = true;
        $row->editable = true;
        $row->save();

        $this->get(route('app.update', $row->id))
            ->assertStatus(200)
            ->assertViewIs('domains.app.update');

        $row->editable = false;
        $row->save();

        $this->get(route('app.update', $row->id))
            ->assertStatus(200)
            ->assertViewIs('domains.app.update-readonly');
    }

    /**
     * @return void
     */
    public function testPostTypeCardSuccess(): void
    {
        $this->postType('card', [
            'holder' => 'holder',
            'number' => 'number',
            'pin' => 'pin',
            'cvc' => 'cvc',
            'expires' => 'expires',
            'notes' => 'notes',
        ]);
    }

    /**
     * @return void
     */
    public function testPostTypePhoneSuccess(): void
    {
        $this->postType('phone', [
            'number' => 'number',
            'sim' => 'sim',
            'pin' => 'pin',
            'puk' => 'puk',
            'unlock' => 'unlock',
            'notes' => 'notes',
        ]);
    }

    /**
     * @return void
     */
    public function testPostTypeServerSuccess(): void
    {
        $this->postType('server', [
            'host' => 'host',
            'port' => 'port',
            'user' => 'user',
            'password' => 'password',
            'notes' => 'notes',
        ]);
    }

    /**
     * @return void
     */
    public function testPostTypeSSHSuccess(): void
    {
        $this->postType('ssh', [
            'password' => 'password',
            'public' => 'public',
            'private' => 'private',
            'notes' => 'notes',
        ]);
    }

    /**
     * @return void
     */
    public function testPostTypeTextSuccess(): void
    {
        $this->postType('text', [
            'text' => 'text',
        ]);
    }

    /**
     * @return void
     */
    public function testPostTypeWebsiteSuccess(): void
    {
        $icon = public_path('storage/app/host/google.es.png');

        if (is_file($icon)) {
            unlink($icon);
        }

        $this->postType('website', [
            'url' => 'https://google.es',
            'user' => 'user',
            'password' => 'password',
            'recovery' => 'recovery',
            'notes' => 'notes',
        ]);

        $this->assertFileExists($icon);
    }

    /**
     * @return void
     */
    public function testPostTypeWifiSuccess(): void
    {
        $this->postType('wifi', [
            'name' => 'name',
            'password' => 'password',
            'notes' => 'notes',
        ]);
    }

    /**
     * @param string $type
     * @param array $payload
     *
     * @return void
     */
    protected function postType(string $type, array $payload): void
    {
        $user = $this->authUser();

        $team = $this->factoryCreate(TeamModel::class);
        $team->users()->sync([$user->id]);

        $data = $this->factoryWhitelist(Model::class);
        $data['type'] = $type;
        $data['teams'] = [$team->id];
        $data['payload'] = $payload;

        $this->followingRedirects()
            ->post($this->route(), $data)
            ->assertStatus(200)
            ->assertSee('La aplicación ha sido creada correctamente')
            ->assertSee($data['name']);

        $row = $this->rowLast(Model::class);

        foreach ($payload as $key => $value) {
            $this->assertEquals($row->payload($key), $value);
        }
    }
}
