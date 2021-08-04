<?php declare(strict_types=1);

namespace App\Domains\Tag\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class Tag extends BuilderAbstract
{
    /**
     * @param array $list
     *
     * @return self
     */
    public function byIdsOrCodes(array $list): self
    {
        return $this->where(fn ($q) => $q->orWhereIn('id', $list)->orWhereIn('code', $list));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('name', 'ASC');
    }
}
