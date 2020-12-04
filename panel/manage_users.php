<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}

$u = new Users($db);

$users = $u->get_users();
$site_logs = $u->get_site_logs();

$errors = [];
$success = false;

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['create'])) {

        if (isset($_POST['username']) && is_string($_POST['username']) && !empty(normal_text($_POST['username']))) {
            $username = normal_text($_POST['username']);
            $exist = $u->get_by_username($username);

            if ($exist) {
                array_push($errors, "Username already exists");
            }
        } else {
            array_push($errors, "Username cannot be empty");
        }


        if (isset($_POST['password']) && is_string($_POST['password']) && !empty(normal_text($_POST['password']))) {
            $password = normal_text($_POST['password']);
        } else {
            array_push($errors, "Password cannot be empty");
        }

        if (isset($_POST['type']) && is_string($_POST['type']) && !empty(normal_text($_POST['type']))) {
            $type = normal_text($_POST['type']);
            if ($type !== "A" && $type !== "M" && $type !== "N") {
                array_push($errors, "Please send valid data");
            }
        } else {
            array_push($errors, "Select user type");
        }

        if (isset($_POST['status']) && is_string($_POST['status']) && !empty(normal_text($_POST['status']))) {
            $status = normal_text($_POST['status']);
            if ($status !== "U" && $status !== "A") {
                array_push($errors, "Please send valid data");
            }
        } else {
            array_push($errors, "Select user status");
        }


        if (empty($errors)) {
            
            $password = password_hash($password, PASSWORD_BCRYPT);
            if($u->create($username, $password, $type, $status)) {
                $success = "User has been successfully added!";
            } else {
                array_push($errors, "Could not create the user");
            }

        }

    }

}

$datatable = true;
include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/manage_users.view.php';
include_once LAYOUT_DIR.'footer.view.php';
