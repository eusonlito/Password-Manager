<?php declare(strict_types=1);

namespace App\Domains\File\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => ['bail', 'required', 'file'],
            'app_id' => ['bail', 'required', 'integer'],
        ];
    }
}
