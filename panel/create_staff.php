<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}
$staff = new Staff($db);

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
$origins = $staff->get_all_origins();
$lgas = $staff->get_all_lgas();
$marritals = ['S' => 'Single', 'M' => 'Married'];
$ranks = $staff->get_all_ranks();
$cadres = $staff->get_all_cadre();
$mdas = $mda->get_all();
$banks = $staff->get_all_banks();
$fund_admins = ['Anas' => 'Anas', 'Brandon' => 'Brandon'];
$nhis_hospitals = ['Korangi Hospital' => 'Korangi Hospital', 'Malir Hospital' => 'Malir Hospital'];

if (isset($_POST) && !empty($_POST)) {

    $result = $staff->handle_create($_POST, $logged['user_id']);

    if ($result['status']) {
        $_SESSION['status'] = ['type' => 'success', 'message' => $result['message']];
        go(URL . '/panel/create_staff');
    }

    $error = $result['message'];

}


include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/create_staff.view.php';
include_once LAYOUT_DIR.'footer.view.php';
