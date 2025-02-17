<?php

try {
    $user = $userModel->find($id);
} catch (\Higgs\UnknownFileException $e) {
    // do something here...
}
