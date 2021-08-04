<?php declare(strict_types=1);

namespace App\Domains\Team\Seeder;

use App\Domains\Team\Model\Team as Model;
use App\Domains\Shared\Seeder\SeederAbstract;

class Team extends SeederAbstract
{
    /**
     * @return void
     */
    public function run()
    {
        $this->insertWithoutDuplicates(Model::class, $this->json('team'), 'name');
    }
}
