<?php declare(strict_types=1);

namespace App\Domains\App\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\App\Service\Type\Type as TypeService;
use App\Domains\Tag\Model\Tag as TagModel;
use App\Domains\Team\Model\Team as TeamModel;

class Update extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($this->row->canEdit($this->auth) === false) {
            return $this->readonly();
        }

        if ($response = $this->actionPost('update')) {
            return $response;
        }

        $this->requestMergeWithRow(['payload' => $this->request->input('payload') ?: $this->row->payload()]);

        $this->actionCall('view');

        $this->meta('title', $this->row->name);

        return $this->render();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    protected function render(): Response
    {
        $typeService = new TypeService();

        return $this->page('app.update', [
            'row' => $this->row,
            'image_search' => $this->imageSearch(),
            'types' => $typeService->titles(),
            'type' => $typeService->selected($this->request->input('type')),
            'teams' => TeamModel::byUserAllowed($this->auth)->list()->get(),
            'tags' => TagModel::list()->get(),
            'files' => $this->row->files,
        ]);
    }

    /**
     * @return string
     */
    protected function imageSearch(): string
    {
        if ($url = $this->row->payload('url')) {
            return helper()->urlDomain($url);
        }

        return explode(' ', $this->row->name)[0];
    }

    /**
     * @return \Illuminate\Http\Response
     */
    protected function readonly(): Response
    {
        $this->requestMergeWithRow(['payload' => $this->row->payload()]);

        $this->meta('title', $this->row->name);

        return $this->page('app.update-readonly', [
            'row' => $this->row,
            'tags' => TagModel::list()->get(),
        ]);
    }

    /**
     * @return void
     */
    protected function view(): void
    {
        $this->action()->view();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(): RedirectResponse
    {
        $this->row = $this->action()->update();

        $this->sessionMessage('success', __('app-update.success'));

        return redirect()->route('app.update', $this->row->id);
    }
}
