<?php declare(strict_types=1);

namespace App\Domains\App\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Domains\File\Model\File as FileModel;

class File extends ControllerAbstract
{
    /**
     * @var \App\Domains\File\Model\File
     */
    protected FileModel $file;

    /**
     * @param int $id
     * @param int $file_id
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke(int $id, int $file_id): StreamedResponse
    {
        $this->row($id);
        $this->file($file_id);

        if ($this->file->fileExists() === false) {
            abort(404);
        }

        return response()->streamDownload(function () {
            echo $this->file->fileContentsGet();
        }, $this->file->name);
    }

    /**
     * @param int $file_id
     *
     * @return void
     */
    protected function file(int $file_id): void
    {
        $this->file = FileModel::byId($file_id)->byAppId($this->row->id)->firstOrFail();
    }
}
