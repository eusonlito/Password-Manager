<?php declare(strict_types=1);

namespace App\Domains\App\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Export extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'shared' => ['bail', 'boolean'],
            'password' => ['bail', 'string'],
            'password_current' => ['bail', 'required', 'current_password'],
        ];
    }
}
