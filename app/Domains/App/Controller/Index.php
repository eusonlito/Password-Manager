<?php declare(strict_types=1);

namespace App\Domains\App\Controller;

use Illuminate\Http\Response;
use App\Domains\App\Service\Type\Type as TypeService;
use App\Domains\Tag\Model\Tag as TagModel;
use App\Domains\Team\Model\Team as TeamModel;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->filters();
        $this->list();

        $this->meta('title', __('app-index.meta-title'));

        if ($this->isEmpty()) {
            return $this->page('app.empty');
        }

        return $this->page('app.index', [
            'list' => $this->list,
            'types' => (new TypeService())->titles(),
            'tags' => TagModel::list()->get(),
            'teams' => TeamModel::byUserAllowed($this->auth)->list()->get(),
            'filters' => $this->request->input(),
        ]);
    }

    /**
     * @return bool
     */
    protected function isEmpty(): bool
    {
        return $this->list->isEmpty() && empty(array_filter($this->request->input()));
    }

    /**
     * @return void
     */
    protected function filters(): void
    {
        $this->request->merge([
            'type' => (string)$this->request->input('type'),
            'tag' => (string)$this->request->input('tag'),
            'team' => (string)$this->request->input('team'),
            'shared' => $this->request->input('shared'),
            'archived' => $this->request->input('archived'),
        ]);
    }
}
