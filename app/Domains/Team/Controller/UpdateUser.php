<?php declare(strict_types=1);

namespace App\Domains\Team\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\Team\Model\TeamUser as TeamUserModel;
use App\Domains\User\Model\User as UserModel;

class UpdateUser extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateUser')) {
            return $response;
        }

        $this->meta('title', $this->row->name);

        return $this->page('team.update-user', [
            'row' => $this->row,
            'users' => $this->users(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function users(): Collection
    {
        $teamsUsers = TeamUserModel::with('team')->get()->groupBy('user_id');

        return UserModel::simple()
            ->get()
            ->each(fn ($value) => $this->userSelected($value, $teamsUsers))
            ->sortByDesc('selected');
    }

    /**
     * @param \App\Domains\User\Model\User $user
     * @param \Illuminate\Support\Collection $teamsUsers
     *
     * @return void
     */
    protected function userSelected(UserModel $user, Collection $teamsUsers): void
    {
        $user->teams = $teamsUsers->get($user->id, collect())->pluck('team');
        $user->selected = $user->teams->contains('id', $this->row->id);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateUser(): RedirectResponse
    {
        $this->action()->updateUser();

        $this->sessionMessage('success', __('team-update-user.success'));

        return redirect()->route('team.update.user', $this->row->id);
    }
}
