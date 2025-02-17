<?php

namespace Config;

use Higgs\Config\BaseConfig;
use Higgs\Debug\ExceptionHandlerInterface;
use Higgs\Exceptions\PageNotFoundException;
use Throwable;

class Exceptions extends BaseConfig
{
    // ...

    public function handler(int $statusCode, Throwable $exception): ExceptionHandlerInterface
    {
        if (in_array($statusCode, [400, 404, 500], true)) {
            return new \App\Libraries\MyExceptionHandler($this);
        }

        if ($exception instanceof PageNotFoundException) {
            return new \App\Libraries\MyExceptionHandler($this);
        }

        return new \Higgs\Debug\ExceptionHandler($this);
    }
}
