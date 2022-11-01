<?php declare(strict_types=1);

namespace App\Domains\Team\Test\Factory;

use Illuminate\Database\Eloquent\Factories\Factory as FactoryEloquent;
use App\Domains\Team\Model\Team as Model;

class Team extends FactoryEloquent
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
            'code' => str_slug($name = $this->faker->name),
            'name' => $name,
            'color' => $this->faker->hexColor(),
            'default' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
