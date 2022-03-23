<?php declare(strict_types=1);

namespace App\Domains\User\ControllerApi;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Domains\App\Model\App as AppModel;

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

        $this->row->setRelation('apps', $this->apps());

        return $this->json($this->factory()->fractal('apiDetail', $this->row));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function apps(): Collection
    {
        return AppModel::select('id', 'name')
            ->byUserIdOrShared($this->auth->id)
            ->byUserAllowed($this->row)
            ->listByUser($this->row)
            ->get();
    }
}
