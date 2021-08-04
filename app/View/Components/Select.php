<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Select extends Component
{
    /**
     * @var string
     */
    public string $value;

    /**
     * @var array
     */
    public array $text;

    /**
     * @var array
     */
    public array $options;

    /**
     * @var string|array
     */
    public string|array $selected;

    /**
     * @var string
     */
    public string $label;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $id;

    /**
     * @param array $options,
     * @param string $value,
     * @param mixed $text,
     * @param string $label = '',
     * @param string|int|array|null $selected = '',
     * @param string $name = '',
     * @param string $id = '',
     * @param string $placeholder = ''
     *
     * @return self
     */
    public function __construct(
        array $options,
        string $value = '',
        $text = '',
        string $label = '',
        string|int|array|null $selected = '',
        string $name = '',
        string $id = '',
        string $placeholder = ''
    ) {
        $this->value = $value;
        $this->text = (array)$text;
        $this->selected = $this->selected($selected);
        $this->options = $this->options($options);
        $this->label = $label;
        $this->name = $name;
        $this->id = $id ?: 'input-'.uniqid();

        $this->placeholder($placeholder);
    }

    /**
     * @param string|int|array|null $selected
     *
     * @return string|array
     */
    protected function selected(string|int|array|null $selected): string|array
    {
        return is_array($selected) ? $selected : strval($selected);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function options(array $options): array
    {
        if (empty($this->value) || empty($this->text)) {
            return $this->optionsKeyValue($options);
        }

        return $this->optionsAssociative($options);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function optionsKeyValue(array $options): array
    {
        return array_map(fn ($key, $value) => $this->optionsKeyValueOption($key, $value), array_keys($options), $options);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @return array
     */
    protected function optionsKeyValueOption($key, $value): array
    {
        return [
            'value' => $key,
            'text' => $value,
            'selected' => $this->optionsKeyValueOptionSelected($key),
        ];
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    protected function optionsKeyValueOptionSelected($key): bool
    {
        if (is_array($this->selected)) {
            return in_array($key, $this->selected);
        }

        return strval($key) === $this->selected;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function optionsAssociative(array $options): array
    {
        return array_map(fn ($value) => $this->optionsAssociativeOption($value), $options);
    }

    /**
     * @param array $option
     *
     * @return array
     */
    protected function optionsAssociativeOption(array $option): array
    {
        return [
            'value' => $this->optionsAssociativeOptionValue($option),
            'text' => $this->optionsAssociativeOptionText($option),
            'selected' => $this->optionsAssociativeOptionSelected($option),
        ];
    }

    /**
     * @param array $option
     *
     * @return string
     */
    protected function optionsAssociativeOptionValue(array $option): string
    {
        return strval($option[$this->value] ?? '');
    }

    /**
     * @param array $option
     *
     * @return string
     */
    protected function optionsAssociativeOptionText(array $option): string
    {
        return implode(' - ', array_filter(array_map(fn ($key) => data_get($option, $key, ''), $this->text)));
    }

    /**
     * @param array $option
     *
     * @return bool
     */
    protected function optionsAssociativeOptionSelected(array $option): bool
    {
        $key = $option[$this->value] ?? '';

        if (is_array($this->selected)) {
            return in_array($key, $this->selected);
        }

        return strval($key) === $this->selected;
    }

    /**
     * @param string $placeholder
     *
     * @return void
     */
    protected function placeholder(string $placeholder): void
    {
        if (empty($placeholder)) {
            return;
        }

        array_unshift($this->options, [
            'value' => '',
            'text' => $placeholder,
            'selected' => false,
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('components.select');
    }
}
