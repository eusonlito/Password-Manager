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
        $this->fill();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('tag', 'color');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('tag', function (Blueprint $table) {
            $table->string('color')->default('');
        });
    }

    /**
     * @return void
     */
    protected function fill()
    {
        if ($this->driver() === 'mysql') {
            $query = 'UPDATE `tag` SET `color` = CONCAT("#", SUBSTR(MD5(RAND()), 1, 6));';
        } else {
            $query = 'UPDATE `tag` SET `color` = "#" + SUBSTR(hex(randomblob(16)), 1, 6);';
        }

        $this->db()->statement($query);
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('tag', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
