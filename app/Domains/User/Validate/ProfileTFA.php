<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class ProfileTFA extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'tfa_enabled' => ['bail', 'boolean'],
            'password_current' => ['bail', 'required', 'current_password'],
        ];
    }
}
