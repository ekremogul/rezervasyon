<?php

namespace App\Forms\Components\RezervasyonForm;

use Closure;
use Filament\Forms\Components\Component;

class GenelToplamlar extends Component
{
    protected string $view = 'forms.components.rezervasyon-form.genel-toplamlar';

    public static function make(): static
    {
        return app(static::class);
    }
}
