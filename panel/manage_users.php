<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
}

$u = new Users($db);

$users = $u->get_users();

$main_errors = [];
$errors = [];
$main_success = false;
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
            if ($type !== "A" && $type !== "M" && $type !== "D") {
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
                $users = $u->get_users();
            } else {
                array_push($errors, "Could not create the user");
            }

        }

    }


    if (isset($_POST['edit'])) {

        if (isset($_POST['user_id']) && is_numeric($_POST['user_id']) && !empty($_POST['user_id'])) {

            $user = $u->get_by_id(normal_text($_POST['user_id']));

            if ($user) {

                if (!isset($_POST['username']) || !is_string($_POST['username']) || empty(normal_text($_POST['username']))) {
                    array_push($main_errors, "Username cannot be empty");
                }
                if (!isset($_POST['password'])) {
                    array_push($errors, "Password field is not submitted");
                }
                if (isset($_POST['type']) && is_string($_POST['type']) && !empty(normal_text($_POST['type']))) {
                    $type = normal_text($_POST['type']);
                    if ($type !== "A" && $type !== "M" && $type !== "D") {
                        array_push($main_errors, "Please send valid data");
                    }
                } else {
                    array_push($main_errors, "Select user type");
                }
                if (isset($_POST['status']) && is_string($_POST['status']) && !empty(normal_text($_POST['status']))) {
                    $status = normal_text($_POST['status']);
                    if ($status !== "U" && $status !== "A") {
                        array_push($main_errors, "Please send valid data");
                    }
                } else {
                    array_push($main_errors, "Select user status");
                }

                if (empty($errors)) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $log = "For user_id#".$user['user_id']." - ";
                    $changes = [];
                    if ($user['user_username'] != $username) {
                        $exist = $u->get_by_username($username);
                        if ($exist) {
                            array_push($main_errors, "Username already exists");
                        } else {
                            $log .= "Username changed from ".$user['user_username']." to ".$username.". ";
                            $changes['user_username'] = $username;
                        }
                    }
                    if (!empty($password) && !password_verify($password, $user['user_password'])) {
                        $log .= "Password changed. ";
                        $changes['user_password'] = password_hash($password, PASSWORD_BCRYPT);
                    }
                    if ($user['user_role'] != $type) {
                        $log .= "Role changed from " . role_name($user['user_role']) . " to " . role_name($type).". ";
                        $changes['user_role'] = $type;
                    }
                    if ($user['user_status'] != $status) {
                        $log .= "User status changed from " . status_name($user['user_status']) . " to " . status_name($status).". ";
                        $changes['user_status'] = $status;
                    }

                    if (empty($main_errors)) {
                        if (!empty($changes)) {
                            $log .= " Changes made by user_id#".$logged['user_id']."{".$logged['user_username']."}.";
                            $result = $u->edit_user($changes, $user['user_id'], $log);
    
                            if ($result['status']) {
                                $main_success = "User has been updated!";
                                $users = $u->get_users();
                            } else {
                                array_push($main_errors, $result['message']);
                            }

                        } else {
                            $main_success = "No changes made to the user";
                        }
                    }

                }

            } else {
                array_push($main_errors, "E.02 - Invalid data submission");
            }
        } else {
            array_push($main_errors, "E.01 - Invalid data submission");
        }
        $old_user = "";
    }

    if (isset($_POST['delete']) && is_numeric($_POST['delete']) && !empty($_POST['delete'])) {
        $user = $u->get_by_id(normal_text($_POST['delete']));
        if ($user) {

            if ($user['user_id'] === SUPER_ADMIN_ID) {
                array_push($main_errors, "You cannot delete the super admin.");
            } else {

                $log = "For user_id#".$user['user_id']." - deleted by user_id#".$logged['user_id']."{".$logged['user_username']."}.";
                $result = $u->delete_user($user['user_id'], $log);

                if ($result['status']) {
                    $main_success = "User has been updated!";
                    $users = $u->get_users();
                } else {
                    array_push($main_errors, $result['message']);
                }

            }

        } else {
            array_push($main_errors, "E.03 - Invalid data submission");
        }

    }

    if (isset($_POST['clear_logs'])) {
        $s = $u->clear_logs();
        if ($s) {
            $main_success = "Logs has been cleared!";
        } else {
            array_push($main_errors, "Unable to clear the logs.");
        }
    }

}

$site_logs = $u->get_site_logs();

$datatable = true;
include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/manage_users.view.php';
include_once LAYOUT_DIR.'footer.view.php';
