<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use ZipArchive;
use Illuminate\Support\Collection;
use App\Domains\App\Model\App as Model;

class Export extends ActionAbstract
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $list;

    /**
     * @var string
     */
    protected string $file;

    /**
     * @var string
     */
    protected string $contents;

    /**
     * @return string
     */
    public function handle(): string
    {
        $this->data();
        $this->list();
        $this->map();
        $this->file();
        $this->zip();
        $this->contents();
        $this->clean();
        $this->log();

        return $this->contents;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['shared'] = $this->data['shared'] && $this->auth->admin;
    }

    /**
     * @return void
     */
    protected function list(): void
    {
        $this->list = Model::export($this->auth, $this->data['shared'])->list()->get();
    }

    /**
     * @return void
     */
    protected function map(): void
    {
        $this->list->transform(fn ($row) => $this->mapRow($row));
    }

    /**
     * @param \App\Domains\App\Model\App $row
     *
     * @return array
     */
    protected function mapRow(Model $row): array
    {
        return $this->mapRowData($row) + $this->mapRowPayload($row) + $this->mapRowTags($row);
    }

    /**
     * @param \App\Domains\App\Model\App $row
     *
     * @return array
     */
    protected function mapRowData(Model $row): array
    {
        return $row->only('id', 'type', 'name', 'shared', 'editable', 'archived', 'created_at', 'updated_at');
    }

    /**
     * @param \App\Domains\App\Model\App $row
     *
     * @return array
     */
    protected function mapRowPayload(Model $row): array
    {
        return ['payload' => (array)$row->payload()];
    }

    /**
     * @param \App\Domains\App\Model\App $row
     *
     * @return array
     */
    protected function mapRowTags(Model $row): array
    {
        return [
            'tags' => $row->tags->map(
                static fn ($tag) => $tag->only('id', 'code', 'name', 'color', 'created_at')
            )->toArray(),
        ];
    }

    /**
     * @return void
     */
    protected function file(): void
    {
        $this->file = tempnam(sys_get_temp_dir(), uniqid());
    }

    /**
     * @return void
     */
    protected function zip(): void
    {
        $zip = new ZipArchive();
        $zip->open($this->file, ZipArchive::CREATE);

        $zip->addFromString('apps.json', $this->list->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        if ($this->data['password']) {
            $zip->setEncryptionName('apps.json', ZipArchive::EM_AES_256, $this->data['password']);
        }

        $zip->close();
    }

    /**
     * @return void
     */
    protected function contents(): void
    {
        $this->contents = file_get_contents($this->file);
    }

    /**
     * @return void
     */
    protected function clean(): void
    {
        unlink($this->file);
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'app',
            'action' => 'export',
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
