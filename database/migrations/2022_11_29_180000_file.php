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
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
        $this->keys();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('file');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::create('file', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('path');

            $this->timestamps($table);

            $table->unsignedBigInteger('app_id')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
        });

        Schema::table('log', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->nullable()->index();
        });
    }

    /**
     * @return void
     */
    protected function keys()
    {
        Schema::table('file', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'app');
            $this->foreignOnDeleteSetNull($table, 'user');
        });

        Schema::table('log', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'file');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('log', function (Blueprint $table) {
            $table->dropForeign('log_file_fk');
            $table->dropColumn('file_id');
        });

        Schema::drop('file');
    }
};
