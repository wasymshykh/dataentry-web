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

if (isset($_GET['user']) && is_numeric($_GET['user'])) {
    $logs = $s->get_all_changes_by('change_user_id', $_GET['user']);
} elseif (isset($_GET['staff']) && is_numeric($_GET['staff'])) {
    $logs = $s->get_all_changes_by('change_staff_id', $_GET['staff']);
} else {
    $logs = $s->get_all_changes();
}

if (isset($_POST) && !empty($logs) && isset($_POST['clear_logs'])) {

    $m = "";
    if (isset($_GET['user']) && is_numeric($_GET['user'])) {
        $r = $s->remove_all_changes_by('change_user_id', $_GET['user']);
        $m = "?user=" . $_GET['user'];
    } elseif (isset($_GET['staff']) && is_numeric($_GET['staff'])) {
        $r = $s->remove_all_changes_by('change_staff_id', $_GET['staff']);
        $m = "?staff=" . $_GET['staff'];
    } else {
        $r = $s->remove_all_changes();
    }

    if ($r) {
        $_SESSION['status'] = ['type' => 'success', 'message' => 'Logs are successfully cleared'];
        go(URL . '/panel/change_logs' . $m);
    }

    
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Logs cannot be cleared'];
    go(URL . '/panel/change_logs' . $m);

}

$datatable = true;

include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/change_logs.view.php';
include_once LAYOUT_DIR.'footer.view.php';
