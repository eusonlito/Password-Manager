<?php declare(strict_types=1);

namespace App\Domains\User\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\User\Model\User as Model;

class Detail extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $this->row($id);

        $this->row->setRelation('apps', AppModel::byUserAllowed($this->auth)->listByUser($this->row)->get());

        return $this->json($this->factory()->fractal('apiDetail', $this->row));
    }
}
