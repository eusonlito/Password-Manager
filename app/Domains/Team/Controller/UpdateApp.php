<?php declare(strict_types=1);

namespace App\Domains\Team\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\Team\Model\TeamApp as TeamAppModel;
use App\Domains\App\Model\App as AppModel;

class UpdateApp extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateApp')) {
            return $response;
        }

        $this->meta('title', $this->row->name);

        return $this->page('team.update-app', [
            'row' => $this->row,
            'apps' => $this->apps(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function apps(): Collection
    {
        $teamsApps = TeamAppModel::with('team')->get()->groupBy('app_id');

        return AppModel::whereShared(true)
            ->get()
            ->each(fn ($value) => $this->appSelected($value, $teamsApps))
            ->sortByDesc('selected');
    }

    /**
     * @param \App\Domains\App\Model\App $app
     * @param \Illuminate\Support\Collection $teamsApps
     *
     * @return void
     */
    protected function appSelected(AppModel $app, Collection $teamsApps): void
    {
        $app->teams = $teamsApps->get($app->id, collect())->pluck('team');
        $app->selected = $app->teams->contains('id', $this->row->id);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateApp(): RedirectResponse
    {
        $this->action()->updateApp();

        $this->sessionMessage('success', __('team-update-app.success'));

        return redirect()->route('team.update.app', $this->row->id);
    }
}
