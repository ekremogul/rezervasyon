<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Closure;


class GenelToplamItem extends Field
{
    protected string $view = 'forms.components.genel-toplam-item';

    protected Closure | array $data;

    public function data(Closure | array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): array
    {
        return $this->evaluate($this->data);
    }
}
