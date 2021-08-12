<?php declare(strict_types=1);

namespace App\Domains\App\Test\Feature;

use App\Domains\App\Model\App as Model;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\User\Model\User as UserModel;

class PayloadKey extends FeatureAbstract
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
        $user = $this->authUser();

        $row = $this->factoryCreate(Model::class);
        $row->user_id = $user->id;
        $row->save();

        $this->get($this->route(null, $row->id, 'user'))
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

        $this->post($this->route(null, $row->id, 'url'))
            ->assertStatus(200)
            ->assertExactJson(['value' => base64_encode('https://google.es')]);

        $this->post($this->route(null, $row->id, 'user'))
            ->assertStatus(200)
            ->assertExactJson(['value' => base64_encode('Google')]);

        $this->post($this->route(null, $row->id, 'password'))
            ->assertStatus(200)
            ->assertExactJson(['value' => base64_encode('123456')]);

        $this->post($this->route(null, $row->id, 'private'))
            ->assertStatus(200)
            ->assertExactJson(['value' => base64_encode('')]);

        $row = $this->rowCreateWithUserAndTeam();
        $row->user_id = $this->factoryCreate(UserModel::class)->id;
        $row->shared = true;
        $row->save();

        $this->post($this->route(null, $row->id, 'user'))
            ->assertStatus(200)
            ->assertExactJson(['value' => base64_encode('Google')]);
    }
}
