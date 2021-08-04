<?php declare(strict_types=1);

namespace App\Domains\Tag\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class GetOrCreate extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'list' => ['bail', 'array'],
        ];
    }
}
