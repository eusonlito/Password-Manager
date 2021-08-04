<?php declare(strict_types=1);

namespace App\Domains\App\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\App\Service\Type\Type as TypeService;
use App\Domains\Tag\Model\Tag as TagModel;
use App\Domains\Team\Model\Team as TeamModel;

class Create extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        if ($response = $this->actionPost('create')) {
            return $response;
        }

        $typeService = new TypeService();

        $this->meta('title', __('app-create.meta-title'));

        return $this->page('app.create', [
            'types' => $typeService->titles(),
            'type' => $typeService->selected($this->request->input('type')),
            'teams' => TeamModel::byUserAllowed($this->auth)->list()->get(),
            'tags' => TagModel::list()->get(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('app-create.success'));

        return redirect()->route('app.update', $this->row->id);
    }
}
