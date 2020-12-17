<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}

if (!isset($_GET['s']) || !is_numeric($_GET['s']) && empty($_GET['s'])) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Invalid request.'];
    go(URL . '/panel/staff');
}

$s = new Staff($db);
$m = new Mda($db);

$staff = $s->get_staff_by_everything('staff_id', normal_text($_GET['s']));

$marritals = ['S' => 'Single', 'M' => 'Married'];

$cadres = $s->get_all_cadre();
$banks = $s->get_all_banks();

if (!$staff || empty($staff)) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Staff not found.'];
    go(URL . '/panel/staff');
}

include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/view_staff.view.php';
include_once LAYOUT_DIR.'footer.view.php';

