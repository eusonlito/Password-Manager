<?php declare(strict_types=1);

namespace App\Domains\Tag\Model;

use App\Domains\Tag\Model\Builder\TagApp as Builder;
use App\Domains\Shared\Model\ModelAbstract;

class TagApp extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'tag_app';

    /**
     * @const string
     */
    public const TABLE = 'tag_app';

    /**
     * @const string
     */
    public const FOREIGN = 'tag_app_id';

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($q)
    {
        return new Builder($q);
    }
}
