<?php

// In app/Config/Events.php

namespace Config;

use Higgs\Events\Events;
use Higgs\Exceptions\FrameworkException;
use Higgs\HotReloader\HotReloader;

// ...

Events::on(
    'DBQuery',
    static function (\Higgs\Database\Query $query) {
        log_message('info', (string) $query);
    }
);
