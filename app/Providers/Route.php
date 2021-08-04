<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route as RouteFacade;

class Route extends RouteServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->patterns();

        parent::boot();
    }

    /**
     * @return void
     */
    protected function patterns(): void
    {
        RouteFacade::pattern('id', '[0-9]+');
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        require base_path('app/Http/router.php');
    }
}
