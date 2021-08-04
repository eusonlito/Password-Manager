<?php declare(strict_types=1);

namespace App\Domains\User\Model;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\Team\Model\TeamUser as TeamUserModel;
use App\Domains\Shared\Model\ModelAbstract;
use App\Domains\User\Model\Builder\User as Builder;

class User extends ModelAbstract implements Authenticatable
{
    use AuthenticatableTrait;

    /**
     * @var string
     */
    protected $table = 'user';

    /**
     * @const string
     */
    public const TABLE = 'user';

    /**
     * @const string
     */
    public const FOREIGN = 'user_id';

    /**
     * @var array
     */
    protected $casts = [
        'password_enabled' => 'boolean',
        'tfa_enabled' => 'boolean',
        'admin' => 'boolean',
        'readonly' => 'boolean',
        'enabled' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $hidden = ['password'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function teamPivot(): HasOne
    {
        return $this->hasOne(TeamUserModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(TeamModel::class, 'team_user');
    }

    /**
     * @return bool
     */
    public function tfaAvailable(): bool
    {
        return config('auth.tfa.enabled') && $this->tfa_secret;
    }
}
