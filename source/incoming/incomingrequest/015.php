<?php

var_dump($request->headers());

/*
 * Outputs:
 * [
 *     'Host'          => Higgs\HTTP\Header,
 *     'Cache-Control' => Higgs\HTTP\Header,
 *     'Accept'        => Higgs\HTTP\Header,
 * ]
 */
