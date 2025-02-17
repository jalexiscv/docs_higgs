<?php

try {
    $user = $userModel->find($id);
} catch (\Higgs\UnknownFileException $e) {
    // do something here...

    throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
}
