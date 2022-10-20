<?php declare(strict_types=1);

namespace App\Domains\App\Controller;

use Illuminate\Http\Response;

class Export extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        if ($response = $this->actionPost('export')) {
            return $response;
        }

        $this->meta('title', __('app-export.meta-title'));

        return $this->page('app.export');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    protected function export(): Response
    {
        return response()->make($this->action()->export(), 200, [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="password-manager-apps.zip"',
        ]);
    }
}
