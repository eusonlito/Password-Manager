<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Profile extends ValidateAbstract
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
            'password_current' => ['bail', 'required', 'current_password'],
            'api_key' => ['bail', 'nullable', 'uuid'],
            'api_secret' => ['bail', 'nullable', 'min:8'],
        ];
    }
}
