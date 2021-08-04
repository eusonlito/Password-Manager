<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\Team\Model\Team as TeamModel;

class UpdateTeam extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateTeam')) {
            return $response;
        }

        $this->meta('title', $this->row->name);

        return $this->page('user.update-team', [
            'row' => $this->row,
            'teams' => $this->teams(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function teams(): Collection
    {
        return TeamModel::list()
            ->withUsersByUserId($this->row->id)
            ->get()
            ->each(fn ($value) => $this->teamSelected($value))
            ->sortByDesc('selected');
    }

    /**
     * @param \App\Domains\Team\Model\Team $team
     *
     * @return void
     */
    protected function teamSelected(TeamModel $team): void
    {
        $team->selected = $team->users->contains('id', $this->row->id);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateTeam(): RedirectResponse
    {
        $this->action()->updateTeam();

        $this->sessionMessage('success', __('user-update-team.success'));

        return redirect()->route('user.update.team', $this->row->id);
    }
}
