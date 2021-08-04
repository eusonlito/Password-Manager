<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class CheckChartUrl extends Component
{
    /**
     * @var \Illuminate\Support\Collection
     */
    public Collection $rows;

    /**
     * @var string
     */
    public string $id;

    /**
     * @var array
     */
    public array $x;

    /**
     * @var array
     */
    public array $y;

    /**
     * @param \Illuminate\Support\Collection $rows
     *
     * @return self
     */
    public function __construct(Collection $rows)
    {
        $this->rows = $this->rows($rows);
        $this->id = uniqid();
        $this->x = $this->x();
        $this->y = $this->y();
    }

    /**
     * @param \Illuminate\Support\Collection $rows
     *
     * @return \Illuminate\Support\Collection
     */
    protected function rows(Collection $rows): Collection
    {
        return $rows->map(static fn ($value) => [
            'created_at' => $value->created_at,
            'time' => $value->details['time'] ?? null,
        ])->where('time')->sortBy('created_at')->values();
    }

    /**
     * @return ?\Illuminate\View\View
     */
    public function render(): ?View
    {
        if ($this->rows->isEmpty()) {
            return null;
        }

        return view('domains.check.components.chart-url', $this->renderData());
    }

    /**
     * @return array
     */
    protected function renderData(): array
    {
        return [
            'rows' => $this->rows,
            'x' => $this->x,
            'y' => $this->y,
            'yMin' => min($this->y) * 0.95,
            'yMax' => max($this->y) * 1.05,
        ];
    }

    /**
     * @return array
     */
    protected function x(): array
    {
        return $this->rows
            ->pluck('created_at')
            ->map(fn ($value) => date('m-d H:i:s', strtotime($value)))
            ->toArray();
    }

    /**
     * @return array
     */
    protected function y(): array
    {
        return $this->rows
            ->pluck('time')
            ->toArray();
    }
}
