<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Controller;

use Illuminate\Http\RedirectResponse;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        return redirect()->route('app.index');
    }
}
