<?php declare(strict_types=1);

namespace App\Domains\Log\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'table' => ['bail', 'required', 'string'],
            'action' => ['bail', 'required', 'string'],
            'payload' => ['bail'],
            'app_id' => ['bail', 'nullable', 'integer'],
            'user_from_id' => ['bail', 'nullable', 'integer'],
            'user_id' => ['bail', 'nullable', 'integer'],
        ];
    }
}
