<?php declare(strict_types=1);

namespace App\Domains\Tag\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Domains\App\Model\App as AppModel;
use App\Domains\Tag\Model\Builder\Tag as Builder;
use App\Domains\Tag\Test\Factory\Tag as TestFactory;
use App\Domains\Shared\Model\ModelAbstract;

class Tag extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'tag';

    /**
     * @const string
     */
    public const TABLE = 'tag';

    /**
     * @const string
     */
    public const FOREIGN = 'tag_id';

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
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function apps(): BelongsToMany
    {
        return $this->belongsToMany(AppModel::class, TagApp::TABLE);
    }
}
