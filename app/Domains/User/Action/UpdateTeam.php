<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\Team\Model\Team as TeamModel;

class UpdateTeam extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->save();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->teams()->sync(TeamModel::byIds($this->data['team_ids'])->pluck('id')->toArray());
    }
}
