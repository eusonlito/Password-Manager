<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Controller;

use Illuminate\Http\Response;

class OpcachePreload extends ControllerAbstract
{
    /**
     * @return void
     */
    public function __invoke(): void
    {
        $this->action()->opcachePreload();
    }
}
