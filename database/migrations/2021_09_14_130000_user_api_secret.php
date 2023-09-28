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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user', 'api_secret');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('api_secret')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('api_secret');
        });
    }
};
