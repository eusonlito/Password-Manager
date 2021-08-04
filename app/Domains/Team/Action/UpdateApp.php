<?php declare(strict_types=1);

namespace App\Domains\Team\Action;

use App\Domains\Team\Model\TeamApp as TeamAppModel;
use App\Domains\App\Model\App as AppModel;

class UpdateApp extends ActionAbstract
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
        TeamAppModel::byTeamId($this->row->id)->delete();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $insert = [];

        foreach (AppModel::byIds($this->data['app_ids'])->pluck('id') as $each) {
            $insert[] = [
                'app_id' => $each,
                'team_id' => $this->row->id,
            ];
        }

        if ($insert) {
            TeamAppModel::insert($insert);
        }
    }
}
