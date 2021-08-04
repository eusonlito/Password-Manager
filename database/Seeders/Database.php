<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Team\Seeder\Team as TeamSeeder;

class Database extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $time = time();

        $this->call(TeamSeeder::class);

        $this->command->info(sprintf('Seeding: Total Time %s seconds', time() - $time));
    }
}
