<?php declare(strict_types=1);

namespace App\Domains\App\ControllerApi;

use Illuminate\Http\JsonResponse;

class Search extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->json($this->factory()->fractal('api', $this->action()->search()));
    }
}
