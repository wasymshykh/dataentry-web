<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}

if (!isset($_GET['s']) || !is_numeric($_GET['s']) && empty($_GET['s'])) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Invalid request.'];
    go(URL . '/panel/promotion');
}

$s = new Staff($db);
$peoples = $s->get_all_promotion();

$found = false;
$record_id = "";
$record_level = "";
foreach ($peoples as $people) {
    if ($people['staff_id'] === $_GET['s']) {
        $found = true;
        $record_id  = $people['staff_id'];
        $record_level  = $people['staff_grade'];
    }
}

if (!$found) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Staff not found.'];
    go(URL . '/panel/promotion');
}

$record_level = ((int)$record_level) + 1;

$result = $s->mark_promote($record_level, $record_id);

if ($result) {
    $_SESSION['status'] = ['type' => 'success', 'message' => 'Staff is successfully promoted from level '. ($record_level-1) .' to ' . $record_level .'.'];
} else {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Cannot level up the staff.'];
}
go(URL . '/panel/promotion');
