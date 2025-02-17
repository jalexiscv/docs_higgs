<?php

use Higgs\Events\Events;

Events::on('pre_system', ['MyClass', 'myFunction']);
