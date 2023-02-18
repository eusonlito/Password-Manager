<?php declare(strict_types=1);

namespace App\Domains\App\Model;

use stdClass;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;
use App\Domains\App\Model\Builder\App as Builder;
use App\Domains\App\Service\Type\Type as TypeService;
use App\Domains\App\Test\Factory\App as TestFactory;
use App\Domains\File\Model\File as FileModel;
use App\Domains\Shared\Model\ModelAbstract;
use App\Domains\Tag\Model\Tag as TagModel;
use App\Domains\Tag\Model\TagApp as TagAppModel;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\Team\Model\TeamApp as TeamAppModel;

class App extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'app';

    /**
     * @const string
     */
    public const TABLE = 'app';

    /**
     * @const string
     */
    public const FOREIGN = 'app_id';

    /**
     * @const
     */
    public const PAYLOAD = [
        'cvc', 'expires', 'holder', 'host', 'notes', 'number', 'password', 'pin', 'port',
        'private', 'public', 'puk', 'recovery', 'text', 'url', 'user',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'shared' => 'boolean',
        'editable' => 'boolean',
        'archived' => 'boolean',
        'user_id' => 'integer',
    ];

    /**
     * @var \stdClass
     */
    protected stdClass $payloadDecrypted;

    /**
     * @var \App\Domains\App\Service\Type\Type
     */
    protected TypeService $typeService;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(FileModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(TagModel::class, TagAppModel::TABLE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(TeamModel::class, TeamAppModel::TABLE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teamsPivot(): HasMany
    {
        return $this->hasMany(TeamAppModel::class, static::FOREIGN);
    }

    /**
     * @param ?string $key = null
     * @param mixed $default = ''
     *
     * @return mixed
     */
    public function payload(?string $key = null, $default = '')
    {
        if (empty($this->attributes['payload'])) {
            return $default;
        }

        if (isset($this->payloadDecrypted) === false) {
            $this->payloadDecrypted = json_decode(Crypt::decryptString($this->attributes['payload']));
        }

        if ($key === null) {
            return $this->payloadDecrypted;
        }

        return $this->payloadDecrypted->$key ?? $default;
    }

    /**
     * @param string $key
     *
     * @return ?string
     */
    public function payloadEncoded(string $key): ?string
    {
        if ($value = $this->payload($key)) {
            return helper()->stringEncode($value);
        }

        return null;
    }

    /**
     * @return \App\Domains\App\Service\Type\Type
     */
    public function typeService(): TypeService
    {
        return $this->typeService ??= new TypeService();
    }

    /**
     * @return string
     */
    public function typeTitle(): string
    {
        return $this->typeService()->titles()[$this->type];
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return bool
     */
    public function canView(Authenticatable $auth): bool
    {
        return ($this->user_id === $auth->id) || $this->shared;
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return bool
     */
    public function canEdit(Authenticatable $auth): bool
    {
        return ($this->user_id === $auth->id) || ($this->shared && $this->editable && empty($auth->readonly));
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return bool
     */
    public function canDelete(Authenticatable $auth): bool
    {
        return $this->canEdit($auth);
    }
}
