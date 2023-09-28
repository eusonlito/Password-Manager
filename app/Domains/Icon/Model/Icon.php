<?php declare(strict_types=1);

namespace App\Domains\Icon\Model;

use App\Domains\App\Model\App as AppModel;
use App\Domains\Shared\Model\ModelAbstract;

class Icon extends ModelAbstract
{
    /**
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * @const string
     */
    public const PATH = '/storage/app/host/';

    /**
     * @param string $file
     *
     * @return ?self
     */
    public static function byFile(string $file): ?self
    {
        return is_file($file) ? new self(static::toModel($file)) : null;
    }

    /**
     * @param string $name
     *
     * @return ?self
     */
    public static function byName(string $name): ?self
    {
        return static::byFile(static::fileByName($name));
    }

    /**
     * @param string $name
     *
     * @return ?string
     */
    protected static function nameFix(string $name): ?string
    {
        return preg_replace('/[^a-z0-9\.]/', '', $name);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public static function fileByName(string $name): string
    {
        return public_path(static::publicByName($name));
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public static function publicByName(string $name): string
    {
        return static::PATH.static::nameFix($name).'.png';
    }

    /**
     * @param string $file
     *
     * @return array
     */
    protected static function toModel(string $file): array
    {
        return [
            'file' => $file,
            'basename' => ($basename = basename($file)),
            'public' => (static::PATH.$basename),
            'name' => str_replace('.png', '', $basename),
        ];
    }

    /**
     * @return int
     */
    public function appsCount(): int
    {
        return AppModel::byIcon($this->public)->count();
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        unlink($this->file);
    }
}
