<?php

$length = timer('string length', static fn () => strlen('H4'));

/*
 * $length = 3
 *
 * Same as:
 *
 * timer('string length');
 * $length = strlen('H4');
 * timer('string length');
*/
