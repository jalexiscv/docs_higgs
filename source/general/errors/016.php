<?php

namespace Config;

use Higgs\Config\BaseConfig;
use Higgs\Debug\ExceptionHandler;
use Higgs\Debug\ExceptionHandlerInterface;
use Throwable;

class Exceptions extends BaseConfig
{
    // ...

    public function handler(int $statusCode, Throwable $exception): ExceptionHandlerInterface
    {
        return new ExceptionHandler($this);
    }
}
