<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class UpdateTeam extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'team_ids' => ['bail', 'array', 'required'],
        ];
    }
}
