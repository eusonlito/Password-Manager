<?php declare(strict_types=1);

namespace App\Domains\Team\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\App\Model\App as AppModel;
use App\Domains\Shared\Model\ModelAbstract;
use App\Domains\Team\Model\Builder\Team as Builder;
use App\Domains\Team\Test\Factory\Team as TestFactory;
use App\Domains\User\Model\User as UserModel;

class Team extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'team';

    /**
     * @const string
     */
    public const TABLE = 'team';

    /**
     * @const string
     */
    public const FOREIGN = 'team_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'default' => 'boolean',
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
        return $this->belongsToMany(AppModel::class, 'team_app');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teamsUsers(): HasMany
    {
        return $this->hasMany(TeamUser::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(UserModel::class, 'team_user');
    }
}
