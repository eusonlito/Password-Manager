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
        return Schema::hasColumn('app', 'archived');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('app', function (Blueprint $table) {
            $table->boolean('archived')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('app', function (Blueprint $table) {
            $table->dropColumn('archived');
        });
    }
};
