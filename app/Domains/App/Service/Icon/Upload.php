<?php declare(strict_types=1);

namespace App\Domains\App\Service\Icon;

use Illuminate\Http\UploadedFile;

class Upload
{
    /**
     * @var \Illuminate\Http\UploadedFile
     */
    protected UploadedFile $file;

    /**
     * @var int|string
     */
    protected int|string $name;

    /**
     * @var string
     */
    protected string $www;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @param int|string $name
     *
     * @return self
     */
    public function __construct(UploadedFile $file, int|string $name)
    {
        $this->file = $file;
        $this->name = $name;
        $this->www = $this->www();
        $this->path = $this->path();
    }

    /**
     * @return string
     */
    protected function www(): string
    {
        return '/storage/app/'.$this->name.'.png';
    }

    /**
     * @return string
     */
    protected function path(): string
    {
        return public_path($this->www);
    }

    /**
     * @return ?string
     */
    public function get(): ?string
    {
        Image::save($this->path, $this->file->get());

        return $this->www;
    }
}
