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

$s = new Staff($db);

$peoples = $s->get_all_retiring();

$datatable = true;

include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/retirement.view.php';
include_once LAYOUT_DIR.'footer.view.php';
