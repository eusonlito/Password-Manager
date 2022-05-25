<?php declare(strict_types=1);

namespace App\Domains\Team\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required', 'string'],
            'color' => ['bail', 'string', 'required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'default' => ['bail', 'boolean'],
        ];
    }
}
