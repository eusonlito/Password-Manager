<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\App\Model\App as AppModel;

class UpdateApp extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): Response
    {
        $this->row($id);

        $this->meta('title', $this->row->name);

        return $this->page('user.update-app', [
            'row' => $this->row,
            'apps' => $this->apps(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function apps(): Collection
    {
        return AppModel::byUserIdOrShared($this->auth->id)
            ->byUserAllowed($this->row)
            ->listByUser($this->row)
            ->get();
    }
}
