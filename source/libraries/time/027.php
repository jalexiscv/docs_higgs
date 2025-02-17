<?php

use Higgs\I18n\Time;

echo Time::now('America/Chicago')->getTimezoneName(); // America/Chicago
echo Time::now('Europe/London')->timezoneName;        // Europe/London
