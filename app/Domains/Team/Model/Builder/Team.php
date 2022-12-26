<?php declare(strict_types=1);

namespace App\Domains\Team\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;
use App\Domains\Team\Model\TeamUser as TeamUserModel;
use App\Domains\User\Model\User as UserModel;

class Team extends BuilderAbstract
{
    /**
     * @param string $code
     *
     * @return self
     */
    public function byCode(string $code): self
    {
        return $this->where('code', $code);
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function byName(string $name): self
    {
        return $this->where('name', $name);
    }

    /**
     * @param \App\Domains\User\Model\User $user
     *
     * @return self
     */
    public function byUserAllowed(UserModel $user): self
    {
        if ($user->admin) {
            return $this;
        }

        return $this->byUserId($user->id);
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function byUserId(int $user_id): self
    {
        return $this->whereIn('team.id', TeamUserModel::select('team_id')->where('user_id', $user_id));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('name', 'ASC');
    }

    /**
     * @param bool $default = true
     *
     * @return self
     */
    public function whereDefault(bool $default = true): self
    {
        return $this->where('default', $default);
    }

    /**
     * @return self
     */
    public function withAppsCount(): self
    {
        return $this->withCount('apps');
    }

    /**
     * @return self
     */
    public function withTeamsUsers(): self
    {
        return $this->with('teamsUsers');
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function withTeamsUsersByUserId(int $user_id): self
    {
        return $this->with(['teamsUsers' => fn ($q) => $q->where('user_id', $user_id)]);
    }

    /**
     * @return self
     */
    public function withTeamsUsersCount(): self
    {
        return $this->withCount('teamsUsers');
    }

    /**
     * @return self
     */
    public function withUsersCount(): self
    {
        return $this->withCount('users');
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function withUsersByUserId(int $user_id): self
    {
        return $this->with(['users' => fn ($q) => $q->where('user.id', $user_id)]);
    }
}
