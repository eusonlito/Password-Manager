<?php declare(strict_types=1);

namespace App\Domains\Log\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\App\Model\App as AppModel;
use App\Domains\Log\Model\Builder\Log as Builder;
use App\Domains\Shared\Model\ModelAbstract;
use App\Domains\User\Model\User as UserModel;

class Log extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'log';

    /**
     * @const string
     */
    public const TABLE = 'log';

    /**
     * @const string
     */
    public const FOREIGN = 'log_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'payload' => 'object',
    ];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userFrom(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_from_id');
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return match ($this->attributes['table'].'.'.$this->attributes['action']) {
            'app.search' => ($this->payload->q ?? ''),
            'app.search-url' => ($this->payload->host ?? ''),
            'app.view-key' => ($this->payload->key ?? ''),
            default => ($this->payload->name ?? ''),
        };
    }
}
