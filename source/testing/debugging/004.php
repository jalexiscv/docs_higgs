<?php

namespace MyNamespace;

use Higgs\Debug\Toolbar\Collectors\BaseCollector;

class MyCollector extends BaseCollector
{
    protected $hasTimeline = false;

    protected $hasTabContent = false;

    protected $hasVarData = false;

    protected $title = '';
}
