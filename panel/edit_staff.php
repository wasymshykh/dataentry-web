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
$staff = $s->get_staff_by('staff_id', normal_text($_GET['s']));

if (!$staff || empty($staff)) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Staff not found.'];
    go(URL . '/panel/staff');
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

$mda = new Mda($db);

$sexes = ['M' => 'Male', 'F' => 'Female', 'O' => 'Other'];
$origins = ['E' => 'Example'];
$marritals = ['S' => 'Single', 'M' => 'Married'];
$ranks = ['J' => 'Junior', 'S' => 'Senior'];
$grades = ['17' => 'Seventeen', '18' => 'Eighteen'];
$cadres = ['E' => 'Example', 'G' => 'Good'];
$mdas = $mda->get_all();
$banks = ['1' => 'Bank of US', '2' => 'Bank of Cali'];
$fund_admins = ['1' => 'Anas', '2' => 'Brandon'];
$nhis_hospitals = ['1' => 'Korangi Hospital', '2' => 'Malir Hospital'];



if (isset($_POST) && !empty($_POST)) {
    $result = $s->handle_edit($_POST, $staff, $logged['user_id']);
    if ($result['status']) {
        $_SESSION['status'] = ['type' => 'success', 'message' => $result['message']];
        go(URL . '/panel/edit_staff?s='. $staff['staff_id']);
    }

    $error = $result['message'];
}


include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/edit_staff.view.php';
include_once LAYOUT_DIR.'footer.view.php';

