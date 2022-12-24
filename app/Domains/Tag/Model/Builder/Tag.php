<?php declare(strict_types=1);

namespace App\Domains\Tag\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class Tag extends BuilderAbstract
{
    /**
     * @param string $code
     *
     * @return self
     */
    public function byCode(string $code): self
    {
        return $this->where('code', $code);
    }

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
     * @param string $name
     *
     * @return self
     */
    public function byName(string $name): self
    {
        return $this->where('name', $name);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function withAppsCount(): self
    {
        return $this->withCount('apps');
    }
}
