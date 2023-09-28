<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Shared\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up()
    {
        $this->tables();
        $this->keys();
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::create('app', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->string('name')->index();
            $table->string('icon')->default('');

            $table->longText('payload');

            $table->boolean('shared')->default(0);
            $table->boolean('editable')->default(0);
            $table->boolean('archived')->default(0);

            $table->string('remote_provider')->nullable()->index();
            $table->string('remote_id')->nullable()->index();

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id')->nullable()->index();
        });

        Schema::create('ip_lock', function (Blueprint $table) {
            $table->id();

            $table->string('ip')->default('');

            $table->datetime('end_at')->nullable();

            $this->timestamps($table);
        });

        Schema::create('log', function (Blueprint $table) {
            $table->id();

            $table->string('table')->index();
            $table->string('action')->index();

            $table->json('payload')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('app_id')->nullable()->index();
            $table->unsignedBigInteger('tag_id')->nullable()->index();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->unsignedBigInteger('user_from_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
        });

        Schema::create('queue_fail', function (Blueprint $table) {
            $table->id();

            $table->text('connection');
            $table->text('queue');

            $table->longText('payload');
            $table->longText('exception');

            $table->timestamp('failed_at')->useCurrent();

            $this->timestamps($table);
        });

        Schema::create('tag', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name');
            $table->string('color')->default('');

            $table->string('remote_provider')->nullable()->index();
            $table->string('remote_id')->nullable()->index();

            $this->timestamps($table);
        });

        Schema::create('tag_app', function (Blueprint $table) {
            $table->id();

            $this->timestamps($table);

            $table->unsignedBigInteger('app_id');
            $table->unsignedBigInteger('tag_id');
        });

        Schema::create('team', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name');
            $table->string('color')->default('');

            $table->boolean('default')->default(0);

            $table->string('remote_provider')->nullable()->index();
            $table->string('remote_id')->nullable()->index();

            $this->timestamps($table);
        });

        Schema::create('team_app', function (Blueprint $table) {
            $table->id();

            $this->timestamps($table);

            $table->unsignedBigInteger('app_id');
            $table->unsignedBigInteger('team_id');
        });

        Schema::create('team_user', function (Blueprint $table) {
            $table->id();

            $this->timestamps($table);

            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('user_id');
        });

        Schema::create('user', function (Blueprint $table) {
            $table->id();

            $table->string('name')->default('');
            $table->string('email')->unique();

            $table->string('certificate')->nullable()->unique();
            $table->string('password')->nullable();

            $table->string('tfa_secret')->nullable()->unique();

            $table->string('api_key')->nullable()->unique();
            $table->string('api_secret')->nullable()->unique();

            $table->string('remember_token')->nullable();

            $table->boolean('password_enabled')->default(1);
            $table->boolean('tfa_enabled')->default(0);
            $table->boolean('admin')->default(0);
            $table->boolean('readonly')->default(0);
            $table->boolean('enabled')->default(0);

            $table->string('remote_provider')->index()->nullable();
            $table->string('remote_id')->index()->nullable();

            $this->timestamps($table);
        });

        Schema::create('user_session', function (Blueprint $table) {
            $table->id();

            $table->string('auth')->nullable()->index();
            $table->string('ip')->index();

            $table->boolean('success')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id')->nullable();
        });
    }

    /**
     * Set the foreign keys.
     *
     * @return void
     */
    protected function keys()
    {
        Schema::table('app', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'user');
        });

        Schema::table('tag_app', function (Blueprint $table) {
            $table->unique(['app_id', 'tag_id']);

            $this->foreignOnDeleteCascade($table, 'app');
            $this->foreignOnDeleteCascade($table, 'tag');
        });

        Schema::table('team_app', function (Blueprint $table) {
            $table->unique(['app_id', 'team_id']);

            $this->foreignOnDeleteCascade($table, 'app');
            $this->foreignOnDeleteCascade($table, 'team');
        });

        Schema::table('team_user', function (Blueprint $table) {
            $table->unique(['team_id', 'user_id']);

            $this->foreignOnDeleteCascade($table, 'team');
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('user_session', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'user');
        });
    }
};
