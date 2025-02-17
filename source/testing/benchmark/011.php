<?php

$length = $benchmark->record('string length', static fn () => strlen('H4'));

/*
 * $length = 3
 *
 * Same as:
 *
 * $benchmark->start('string length');
 * $length = strlen('H4');
 * $benchmark->stop('string length');
*/
