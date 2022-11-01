<?php declare(strict_types=1);

namespace App\Domains\Icon\Controller;

use Illuminate\Http\Response;
use App\Domains\Icon\Service\Loader;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('icon-index.meta-title'));

        return $this->page('icon.index', [
            'list' => Loader::new()->all(),
        ]);
    }
}
