<?php declare(strict_types=1);

namespace App\Domains\Tag\Controller;

use Illuminate\Http\Response;
use App\Domains\Tag\Model\Tag as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('tag-index.meta-title'));

        return $this->page('tag.index', [
            'list' => Model::list()->withAppsCount()->get(),
        ]);
    }
}
