<?php declare(strict_types=1);

namespace App\Domains\Log\Controller;

use Illuminate\Http\Response;
use App\Domains\Log\Model\Log as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('log-index.meta-title'));

        return $this->page('log.index', [
            'list' => Model::list()->get(),
        ]);
    }
}
