<?php declare(strict_types=1);

namespace App\Domains\App\Test\Factory;

use Illuminate\Database\Eloquent\Factories\Factory as FactoryEloquent;
use Illuminate\Support\Facades\Crypt;
use App\Domains\App\Model\App as Model;

class App extends FactoryEloquent
{
    /**
     * @var string
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'type' => 'website',
            'name' => $this->faker->name,
            'payload' => $this->payload(),
            'shared' => 0,
            'editable' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return string
     */
    protected function payload()
    {
        return Crypt::encryptString(json_encode([
            'url' => 'https://google.es',
            'user' => 'Google',
            'password' => '123456',
        ]));
    }
}
