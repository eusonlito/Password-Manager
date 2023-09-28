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
        return Schema::hasColumn('log', 'team_id');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('log', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable()->index();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('log', function (Blueprint $table) {
            $table->dropColumn('team_id');
        });
    }
};
