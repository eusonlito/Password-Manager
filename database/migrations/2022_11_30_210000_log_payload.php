<?php declare(strict_types=1);

use App\Domains\Shared\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up()
    {
        $this->db()->statement('
            UPDATE `log`
            SET `payload` = JSON_REMOVE(`payload`, "$.payload", "$.app", "$.path", "$.app_id", "$.user_id", "$.deleted_at", "$.updated_at");
        ');
    }
};
