<?php declare(strict_types=1);

namespace App\Domains\UserSession\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Fail extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'auth' => ['bail', 'nullable'],
        ];
    }
}
