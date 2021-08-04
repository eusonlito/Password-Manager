<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Command;

class MailTestSend extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'maintenance:mail:test:send {--email=}';

    /**
     * @var string
     */
    protected $description = 'Send a test mail to {--email=}';

    /**
     * @return void
     */
    public function handle()
    {
        $this->checkOptions(['email']);
        $this->requestWithOptions();

        $this->factory()->action()->mailTestSend();
    }
}
