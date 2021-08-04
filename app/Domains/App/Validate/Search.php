<?php declare(strict_types=1);

namespace App\Domains\App\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Search extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'q' => ['bail', 'required', 'string'],
        ];
    }
}
