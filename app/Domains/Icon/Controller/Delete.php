<?php declare(strict_types=1);

namespace App\Domains\Icon\Controller;

use Illuminate\Http\RedirectResponse;

class Delete extends ControllerAbstract
{
    /**
     * @param string $name
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(string $name): RedirectResponse
    {
        $this->row($name);

        return $this->actionPost('delete') ?: redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function delete(): RedirectResponse
    {
        $this->action()->delete();

        $this->sessionMessage('success', __('icon-delete.success'));

        return redirect()->route('icon.index');
    }
}
