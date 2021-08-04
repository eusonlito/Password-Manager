<?php declare(strict_types=1);

namespace App\Domains\User\Command;

class Create extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'user:create {--email=} {--name=} {--password=} {--admin} {--readonly} {--teams=}';

    /**
     * @var string
     */
    protected $description = 'Create User with {--email=} {--name=} {--password=} {--admin} {--readonly} {--teams=}';

    /**
     * @return void
     */
    public function handle()
    {
        $this->checkOptions(['email', 'name', 'password']);
        $this->requestWithOptions();

        $this->request->merge(['teams' => explode(',', (string)$this->option('teams'))]);

        $this->info($this->factory()->action()->create()->only(
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
