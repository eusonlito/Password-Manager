<?php declare(strict_types=1);

namespace App\Domains\User\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\User\Model\User as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->json($this->factory()->fractal('api', Model::list()->get()));
    }
}
