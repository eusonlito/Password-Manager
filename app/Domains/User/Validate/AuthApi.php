<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class AuthApi extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'api_key' => ['bail', 'required', 'string'],
        ];
    }
}
