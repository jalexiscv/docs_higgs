<?php

namespace App\Entities\Cast;

use Higgs\Entity\Cast\BaseCast;

class CastBase64 extends BaseCast
{
    public static function get($value, array $params = [])
    {
        return base64_decode($value, true);
    }
}
