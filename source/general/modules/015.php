<?php

namespace Higgs\Shield\Config;

use Higgs\Shield\Filters\SessionAuth;
use Higgs\Shield\Filters\TokenAuth;

class Registrar
{
    /**
     * Registers the Shield filters.
     */
    public static function Filters(): array
    {
        return [
            'aliases' => [
                'session' => SessionAuth::class,
                'tokens'  => TokenAuth::class,
            ],
        ];
    }
}
