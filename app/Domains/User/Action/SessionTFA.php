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
        $id = explode('|', (string)$this->request->session()->get('tfa:id'));

        if (count($id) !== 3) {
            return false;
        }

        if ($this->row->id !== (int)$id[0]) {
            return false;
        }

        if ($this->request->ip() === $id[1]) {
            return true;
        }

        return (time() - $id[2]) < (3600 * 6);
    }
}
