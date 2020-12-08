<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}

if (!isset($_GET['s']) || !is_numeric($_GET['s']) && empty($_GET['s'])) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Invalid request.'];
    go(URL . '/panel/retirement');
}

$s = new Staff($db);
$peoples = $s->get_all_retiring();

$found = false;
$record_id = "";
foreach ($peoples as $people) {
    if ($people['staff_id'] === $_GET['s']) {
        $found = true;
        $record_id  = $people['staff_id'];
    }
}

if (!$found) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Staff not found.'];
    go(URL . '/panel/retirement');
}

$result = $s->mark_retired($record_id);

if ($result) {
    $_SESSION['status'] = ['type' => 'success', 'message' => 'Staff is successfully marked as retired.'];
} else {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Cannot update the staff retirement.'];
}
go(URL . '/panel/retirement');
