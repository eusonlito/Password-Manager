<?php declare(strict_types=1);

namespace App\Domains\Shared\Model\Traits;

trait Translate
{
    /**
     * @param string $column
     *
     * @return string
     */
    public function translate(string $column): string
    {
        static $language;

        if (empty($value = $this->attributes[$column])) {
            return '';
        }

        $value = json_decode($value, true);

        if (is_array($value) === false) {
            return (string)$value;
        }

        if ($language === null) {
            $language = app('language')->iso;
        }

        return $value[$language] ?? '';
    }
}
