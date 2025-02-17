<?php

// create an Encryption instance
$encryption = new \Higgs\Encryption\Encryption();

// reconfigure an instance with different settings
$encrypter = $encryption->initialize($config);
