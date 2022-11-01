<?php declare(strict_types=1);

namespace App\Domains\Icon\Controller;

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

        $this->meta('title', __('icon-create.meta-title'));

        return $this->page('icon.create');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->action()->create();

        $this->sessionMessage('success', __('icon-create.success'));

        return redirect()->route('icon.index');
    }
}
