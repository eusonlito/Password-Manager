<?php declare(strict_types=1);

namespace App\Domains\App\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;
use App\Domains\Tag\Model\Tag as TagModel;
use App\Domains\Tag\Model\TagApp as TagAppModel;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\Team\Model\TeamApp as TeamAppModel;
use App\Domains\Team\Model\TeamUser as TeamUserModel;
use App\Domains\User\Model\User as UserModel;

class App extends BuilderAbstract
{
    /**
     * @param string $icon
     *
     * @return self
     */
    public function byIcon(string $icon): self
    {
        return $this->where('icon', $icon);
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
     * @param string $code
     *
     * @return self
     */
    public function byTeamCode(string $code): self
    {
        return $this->whereIn('id', TeamAppModel::select('app_id')->whereIn('team_id', TeamModel::select('id')->where('code', $code)));
    }

    /**
     * @param string $code
     *
     * @return self
     */
    public function byTagCode(string $code): self
    {
        return $this->whereIn('id', TagAppModel::select('app_id')->whereIn('tag_id', TagModel::select('id')->where('code', $code)));
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function byType(string $type): self
    {
        return $this->where('type', $type);
    }

    /**
     * @param \App\Domains\User\Model\User $user
     *
     * @return self
     */
    public function byUserAllowed(UserModel $user): self
    {
        if ($user->admin) {
            return $this->byUserIdOrShared($user->id);
        }

        return $this->where(static fn ($q) => $q->where('user_id', $user->id)->orWhere(
            static fn ($q) => $q->where('shared', true)->byUserIdTeams($user->id)
        ));
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
     * @param int $user_id
     *
     * @return self
     */
    public function byUserIdOrShared(int $user_id): self
    {
        return $this->where(static fn ($q) => $q->where('user_id', $user_id)->orWhere('shared', true));
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function byUserIdTeams(int $user_id): self
    {
        return $this->whereIn('id', TeamAppModel::select('app_id')->whereIn('team_id', TeamUserModel::select('team_id')->where('user_id', $user_id)));
    }

    /**
     * @param array $filters
     *
     * @return self
     */
    public function filter(array $filters): self
    {
        if ($filters['type'] ?? false) {
            $this->where('type', $filters['type']);
        }

        if ($filters['team'] ?? false) {
            $this->byTeamCode($filters['team']);
        }

        if ($filters['tag'] ?? false) {
            $this->byTagCode($filters['tag']);
        }

        if (strlen($filter = $filters['shared'] ?? '')) {
            $this->whereShared((bool)$filter);
        }

        $archived = $filters['archived'] ?? '';

        if (strlen($archived) && ($archived !== 'all')) {
            $this->whereArchived((bool)$archived);
        } elseif ($archived !== 'all') {
            $this->whereArchived(false);
        }

        return $this;
    }

    /**
     * @param string $search
     *
     * @return self
     */
    public function search(string $search): self
    {
        return $this->searchLike('name', $search);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('updated_at', 'DESC')->with('tags');
    }

    /**
     * @param \App\Domains\User\Model\User $user
     *
     * @return self
     */
    public function listByUser(UserModel $user): self
    {
        return $this->orderBy('updated_at', 'DESC')
            ->with('tags')
            ->with(['teams' => static fn ($q) => $q->byUserAllowed($user)]);
    }

    /**
     * @return self
     */
    public function orderByName(): self
    {
        return $this->orderBy('name', 'ASC');
    }

    /**
     * @param \App\Domains\User\Model\User $user
     * @param bool $shared
     *
     * @return self
     */
    public function export(UserModel $user, bool $shared): self
    {
        return $this->when(
            $shared,
            static fn ($q) => $q->byUserAllowed($user),
            static fn ($q) => $q->byUserId($user->id)
        );
    }

    /**
     * @param bool $shared = true
     *
     * @return self
     */
    public function whereShared(bool $shared = true): self
    {
        return $this->where('shared', $shared);
    }

    /**
     * @param bool $archived = false
     *
     * @return self
     */
    public function whereArchived(bool $archived = false): self
    {
        return $this->where('archived', $archived);
    }
}
