<?php declare(strict_types=1);

namespace App\Domains\Team\Action;

use App\Domains\Team\Model\TeamUser as TeamUserModel;
use App\Domains\User\Model\User as UserModel;

class UpdateUser extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->delete();
        $this->save();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        TeamUserModel::byTeamId($this->row->id)->delete();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $insert = [];

        foreach (UserModel::byIds($this->data['user_ids'])->pluck('id') as $each) {
            $insert[] = [
                'team_id' => $this->row->id,
                'user_id' => $each,
            ];
        }

        if ($insert) {
            TeamUserModel::insert($insert);
        }
    }
}
