<?php declare(strict_types=1);

namespace App\Domains\Icon\Service;

use Illuminate\Support\Collection;
use App\Domains\Icon\Model\Icon as Model;

class Loader
{
    /**
     * @const string
     */
    protected const PATH = '/storage/app/host/';

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection
    {
        return collect(array_map(static fn ($value) => Model::byFile($value), $this->files()));
    }

    /**
     * @return array
     */
    protected function files(): array
    {
        return glob(public_path(static::PATH.'*.png'));
    }
}
