<?php

require '../app/start.php';

$u = new Users($db);

$users = $u->get_users();

$datatable = true;
include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/manage_users.view.php';
include_once LAYOUT_DIR.'footer.view.php';
