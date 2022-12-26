<?php declare(strict_types=1);

namespace App\Domains\Team\Controller;

use Illuminate\Http\Response;
use App\Domains\Team\Model\Team as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('team-index.meta-title'));

        return $this->page('team.index', [
            'list' => Model::list()->withAppsCount()->withUsersCount()->get(),
        ]);
    }
}
