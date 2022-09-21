<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Model\User as Model;
use App\Exceptions\ValidatorException;

class ProfileTFA extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (config('auth.tfa.enabled') === false) {
            throw new ValidatorException(__('user-profile.error.tfa-disabled'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->tfa_enabled = $this->data['tfa_enabled'];
        $this->row->save();
    }
}
