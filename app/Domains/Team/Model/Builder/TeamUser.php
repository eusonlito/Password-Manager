<?php declare(strict_types=1);

namespace App\Domains\Team\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class TeamUser extends BuilderAbstract
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
     * @param int $user_id
     *
     * @return self
     */
    public function byUserId(int $user_id): self
    {
        return $this->where('user_id', $user_id);
    }

    /**
     * @return self
     */
    public function withTeam(): self
    {
        return $this->with('team');
    }
}
