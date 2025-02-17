<?php

if (! $page = $pageModel->find($id)) {
    throw \Higgs\Exceptions\PageNotFoundException::forPageNotFound();
}
