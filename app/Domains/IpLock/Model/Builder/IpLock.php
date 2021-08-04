<?php declare(strict_types=1);

namespace App\Domains\IpLock\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class IpLock extends BuilderAbstract
{
    /**
     * @return self
     */
    public function current(): self
    {
        return $this->where(static fn ($q) => $q->where('end_at', '>=', date('Y-m-d H:i:s'))->orWhereNull('end_at'));
    }
}
