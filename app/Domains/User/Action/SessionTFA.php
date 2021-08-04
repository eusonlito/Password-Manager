<?php declare(strict_types=1);

namespace App\Domains\User\Action;

class SessionTFA extends ActionAbstract
{
    /**
     * @return bool
     */
    public function handle(): bool
    {
        if ($this->enabled() === false) {
            return true;
        }

        return $this->check();
    }

    /**
     * @return bool
     */
    protected function enabled(): bool
    {
        return config('auth.tfa.enabled')
            && $this->row->tfa_secret
            && $this->row->tfa_enabled;
    }

    /**
     * @return bool
     */
    protected function check(): bool
    {
        return $this->request->session()->get('tfa:id') === ($this->row->id.'|'.$this->request->session()->getId());
    }
}
