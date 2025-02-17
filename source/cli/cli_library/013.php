<?php

use Higgs\CLI\CLI;

CLI::write("fileA \t" . CLI::color('/path/to/file', 'white'), 'yellow');
