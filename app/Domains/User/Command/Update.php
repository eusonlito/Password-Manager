<?php declare(strict_types=1);

namespace App\Domains\User\Command;

class Update extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'user:update {--id=} {--email=} {--name=} {--password=} {--certificate=} {--tfa_enabled=} {--admin=} {--readonly=} {--enabled=} {--teams=}';

    /**
     * @var string
     */
    protected $description = 'Update User with {--email=} {--name=} {--password=} {--certificate=} {--tfa_enabled=} {--admin=} {--readonly=} {--enabled=} {--teams=} by {--id=}';

    /**
     * @return void
     */
    public function handle()
    {
        $this->row();
        $this->requestWithOptions();

        $this->request->merge(['teams' => explode(',', (string)$this->option('teams'))]);

        $this->info($this->factory()->action()->updateSimple()->only(
            'id',
            'email',
            'name',
            'certificate',
            'tfa_enabled',
            'admin',
            'readonly',
            'enabled'
        ));
    }
}
