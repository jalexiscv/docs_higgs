<?php

use Higgs\I18n\Time;

echo Time::createFromDate(2012, 1, 1)->getDst(); // false
echo Time::createFromDate(2012, 9, 1)->dst;      // true
