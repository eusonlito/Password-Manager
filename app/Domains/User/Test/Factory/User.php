<?php declare(strict_types=1);

namespace App\Domains\User\Test\Factory;

use Illuminate\Database\Eloquent\Factories\Factory as FactoryEloquent;
use Illuminate\Support\Facades\Hash;
use App\Domains\User\Model\User as Model;
use App\Domains\User\Service\TFA\TFA;

class User extends FactoryEloquent
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
            'name' => $this->faker->name,
            'email' => ($email = $this->faker->unique()->companyEmail),
            'certificate' => $this->faker->dni,
            'password' => Hash::make($email),
            'password_enabled' => true,
            'api_key' => ($api_key = helper()->uuid()),
            'api_secret' => Hash::make($api_key),
            'tfa_secret' => TFA::generateSecretKey(),
            'tfa_enabled' => false,
            'admin' => false,
            'readonly' => false,
            'enabled' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
