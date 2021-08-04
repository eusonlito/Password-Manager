<?php declare(strict_types=1);

namespace App\Domains\Shared\Model\Builder;

use Illuminate\Database\Eloquent\Builder;

abstract class BuilderAbstract extends Builder
{
    /**
     * @param int $id
     *
     * @return self
     */
    public function byId(int $id): self
    {
        return $this->where('id', $id);
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function byIdNot(int $id): self
    {
        return $this->where('id', '!=', $id);
    }

    /**
     * @param array $ids
     *
     * @return self
     */
    public function byIds(array $ids): self
    {
        return $this->whereIn('id', array_unique(array_map('intval', $ids)));
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function byUserId(int $user_id): self
    {
        return $this->where('user_id', $user_id);
    }

    /**
     * @return self
     */
    public function enabled(): self
    {
        return $this->where('enabled', 1);
    }

    /**
     * @param bool $enabled
     *
     * @return self
     */
    public function whereEnabled(bool $enabled): self
    {
        return $this->where('enabled', $enabled);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('id', 'DESC');
    }

    /**
     * @return self
     */
    public function orderByFirst(): self
    {
        return $this->orderBy('id', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByLast(): self
    {
        return $this->orderBy('id', 'DESC');
    }

    /**
     * @param string|array $column
     * @param string $search
     *
     * @return self
     */
    protected function searchLike($column, string $search): self
    {
        if ($search = $this->searchLikeString($search)) {
            $this->where(fn ($q) => $this->searchLikeColumns($q, (array)$column, $search));
        } else {
            $this->whereRaw('FALSE');
        }

        return $this;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $q
     * @param array $columns
     * @param string $search
     *
     * @return void
     */
    private function searchLikeColumns(Builder $q, array $columns, string $search): void
    {
        foreach ($columns as $each) {
            $q->orWhere($each, 'LIKE', $search);
        }
    }

    /**
     * @param string $search
     *
     * @return ?string
     */
    protected function searchLikeString(string $search): ?string
    {
        $search = trim(preg_replace('/[^\p{L}0-9]/u', ' ', $search));
        $search = array_filter(explode(' ', $search), static fn ($value) => strlen($value) > 2);

        return $search ? ('%'.implode('%', $search).'%') : null;
    }
}
