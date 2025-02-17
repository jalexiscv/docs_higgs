<?php

use Higgs\I18n\Time;

echo Time::now()->getLocal();           // true
echo Time::now('Europe/London')->local; // false
