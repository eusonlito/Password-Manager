<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class UpdateSimple extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'nullable', 'string'],
            'email' => ['bail', 'nullable', 'string', 'email:filter'],
            'certificate' => ['bail', 'nullable', 'string'],
            'password' => ['bail', 'nullable', 'string', 'min:8'],
            'password_enabled' => ['bail', 'nullable', 'boolean'],
            'tfa_enabled' => ['bail', 'nullable', 'boolean'],
            'readonly' => ['bail', 'nullable', 'boolean'],
            'admin' => ['bail', 'nullable', 'boolean'],
            'enabled' => ['bail', 'nullable', 'boolean'],
            'teams' => ['bail', 'nullable', 'array'],
        ];
    }
}
