<?php

use Higgs\I18n\Time;

echo Time::now('America/Chicago')->getUtc(); // false
echo Time::now('UTC')->utc;                  // true
