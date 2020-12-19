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
$staff = $s->get_staff_by_everything('staff_id', normal_text($_GET['s']));

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
$origins = $s->get_all_origins();
$lgas = $s->get_all_lgas();
$marritals = ['S' => 'Single', 'M' => 'Married'];
$ranks = $s->get_all_ranks();
$cadres = $s->get_all_cadre();
$cadres[$staff['staff_cadre']] = $staff['staff_cadre'];
$nationalities = $s->get_all_nationalities();
$nationalities[$staff['staff_nationality']] = $staff['staff_nationality'];
$mdas = $mda->get_all();
$banks = $s->get_all_banks();
$fund_admins = [];
$fund_admins[$staff['staff_fund_admin']] = $staff['staff_fund_admin'];
$nhis_hospitals = [];
$nhis_hospitals[$staff['staff_nhis_hospital']] = $staff['staff_nhis_hospital'];

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

