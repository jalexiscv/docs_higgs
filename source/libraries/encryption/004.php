<?php

// $key will be assigned a 32-byte (256-bit) random key
$key = \Higgs\Encryption\Encryption::createKey();

// for the SodiumHandler, you can use either:
$key = sodium_crypto_secretbox_keygen();
$key = \Higgs\Encryption\Encryption::createKey(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
