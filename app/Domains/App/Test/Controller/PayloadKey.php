<?php declare(strict_types=1);

namespace App\Domains\App\Test\Controller;

use App\Domains\App\Model\App as Model;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\User\Model\User as UserModel;

class PayloadKey extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'app.payload.key';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route(null, $this->factoryCreate(Model::class)->id, 'user'))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route(null, $this->factoryCreate(Model::class)->id, 'user'))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetFail(): void
    {
        $this->authUser();

        $this->get($this->route(null, $this->rowCreateWithUser()->id, 'user'))
            ->assertStatus(405);
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

        $this->post($this->route(null, $row->id, 'user'))
            ->assertStatus(404);

        $row->shared = true;
        $row->save();

        $this->post($this->route(null, $row->id, 'user'))
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $row = $this->rowCreateWithUser();

        $this->post($this->route(null, $row->id, uniqid()))
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUser();

        $row = $this->rowCreateWithUser();

        $row->shared = false;
        $row->editable = false;

        $row->save();

        $this->assertEquals($row->payload('url'), 'https://google.es');
        $this->assertEquals($row->payload('user'), 'Google');
        $this->assertEquals($row->payload('password'), '123456');

        $this->post($this->route(null, $row->id, 'url'))
            ->assertStatus(200)
            ->assertExactJson(['value' => $row->payloadEncoded('url')]);

        $this->post($this->route(null, $row->id, 'user'))
            ->assertStatus(200)
            ->assertExactJson(['value' => $row->payloadEncoded('user')]);

        $this->post($this->route(null, $row->id, 'password'))
            ->assertStatus(200)
            ->assertExactJson(['value' => $row->payloadEncoded('password')]);

        $this->post($this->route(null, $row->id, 'private'))
            ->assertStatus(200)
            ->assertExactJson(['value' => null]);

        $row = $this->rowCreateWithUserAndTeam();
        $row->user_id = $this->factoryCreate(UserModel::class)->id;
        $row->shared = true;
        $row->save();

        $this->post($this->route(null, $row->id, 'user'))
            ->assertStatus(200)
            ->assertExactJson(['value' => helper()->stringEncode('Google')]);
    }
}
