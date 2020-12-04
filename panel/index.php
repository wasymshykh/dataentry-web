<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}

include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/panel_index.view.php';
include_once LAYOUT_DIR.'footer.view.php';
