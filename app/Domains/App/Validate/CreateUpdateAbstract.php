<?php declare(strict_types=1);

namespace App\Domains\App\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

abstract class CreateUpdateAbstract extends ValidateAbstract
{
    /**
     * @return array
     */
    protected function rulesDefault(): array
    {
        return [
            'type' => ['bail', 'required', 'in:card,password,phone,ssh,server,text,user-password,website,wifi'],

            'name' => ['bail', 'required', 'string'],
            'icon' => ['bail', 'file', 'mimetypes:image/png'],
            'icon_reset' => ['bail', 'boolean'],

            'teams' => ['bail', 'array', 'required'],
            'tags' => ['bail', 'array'],

            'shared' => ['bail', 'boolean'],
            'editable' => ['bail', 'boolean'],
            'archived' => ['bail', 'boolean'],

            'payload' => ['bail', 'array'],
        ];
    }
}
