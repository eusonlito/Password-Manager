<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class MailTestSend extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['bail', 'required', 'email:filter'],
        ];
    }
}
