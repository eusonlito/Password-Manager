<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use ReflectionClass;
use Throwable;
use App\Domains\App\Model\App as Model;
use App\Domains\App\Service\Icon\Upload as IconUpload;
use App\Domains\App\Service\Type\Type as TypeService;
use App\Domains\App\Service\Type\TypeAbstract;
use App\Domains\File\Model\File as FileModel;
use App\Domains\Team\Model\Team as TeamModel;
use App\Exceptions\ValidatorException;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @var \App\Domains\App\Service\Type\TypeAbstract
     */
    protected TypeAbstract $type;

    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\App\Model\App
     */
    public function handle(): Model
    {
        $this->type();
        $this->data();
        $this->check();
        $this->save();
        $this->saveIcon();
        $this->teams();
        $this->tags();
        $this->log();
        $this->files();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function type(): void
    {
        $this->type = (new TypeService())->factory($this->data['type'], $this->data['payload']);
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['type'] = $this->type->code();
        $this->data['payload'] = $this->type->payload();

        $this->dataReadOnly();
    }

    /**
     * @return void
     */
    protected function dataReadOnly(): void
    {
        if (empty($this->auth->readonly)) {
            return;
        }

        $this->data['shared'] = $this->row->shared ?? false;
        $this->data['editable'] = $this->row->editable ?? false;
        $this->data['archived'] = $this->row->archived ?? false;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
    }

    /**
     * @return void
     */
    protected function saveIcon(): void
    {
        $this->row->icon = $this->icon();
        $this->row->save();
    }

    /**
     * @return string
     */
    protected function icon(): string
    {
        if ($icon = $this->iconUpload()) {
            return $icon;
        }

        if ($this->data['icon_reset']) {
            return $this->type->icon();
        }

        return $this->row->icon ?: $this->type->icon();
    }

    /**
     * @return ?string
     */
    protected function iconUpload(): ?string
    {
        if (empty($this->data['icon'])) {
            return null;
        }

        try {
            return (new IconUpload($this->data['icon'], $this->row->id))->get();
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * @return void
     */
    protected function teams(): void
    {
        if (empty($this->data['teams'])) {
            return;
        }

        $allowed = TeamModel::byUserAllowed($this->auth)->pluck('id');
        $forbidden = $this->row->teams->pluck('id')->diff($allowed);
        $valid = $allowed->intersect($this->data['teams']);
        $ids = $valid->merge($forbidden);

        if ($ids->count() === 0) {
            throw new ValidatorException(__('app-create.error.teams-empty'));
        }

        $this->row->teams()->sync($ids);
    }

    /**
     * @return void
     */
    protected function tags(): void
    {
        $this->row->tags()->sync($this->factory('Tag')->action(['list' => $this->data['tags']])->getOrCreate()->pluck('id'));
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'app',
            'action' => strtolower((new ReflectionClass($this))->getShortName()),
            'payload' => $this->row->only('id', 'name'),
            'app_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }

    /**
     * @return void
     */
    protected function files(): void
    {
        foreach ($this->filesInput() as $file) {
            try {
                $this->file($file);
            } catch (Throwable $e) {
                report($e);
            }
        }
    }

    /**
     * @return array
     */
    protected function filesInput(): array
    {
        return array_slice($this->request->all('files')['files'] ?? [], 0, 6);
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function file(array $file): void
    {
        if (empty($file['id'])) {
            $this->fileCreate($file);
        } elseif (empty($file['delete'])) {
            $this->fileUpdate($file);
        } else {
            $this->fileDelete($file);
        }
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function fileCreate(array $file): void
    {
        if (empty($file['file'])) {
            return;
        }

        $this->factory('File')->action($this->fileCreateData($file))->create();
    }

    /**
     * @param array $file
     *
     * @return array
     */
    protected function fileCreateData(array $file): array
    {
        return [
            'file' => $file['file'],
            'app_id' => $this->row->id,
        ];
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function fileUpdate(array $file): void
    {
        if (empty($file['file'])) {
            return;
        }

        $this->factory('File', $this->fileRow($file))->action($this->fileUpdateData($file))->update();
    }

    /**
     * @param array $file
     *
     * @return array
     */
    protected function fileUpdateData(array $file): array
    {
        return [
            'file' => $file['file'],
        ];
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function fileDelete(array $file): void
    {
        $this->factory('File', $this->fileRow($file))->action()->delete();
    }

    /**
     * @param array $file
     *
     * @return \App\Domains\File\Model\File
     */
    protected function fileRow(array $file): FileModel
    {
        return FileModel::byAppId($this->row->id)->byId((int)$file['id'])->firstOrFail();
    }
}
