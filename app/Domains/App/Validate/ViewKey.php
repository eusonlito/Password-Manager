<?php declare(strict_types=1);

namespace App\Domains\App\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class ViewKey extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'key' => ['bail', 'required', 'string'],
        ];
    }
}
