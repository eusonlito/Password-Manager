<?php declare(strict_types=1);

namespace App\Domains\Tag\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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

        if ($response = $this->actionPost('update')) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', $this->row->name);

        return $this->page('tag.update', [
            'row' => $this->row,
            'apps_count' => $this->row->apps()->count(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(): RedirectResponse
    {
        $this->row = $this->action()->update();

        $this->sessionMessage('success', __('tag-update.success'));

        return redirect()->route('tag.update', $this->row->id);
    }
}
