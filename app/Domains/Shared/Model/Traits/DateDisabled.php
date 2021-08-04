<?php declare(strict_types=1);

namespace App\Domains\Shared\Model\Traits;

trait DateDisabled
{
    /**
     * @return array
     */
    public function getDates(): array
    {
        return [];
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function isDateCastable($key)
    {
        return false;
    }
}
