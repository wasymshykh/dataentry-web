<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}

$success = false;
$error = false;
if (isset($_SESSION['status']) && !empty($_SESSION['status'])) {
    if ($_SESSION['status']['type'] === 'success') {
        $success = $_SESSION['status']['message'];
    } else if ($_SESSION['status']['type'] === 'error') {
        $error = $_SESSION['status']['message'];
    }
    unset($_SESSION['status']);
}

$page_title = "View <b>Retired Staff</b>";

$staff = new Staff($db);

if (isset($_GET['d']) && is_numeric($_GET['d']) && !empty($_GET['d'])) {
    $m = new Mda($db);
    $mda = $m->get_mda_by('mda_id', normal_text($_GET['d']));
    if (!$mda || empty($mda)) {
        $_SESSION['status'] = ['type' => 'error', 'message' => 'No MDA found.'];
        go(URL . '/panel/staff');
    }
    $peoples = $staff->get_all_retired_staff_by('mda_id', $mda['mda_id']);
    $page_title = "View <b>" . $mda['mda_name'] . "</b> Retired Staff";
} else {
    $peoples = $staff->get_all_retired_staff();
}


$datatable = true;

include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/retired_staff.view.php';
include_once LAYOUT_DIR.'footer.view.php';
