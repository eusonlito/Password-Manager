<?php declare(strict_types=1);

namespace App\Domains\Tag\Action;

use Illuminate\Support\Collection;
use App\Domains\Tag\Model\Tag as Model;

class GetOrCreate extends ActionAbstract
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $list;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function handle(): Collection
    {
        $this->data();

        if (empty($this->data['list'])) {
            return collect();
        }

        $this->load();
        $this->iterate();

        return $this->list;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $list = [];

        foreach (array_filter($this->data['list']) as $each) {
            $list[str_slug($each)] = trim(strip_tags($each));
        }

        $this->data['list'] = array_filter($list);
    }

    /**
     * @return void
     */
    protected function load(): void
    {
        $this->list = Model::byIdsOrCodes(array_keys($this->data['list']))->get();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach ($this->data['list'] as $code => $name) {
            if ($this->exists($code) === false) {
                $this->list->put($code, $this->save($code, $name));
            }
        }
    }

    /**
     * @param int|string $code
     *
     * @return bool
     */
    protected function exists(int|string $code): bool
    {
        return $this->list->contains(is_int($code) ? 'id' : 'code', $code);
    }

    /**
     * @param string $code
     * @param string $name
     *
     * @return \App\Domains\Tag\Model\Tag
     */
    protected function save(string $code, string $name): Model
    {
        return Model::create([
            'code' => $code,
            'name' => $name,
            'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
