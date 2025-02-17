<?php

namespace App\Entities\Cast;

use Higgs\Entity\Cast\BaseCast;

// The class must inherit the Higgs\Entity\Cast\BaseCast class
class CastBase64 extends BaseCast
{
    public static function get($value, array $params = [])
    {
        return base64_decode($value, true);
    }

    public static function set($value, array $params = [])
    {
        return base64_encode($value);
    }
}
