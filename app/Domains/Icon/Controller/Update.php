<?php declare(strict_types=1);

namespace App\Domains\Icon\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class Update extends ControllerAbstract
{
    /**
     * @param string $name
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(string $name): Response|RedirectResponse
    {
        $this->row($name);

        if ($response = $this->actionPost('update')) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', $this->row->name);

        return $this->page('icon.update', [
            'row' => $this->row,
            'apps_count' => $this->row->appsCount(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(): RedirectResponse
    {
        $this->row = $this->action()->update();

        $this->sessionMessage('success', __('icon-update.success'));

        return redirect()->route('icon.update', $this->row->name);
    }
}
