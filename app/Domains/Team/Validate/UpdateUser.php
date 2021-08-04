<?php declare(strict_types=1);

namespace App\Domains\Team\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class UpdateUser extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_ids' => ['bail', 'array'],
        ];
    }
}
