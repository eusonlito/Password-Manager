<?php declare(strict_types=1);

namespace App\Domains\Tag\Test\Unit;

use App\Domains\Tag\Model\Tag as Model;

class GetOrCreate extends UnitAbstract
{
    /**
     * @var array
     */
    protected array $validation = [
        'list' => ['bail', 'array'],
    ];

    /**
     * @return void
     */
    public function testEmptySuccess(): void
    {
        $this->factory()->action()->getOrCreate();

        $this->assertEquals(Model::count(), 0);
    }

    /**
     * @return void
     */
    public function testSuccess(): void
    {
        $list = ['Code', 'Work', 'Personal Projects', 'Work'];

        $this->factory()->action(['list' => $list])->getOrCreate();

        $this->assertEquals(Model::count(), 3);

        $list = ['Code', 'Work', 'Personal Projects', 'Shopping'];

        $this->factory()->action(['list' => $list])->getOrCreate();

        $this->assertEquals(Model::count(), 4);

        $list = Model::orderBy('name', 'ASC')->get();

        foreach (['Code', 'Personal Projects', 'Shopping', 'Work'] as $index => $each) {
            $this->assertEquals($list->get($index)->name, $each);
            $this->assertEquals($list->get($index)->code, str_slug($each));
        }
    }
}
