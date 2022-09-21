<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class ProfileExport extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'password' => ['bail', 'string'],
            'password_current' => ['bail', 'required', 'current_password'],
        ];
    }
}
