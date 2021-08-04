<?php declare(strict_types=1);

namespace App\Domains\Team\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class UpdateApp extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'app_ids' => ['bail', 'array'],
        ];
    }
}
