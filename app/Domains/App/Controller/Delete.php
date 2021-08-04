<?php declare(strict_types=1);

namespace App\Domains\App\Controller;

use Illuminate\Http\RedirectResponse;

class Delete extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): RedirectResponse
    {
        $this->row($id);

        return $this->actionPost('delete') ?: redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function delete(): RedirectResponse
    {
        $this->action()->delete();

        $this->sessionMessage('success', __('app-delete.success'));

        return redirect()->route('app.index');
    }
}
