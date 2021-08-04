<?php declare(strict_types=1);

namespace App\Domains\Team\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Team\Model\Builder\TeamUser as Builder;
use App\Domains\Shared\Model\ModelAbstract;

class TeamUser extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'team_user';

    /**
     * @const string
     */
    public const TABLE = 'team_user';

    /**
     * @const string
     */
    public const FOREIGN = 'team_user_id';

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
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, Team::FOREIGN);
    }
}
