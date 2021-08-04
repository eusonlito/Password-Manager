<?php declare(strict_types=1);

namespace App\Domains\Error\Action;

use Throwable;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @param \Throwable $e
     *
     * @return void
     */
    public function exception(Throwable $e): void
    {
        $this->actionHandle(Exception::class, [], $e);
    }
}
