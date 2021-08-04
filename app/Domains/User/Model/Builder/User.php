<?php declare(strict_types=1);

namespace App\Domains\User\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class User extends BuilderAbstract
{
    /**
     * @param string $api_key
     *
     * @return self
     */
    public function byApiKey(string $api_key): self
    {
        return $this->where('api_key', $api_key);
    }

    /**
     * @param string $certificate
     *
     * @return self
     */
    public function byCertificate(string $certificate): self
    {
        return $this->where('certificate', $certificate);
    }

    /**
     * @param string $email
     *
     * @return self
     */
    public function byEmail(string $email): self
    {
        return $this->where('email', strtolower($email));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('name', 'ASC')->with('teams');
    }

    /**
     * @return self
     */
    public function simple(): self
    {
        return $this->select('id', 'name', 'email', 'readonly', 'admin', 'enabled')->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function withTeams(): self
    {
        return $this->with('teams');
    }
}
