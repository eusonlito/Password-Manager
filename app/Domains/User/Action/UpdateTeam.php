<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\Team\Model\Team as TeamModel;
use App\Exceptions\ValidatorException;

class UpdateTeam extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->data();
        $this->check();
        $this->save();
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['team_ids'] = TeamModel::byIds($this->data['team_ids'])->pluck('id')->toArray();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (empty($this->data['team_ids'])) {
            throw new ValidatorException(__('user-update-team.error.team_ids-empty'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->teams()->sync($this->data['team_ids']);
    }
}
