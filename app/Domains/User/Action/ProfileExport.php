<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use ZipArchive;
use Illuminate\Support\Collection;
use App\Domains\App\Model\App as AppModel;

class ProfileExport extends ActionAbstract
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $apps;

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
        $this->apps();
        $this->map();
        $this->file();
        $this->zip();
        $this->contents();
        $this->clean();

        return $this->contents;
    }

    /**
     * @return void
     */
    protected function apps(): void
    {
        $this->apps = AppModel::byUserId($this->auth->id)->list()->get();
    }

    /**
     * @return void
     */
    protected function map(): void
    {
        $this->apps->transform(fn ($app) => $this->mapApp($app));
    }

    /**
     * @param \App\Domains\App\Model\App $app
     *
     * @return array
     */
    protected function mapApp(AppModel $app): array
    {
        return $this->mapAppData($app) + $this->mapAppPayload($app) + $this->mapAppTags($app);
    }

    /**
     * @param \App\Domains\App\Model\App $app
     *
     * @return array
     */
    protected function mapAppData(AppModel $app): array
    {
        return $app->only('id', 'type', 'name', 'created_at');
    }

    /**
     * @param \App\Domains\App\Model\App $app
     *
     * @return array
     */
    protected function mapAppPayload(AppModel $app): array
    {
        return ['payload' => (array)$app->payload()];
    }

    /**
     * @param \App\Domains\App\Model\App $app
     *
     * @return array
     */
    protected function mapAppTags(AppModel $app): array
    {
        return [
            'tags' => $app->tags->map(
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

        $zip->addFromString('apps.json', $this->apps->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

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
}
