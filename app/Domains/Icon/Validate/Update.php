<?php declare(strict_types=1);

namespace App\Domains\Icon\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'icon' => ['bail', 'required', 'file', 'mimetypes:image/png'],
        ];
    }
}
