<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class View extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->blade();
    }

    /**
     * @return void
     */
    protected function blade()
    {
        Blade::directive('asset', fn(string $expression) => "<?= \App\Services\Html\Html::asset($expression); ?>");

        Blade::directive('image', fn(string $expression) => "<?= \App\Services\Html\Html::image($expression); ?>");

        Blade::directive('icon', fn(string $expression) => "<?= \App\Services\Html\Html::icon($expression); ?>");

        Blade::directive('datetime', fn(string $expression) => "<?= helper()->dateLocal($expression); ?>");

        Blade::directive('number', fn(string $expression) => "<?= \App\Services\Html\Html::number($expression); ?>");

        Blade::directive('status', fn(string $expression) => "<?= \App\Services\Html\Html::status($expression); ?>");

        Blade::directive('statusString', fn(string $expression) => "<?= \App\Services\Html\Html::statusString($expression); ?>");

        Blade::directive('statusNumber', fn(string $expression) => "<?= \App\Services\Html\Html::statusNumber($expression); ?>");

        Blade::directive('color', fn(string $expression) => "<?= \App\Services\Html\Html::color($expression); ?>");

        Blade::directive('jsonPretty', fn(string $expression) => "<?= \App\Services\Html\Html::jsonPretty($expression); ?>");

        Blade::directive('hidden', fn(string $expression) => "<?= \App\Services\Html\Html::hidden($expression); ?>");

        Blade::directive('query', fn(string $expression) => "<?= \App\Services\Html\Html::query($expression); ?>");
    }
}
