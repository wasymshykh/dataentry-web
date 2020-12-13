<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$settings->fetch('site_title')?></title>

    <link rel="stylesheet" href="<?=URL?>/static/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?=URL?>/static/css/style.css">

    <script src="<?=URL?>/static/js/jquery-3.5.1.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <?php if (isset($datatable)): ?>
        <link rel="stylesheet" href="<?=URL?>/static/css/dataTables.bootstrap4.min.css">
    <?php endif; ?>

</head>
<body>

    <div class="container-fluid p-4">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="<?=URL?><?=$logged ? '/panel' : ''?>">
                <img src="<?=URL?>/static/images/logo-icon.png" width="30" height="30" class="d-inline-block align-top" alt="<?=$settings->fetch('site_title')?>" loading="lazy">
                <b>Data Entry</b> System
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="main-nav">
                <ul class="navbar-nav">
                    <?php if ($logged): ?>
                        <?php if ($logged['user_role'] === 'A' || $logged['user_role'] === 'M'): ?>
                            <?php if($logged['user_role'] !== 'M'): ?>
                            <li class="nav-item"><a href="<?=URL?>/panel/manage_users" class="nav-link"><i class="fa fa-users"></i> Users</a></li>
                            <?php endif; ?>
                            <li class="nav-item"><a href="<?=URL?>/panel/mda" class="nav-link"><i class="fa fa-building"></i> <?=$logged['user_role'] === 'M' ? 'View' :''?> MDA</a></li>
                            <li class="nav-item dropdown">
                                <a href="<?=URL?>/panel/staff" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-black-tie"></i> Staff
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?=URL?>/panel/staff">Active Staff</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?=URL?>/panel/retired_staff">Retired Staff</a>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php if ($logged['user_role'] !== 'M'): ?>
                            <li class="nav-item"><a href="<?=URL?>/panel/create_staff" class="nav-link"><i class="fa fa-plus"></i> Add Entry</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?=URL?>">Home <span class="sr-only">(current)</span></a></li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if($logged): ?>
                        <li class="nav-item"><a class="nav-link active" href="<?=URL?>/panel">Panel</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?=URL?>/logout">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?=URL?>/login">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <div class="card">
            <div class="card-body">            
