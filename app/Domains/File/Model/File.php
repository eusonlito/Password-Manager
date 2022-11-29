<?php declare(strict_types=1);

namespace App\Domains\File\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
}
