<?php declare(strict_types=1);

namespace App\Domains\UserSession\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class UserSession extends BuilderAbstract
{
    /**
     * @param string $auth
     *
     * @return self
     */
    public function byAuth(string $auth): self
    {
        return $this->where('auth', $auth);
    }

    /**
     * @param string $ip
     *
     * @return self
     */
    public function byIp(string $ip): self
    {
        return $this->where('ip', $ip);
    }

    /**
     * @param bool $success
     *
     * @return self
     */
    public function whereSuccess(bool $success = true): self
    {
        return $this->where('success', $success);
    }
}
