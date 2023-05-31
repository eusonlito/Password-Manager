<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

use App\Domains\App\Model\App as AppModel;
use App\Domains\Shared\Test\Feature\FeatureAbstract;
use App\Domains\Team\Model\Team as TeamModel;

abstract class ControllerAbstract extends FeatureAbstract
{
    /**
     * @return \App\Domains\App\Model\App
     */
    protected function appCreateWithUser(): AppModel
    {
        $app = $this->factoryCreate(AppModel::class);
        $app->user_id = $this->authUser()->id;
        $app->save();

        return $app;
    }

    /**
     * @return \App\Domains\App\Model\App
     */
    protected function appCreateWithTeam(): AppModel
    {
        $user = $this->authUser();

        $team = $this->factoryCreate(TeamModel::class);
        $team->users()->sync([$user->id]);

        $app = $this->factoryCreate(AppModel::class);
        $app->teams()->sync([$team->id]);

        return $app;
    }

    /**
     * @return \App\Domains\App\Model\App
     */
    protected function appCreateWithUserAndTeam(): AppModel
    {
        $user = $this->authUser();

        $team = $this->factoryCreate(TeamModel::class);
        $team->users()->sync([$user->id]);

        $app = $this->factoryCreate(AppModel::class);
        $app->user_id = $user->id;
        $app->save();

        $app->teams()->sync([$team->id]);

        return $app;
    }

    /**
     * @return array
     */
    protected function apiAuthorization(): array
    {
        return ['Authorization' => $this->authUser()->api_key];
    }
}
