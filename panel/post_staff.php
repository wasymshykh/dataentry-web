<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}

if (!isset($_GET['s']) || !is_numeric($_GET['s']) && empty($_GET['s'])) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Invalid request.'];
    go(URL . '/panel/posting');
}

$s = new Staff($db);
$mda = new Mda($db);

$peoples = $s->get_all_posting();

$found = false;
$record_id = "";
$record_reason = "";
foreach ($peoples as $people) {
    if ($people['staff_id'] === $_GET['s']) {
        $found = true;
        $record_id = $people['staff_id'];
        $record_reason = $people['retirement_type'];
        break;
    }
}

if (!$found) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Staff not found.'];
    go(URL . '/panel/posting');
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

$staff = $s->get_staff_by('staff_id', $record_id);
$mdas = $mda->get_all();

if (isset($_GET['a']) && $_GET['a'] === 'true') {

    $result = $s->post_staff_mda($staff['staff_mda_id'], $staff['staff_mda_next'], $staff['staff_id']);
    $old_mda = $mda->get_mda_by('mda_id', $staff['staff_mda_id'])['mda_name'];
    $new_mda = $mda->get_mda_by('mda_id', $staff['staff_mda_next'])['mda_name'];

    if ($result) {
        $_SESSION['status'] = ['type' => 'success', 'message' => 'Staff is successfully posted from '. $old_mda .' to ' . $new_mda .'.'];
        go(URL . '/panel/posting');
    } else {
        $error = 'Staff is unable to post from '. $old_mda .' to ' . $new_mda .'.';
    }
}

if (isset($_POST) && !empty($_POST)) {

    $mda_id = normal_text($_POST['mda']);
    $old_mda = $mda->get_mda_by('mda_id', $staff['staff_mda_id'])['mda_name'];
    $new_mda = $mda->get_mda_by('mda_id', $mda_id)['mda_name'];

    if ($logged['user_role'] === 'A') {
        $result = $s->post_staff_mda($staff['staff_mda_id'], $mda_id, $staff['staff_id']);
        $message = 'Staff is successfully posted from '. $old_mda .' to ' . $new_mda .'.';
    } else {
        $result = $s->post_staff_mda_approval($mda_id, $staff['staff_id']);
        $message = 'Staff is marked for posting from '. $old_mda .' to ' . $new_mda .'. Request will be approved by admin.';
    }

    if ($result) {
        $_SESSION['status'] = ['type' => 'success', 'message' => $message];
        go(URL . '/panel/posting');
    }
    
    $error = 'Staff is unable to post from '. $old_mda .' to ' . $new_mda .'.';

}


include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/post_staff.view.php';
include_once LAYOUT_DIR.'footer.view.php';
