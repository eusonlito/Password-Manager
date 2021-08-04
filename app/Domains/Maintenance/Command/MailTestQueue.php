<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Command;

class MailTestQueue extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'maintenance:mail:test:queue {--email=}';

    /**
     * @var string
     */
    protected $description = 'Queue a test mail to {--email=}';

    /**
     * @return void
     */
    public function handle()
    {
        $this->checkOptions(['email']);
        $this->requestWithOptions();

        $this->factory()->action()->mailTestQueue();
    }
}
