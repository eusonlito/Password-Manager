<?php declare(strict_types=1);

namespace App\Domains\Team\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class TeamApp extends BuilderAbstract
{
    /**
     * @param int $team_id
     *
     * @return self
     */
    public function byTeamId(int $team_id): self
    {
        return $this->where('team_id', $team_id);
    }

    /**
     * @param int $app_id
     *
     * @return self
     */
    public function byUserId(int $app_id): self
    {
        return $this->where('app_id', $app_id);
    }

    /**
     * @return self
     */
    public function withTeam(): self
    {
        return $this->with('team');
    }
}
