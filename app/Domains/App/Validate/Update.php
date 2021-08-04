<?php declare(strict_types=1);

namespace App\Domains\App\Validate;

class Update extends CreateUpdateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return $this->rulesDefault();
    }
}
