<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}

$s = new Staff($db);
$u = new Users($db);
$m = new Mda($db);

$staff = $s->get_all_staff();
$retired_staff = $s->get_all_retired_staff();
$users = $u->get_users();
$mdas = $m->get_all();

$retiring = $s->get_all_retiring();
$posting = $s->get_all_posting();
$promotions = $s->get_all_promotion();

include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/panel_index.view.php';
include_once LAYOUT_DIR.'footer.view.php';
