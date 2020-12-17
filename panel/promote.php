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
$current_rank_id = "";
$record_level = "";
foreach ($peoples as $people) {
    if ($people['staff_id'] === $_GET['s']) {
        $found = true;
        $record_id  = $people['staff_id'];
        $current_rank_id  = $people['rank_id'];
        $record_level  = $people['rank_grade'];
        break;
    }
}

if (!$found) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Staff not found.'];
    go(URL . '/panel/promotion');
}

// [0 => rank_id, 1 => rank_grade]
$next_level = $s->get_next_level($current_rank_id);

if ($next_level === false) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Cannot level up the staff.'];
} else {
        
    if ($logged['user_role'] === 'M') {
        $result = $s->make_promote_approval($logged['user_id'], $record_id);
        if ($result) {
            $_SESSION['status'] = ['type' => 'success', 'message' => 'Promotion from grade level '. $record_level .' to ' . $next_level[1] .' is successfully requested. Awaiting for the admin approval.'];
        }
        go(URL . '/panel/promotion');
    
    } else {
        $result = $s->mark_promote($next_level[0], $record_id);
    }
    
    if ($result) {
        $_SESSION['status'] = ['type' => 'success', 'message' => 'Staff is successfully promoted from grade level '. $record_level .' to ' . $next_level[1] .'.'];
    } else {
        $_SESSION['status'] = ['type' => 'error', 'message' => 'Cannot level up the staff.'];
    }
}
go(URL . '/panel/promotion');
