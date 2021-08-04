<?php declare(strict_types=1);

namespace App\Domains\Shared\Test;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Testing\Fakes\MailFake;
use Faker\Factory as FactoryFaker;
use Faker\Generator as GeneratorFaker;
use App\Domains\User\Model\User as UserModel;
use Database\Seeders\Database as DatabaseSeed;

abstract class TestAbstract extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    protected $seeder = DatabaseSeed::class;

    /**
     * @var \Faker\Generator
     */
    protected GeneratorFaker $faker;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user = null
     *
     * @return self
     */
    protected function auth(Authenticatable $user = null): self
    {
        parent::actingAs($user ?: $this->user());

        return $this;
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    protected function user(): UserModel
    {
        return UserModel::orderBy('id', 'ASC')->first() ?: UserModel::factory()->create();
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    protected function userLast(): UserModel
    {
        return UserModel::orderBy('id', 'DESC')->first() ?: UserModel::factory()->create();
    }

    /**
     * @return \Faker\Generator
     */
    protected function faker(): GeneratorFaker
    {
        return $this->faker ??= FactoryFaker::create('es_ES');
    }

    /**
     * @param string $class
     * @param array $whitelist
     * @param string|bool $action = ''
     *
     * @return array
     */
    protected function factoryWhitelist(string $class, array $whitelist, $action = ''): array
    {
        return $this->whitelist($class::factory()->make()->toArray(), $whitelist, $action);
    }

    /**
     * @return \Illuminate\Support\Testing\Fakes\MailFake
     */
    protected function mail(): MailFake
    {
        return (new Mail)->fake();
    }

    /**
     * @param array $data
     * @param array $whitelist
     * @param string|bool $action = ''
     *
     * @return array
     */
    protected function whitelist(array $data, array $whitelist, $action = ''): array
    {
        $values = array_intersect_key($data, array_flip($whitelist));

        if (in_array('password', $whitelist, true) && isset($data['email'])) {
            $values['password'] = $data['email'];
        }

        if ($action !== false) {
            $values += $this->action($action);
        }

        return $values;
    }

    /**
     * @return void
     */
    protected function info(): void
    {
        $debug = debug_backtrace(2)[1];
        $prefix = $debug['class'].'::'.$debug['function'].' - ';

        fwrite(STDERR, "\n");

        foreach (func_get_args() as $each) {
            fwrite(STDERR, "\n".$prefix.print_r($each, true));
        }

        fwrite(STDERR, "\n");
    }
}
