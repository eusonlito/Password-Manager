<?php declare(strict_types=1);

namespace App\Domains\Tag\Test\Factory;

use Illuminate\Database\Eloquent\Factories\Factory as FactoryEloquent;
use App\Domains\Tag\Model\Tag as Model;

class Tag extends FactoryEloquent
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
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
