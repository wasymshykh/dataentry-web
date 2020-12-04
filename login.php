<?php

require __DIR__ . '/app/start.php';

$errors = [];

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['username']) && is_string($_POST['username']) && !empty(normal_text($_POST['username']))) {
        $username = normal_text($_POST['username']);
    } else {
        array_push($errors, 'Username cannot be empty');            
    }

    if (isset($_POST['password']) && is_string($_POST['password']) && !empty(normal_text($_POST['password']))) {
        $password = normal_text($_POST['password']);
    } else {
        array_push($errors, 'Password cannot be empty');
    }

    if (empty($errors)) {

        $login = $auth->login($username, $password);

        if ($login['status']) {
            go(URL . '/panel');
        }

        array_push($errors, $login['message']);

    }

}

include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'login.view.php';
include_once LAYOUT_DIR.'footer.view.php';
