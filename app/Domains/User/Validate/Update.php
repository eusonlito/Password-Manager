<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'email' => ['bail', 'required', 'email:filter'],
            'certificate' => ['bail', 'nullable'],
            'password' => ['bail', 'min:8'],
            'password_enabled' => ['bail', 'boolean'],
            'readonly' => ['bail', 'boolean'],
            'admin' => ['bail', 'boolean'],
            'enabled' => ['bail', 'boolean'],
        ];
    }
}
