<?php

namespace App\Cells;

use Higgs\View\Cells\Cell;

class AlertMessageCell extends Cell
{
    public $type;
    public $message;

    protected string $view = 'my/custom/view';
}
