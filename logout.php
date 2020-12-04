<?php

require __DIR__ . '/app/start.php';

session_unset();
session_destroy();

go(URL . '/login');
