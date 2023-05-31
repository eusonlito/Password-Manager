<?php declare(strict_types=1);

namespace App\Domains\App\Test\Controller;

use App\Domains\App\Model\App as Model;
use App\Domains\Shared\Test\Feature\FeatureAbstract;
use App\Domains\Team\Model\Team as TeamModel;

abstract class ControllerAbstract extends FeatureAbstract
{
    /**
     * @return \App\Domains\App\Model\App
     */
    protected function rowCreateWithUser(): Model
    {
        $row = $this->factoryCreate(Model::class);
        $row->user_id = $this->authUser()->id;
        $row->save();

        return $row;
    }

    /**
     * @return \App\Domains\App\Model\App
     */
    protected function rowCreateWithTeam(): Model
    {
        $user = $this->authUser();

        $team = $this->factoryCreate(TeamModel::class);
        $team->users()->sync([$user->id]);

        $row = $this->factoryCreate(Model::class);
        $row->teams()->sync([$team->id]);

        return $row;
    }

    /**
     * @return \App\Domains\App\Model\App
     */
    protected function rowCreateWithUserAndTeam(): Model
    {
        $user = $this->authUser();

        $team = $this->factoryCreate(TeamModel::class);
        $team->users()->sync([$user->id]);

        $row = $this->factoryCreate(Model::class);
        $row->user_id = $user->id;
        $row->save();

        $row->teams()->sync([$team->id]);

        return $row;
    }

    /**
     * @return array
     */
    protected function apiAuthorization(): array
    {
        return ['Authorization' => $this->authUser()->api_key];
    }
}
