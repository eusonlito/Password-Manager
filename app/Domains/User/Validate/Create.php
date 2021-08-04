<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'email' => ['bail', 'required', 'email:filter'],
            'certificate' => ['bail', 'required_without:password', 'nullable'],
            'password' => ['bail', 'required_with:password_enabled', 'min:8'],
            'password_enabled' => ['bail', 'nullable', 'boolean'],
            'readonly' => ['bail', 'nullable', 'boolean'],
            'admin' => ['bail', 'nullable', 'boolean'],
            'enabled' => ['bail', 'nullable', 'boolean'],
            'teams' => ['bail', 'array'],
        ];
    }
}
