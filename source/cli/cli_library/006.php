<?php

use Higgs\CLI\CLI;

$email = CLI::prompt('What is your email?', null, ['required', 'valid_email']);
