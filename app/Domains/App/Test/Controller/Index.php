<?php declare(strict_types=1);

namespace App\Domains\App\Test\Controller;

use App\Domains\App\Model\App as Model;
use App\Domains\User\Model\User as UserModel;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'app.index';

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
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testGetMineSuccess(): void
    {
        $user = $this->authUser();

        $row = $this->factoryCreate(Model::class);
        $row->shared = true;
        $row->editable = true;
        $row->user_id = $user->id;
        $row->save();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertSee($row->name);

        $row->shared = false;
        $row->editable = false;
        $row->save();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertSee($row->name);
    }

    /**
     * @return void
     */
    public function testGetOthersSuccess(): void
    {
        $this->authUser();

        $row = $this->rowCreateWithUserAndTeam();
        $row->shared = false;
        $row->editable = false;
        $row->user_id = $this->factoryCreate(UserModel::class)->id;
        $row->save();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertDontSee($row->name);

        $row->editable = true;
        $row->save();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertDontSee($row->name);

        $row->shared = true;
        $row->save();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertSee($row->name);
    }

    /**
     * @return void
     */
    public function testGetOthersWithoutTeamSuccess(): void
    {
        $this->authUser();

        $row = $this->rowCreateWithUserAndTeam();
        $row->shared = true;
        $row->editable = true;
        $row->user_id = $this->factoryCreate(UserModel::class)->id;
        $row->save();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertSee($row->name);

        $row->teamsPivot()->delete();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertDontSee($row->name);
    }

    /**
     * @return void
     */
    public function testGetArchivedSuccess(): void
    {
        $user = $this->authUser();

        $row = $this->factoryCreate(Model::class);
        $row->user_id = $user->id;
        $row->save();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertSee($row->name);

        $row->archived = true;
        $row->save();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertDontSee($row->name);

        $this->get($this->route().'?archived=0')
            ->assertStatus(200)
            ->assertDontSee($row->name);

        $this->get($this->route().'?archived=1')
            ->assertStatus(200)
            ->assertSee($row->name);

        $this->get($this->route().'?archived=all')
            ->assertStatus(200)
            ->assertSee($row->name);
    }

    /**
     * @return void
     */
    public function testGetOthersWithoutUserTeamSuccess(): void
    {
        $user = $this->authUser();

        $row = $this->rowCreateWithUserAndTeam();
        $row->shared = true;
        $row->editable = true;
        $row->user_id = $this->factoryCreate(UserModel::class)->id;
        $row->save();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertSee($row->name);

        $user->teamsPivot()->delete();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertDontSee($row->name);
    }
}
