<?php

// app/Helpers/info_helper.php
use Higgs\Higgs;

/**
 * Returns Higgs's version.
 */
function HIGGS_version(): string
{
    return Higgs::HIGGS_VERSION;
}
