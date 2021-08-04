<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class AuthTFA extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => ['bail', 'required', 'digits:6'],
        ];
    }
}
