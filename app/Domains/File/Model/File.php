<?php declare(strict_types=1);

namespace App\Domains\File\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Domains\File\Model\Builder\File as Builder;
use App\Domains\App\Model\App as AppModel;
use App\Domains\Shared\Model\ModelAbstract;

class File extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'file';

    /**
     * @const string
     */
    public const TABLE = 'file';

    /**
     * @const string
     */
    public const FOREIGN = 'file_id';

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($q)
    {
        return new Builder($q);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app(): BelongsTo
    {
        return $this->belongsTo(AppModel::class, AppModel::FOREIGN);
    }

    /**
     * @return bool
     */
    public function fileExists(): bool
    {
        return static::storage()->exists($this->path);
    }

    /**
     * @return string
     */
    public function fileContentsGet(): string
    {
        return Crypt::decrypt(static::storage()->get($this->path));
    }

    /**
     * @param string $path
     * @param string $contents
     *
     * @return void
     */
    public static function fileContentsSet(string $path, string $contents): void
    {
        static::storage()->put($path, Crypt::encrypt($contents));
    }

    /**
     * @return void
     */
    public function fileDelete(): void
    {
        static::storage()->delete($this->path);
    }

    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    protected static function storage(): FilesystemAdapter
    {
        return Storage::disk('private');
    }
}
