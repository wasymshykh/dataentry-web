<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}

$s = new Staff($db);
$u = new Users($db);

$staff = $s->get_all_staff();
$users = $u->get_users();

$retiring = $s->get_all_retiring();

include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/panel_index.view.php';
include_once LAYOUT_DIR.'footer.view.php';
