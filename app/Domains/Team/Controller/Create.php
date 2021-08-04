<?php declare(strict_types=1);

namespace App\Domains\Team\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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

        $this->meta('title', __('team-create.meta-title'));

        return $this->page('team.create');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('team-create.success'));

        return redirect()->route('team.update', $this->row->id);
    }
}
