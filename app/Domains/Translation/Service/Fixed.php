<?php declare(strict_types=1);

namespace App\Domains\Translation\Service;

class Fixed extends ServiceAbstract
{
    /**
     * @param string $file
     *
     * @return ?array
     */
    protected function file(string $file): ?array
    {
        $contents = file($file);
        $matches = preg_grep('/[^-]>\w[\w\s]+</', $contents) + preg_grep('/(title|placeholder)="[\w\s]+"/', $contents);

        return $matches ? [$this->fileRelative($file) => $matches] : null;
    }
}
