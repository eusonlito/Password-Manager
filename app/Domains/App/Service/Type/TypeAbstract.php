<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type;

use Illuminate\Support\Facades\Crypt;

abstract class TypeAbstract
{
    /**
     * @return string
     */
    abstract public function code(): string;

    /**
     * @return string
     */
    abstract public function title(): string;

    /**
     * @return string
     */
    abstract public function icon(): string;

    /**
     * @return string
     */
    abstract public function payload(): string;

    /**
     * @param array $payload
     *
     * @return self
     */
    public function __construct(protected array $payload)
    {
    }

    /**
     * @param array $payload
     *
     * @return string
     */
    public function encrypt(array $payload): string
    {
        return Crypt::encryptString(json_encode($payload));
    }
}
