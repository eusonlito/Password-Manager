<?php declare(strict_types=1);

namespace App\Domains\File\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class File extends BuilderAbstract
{
    /**
     * @param int $app_id
     *
     * @return self
     */
    public function byAppId(int $app_id): self
    {
        return $this->where('app_id', $app_id);
    }

    /**
     * @return self
     */
    public function withApp(): self
    {
        return $this->with('app');
    }
}
