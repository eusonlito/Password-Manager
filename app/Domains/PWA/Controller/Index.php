<?php declare(strict_types=1);

namespace App\Domains\PWA\Controller;

use Illuminate\Http\Response;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        return $this->page('pwa.index');
    }
}
