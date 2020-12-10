<?php

require '../app/start.php';

if (!$logged) {
    go(URL . '/login');
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
$staff = new Staff($db);

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['mda_create'])) {
        if (!isset($_POST['name']) || !is_string($_POST['name']) || empty(normal_text($_POST['name']))) {
            $error = "Please provide name of MDA";            
        }
        if (!$error) {
            $name = normal_text($_POST['name']);
            $found = $mda->get_mda_by('mda_name', $name);
            if ($found && !empty($found)) {
                $error = "Department name already exists.";
            } else {
                $result = $mda->create($name);
                if ($result['status']) {
                    $_SESSION['status'] = ['type' => 'success', 'message' => 'Department successfully created!'];
                    go(URL . '/panel/mda');
                }
                $error = $result['status'];
            }
        }
    }


    if (isset($_POST['rename_Mda']) && is_numeric($_POST['rename_Mda']) && !empty(normal_text($_POST['rename_Mda']))) {
        if (!isset($_POST['rMda']) || !is_string($_POST['rMda']) || empty(normal_text($_POST['rMda']))) {
            $error = "Please provide name of MDA";            
        }
        if (!$error) {
            $id = normal_text($_POST['rename_Mda']);
            $name = normal_text($_POST['rMda']);
            
            $get = $mda->get_mda_by('mda_id', $id);
            if (!$get || empty($get)) {
                $error = "No department found";
            } else if ($get['mda_name'] != $name) {
                
                $found = $mda->get_mda_by('mda_name', $name);
                if ($found && !empty($found)) {
                    $error = "Department name already exists.";
                } else {
                    $result = $mda->update($name, $get['mda_id']);
                    if ($result['status']) {
                        $_SESSION['status'] = ['type' => 'success', 'message' => 'Department successfully update!'];
                        go(URL . '/panel/mda');
                    }
                    $error = $result['status'];
                }
            } else {
                if ($result['status']) {
                    $_SESSION['status'] = ['type' => 'success', 'message' => 'No change is made to the data'];
                    go(URL . '/panel/mda');
                }
            }
        }
    }


    if (isset($_POST['delete_Mda']) && is_numeric($_POST['delete_Mda']) && !empty(normal_text($_POST['delete_Mda']))) {
        $id = normal_text($_POST['delete_Mda']);        
        $get = $mda->get_mda_by('mda_id', $id);
        if (!$get || empty($get)) {
            $error = "No department found";
        } else {
            $result = $mda->delete($get['mda_id']);
            if ($result['status']) {
                $_SESSION['status'] = ['type' => 'success', 'message' => 'Department successfully deleted!'];
                go(URL . '/panel/mda');
            }
            $error = $result['status'];
        }
    }

}

$departments = $mda->get_all();

include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/mda.view.php';
include_once LAYOUT_DIR.'footer.view.php';
