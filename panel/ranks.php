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


$s = new Staff($db);
$ranks = $s->get_all_ranks();

$sorted_ranks = [];
foreach ($ranks as $rank) {
    $sorted_ranks[$rank['rank_id']] = $rank;
}

if (isset($_POST) && !empty($_POST)) {


    if (isset($_POST['add_rank'])) {

        $rankRank = normal_text($_POST['rankRank']);
        $gradeLevel = normal_text($_POST['gradeLevel']);
        $rankYears = normal_text($_POST['rankYears']);

        if (empty($rankRank) || empty($gradeLevel) || empty($rankYears)) {
            $error = "Rank, level and years are required.";
        } else {
            $r = $s->insert_rank($rankRank, $gradeLevel, $rankYears, count($sorted_ranks)+1);
            if ($r) {
                $_SESSION['status'] = ['type' => 'success', 'message' => 'Rank is successfully inserted'];
                go(URL . '/panel/ranks');
            }
            $error = "Cannot insert the rank.";
        }
        
    }

    if (isset($_POST['edit_ranks'])) {

        $insert = [];

        $i = 1;
        foreach ($_POST['ranks'] as $rank_id => $_rank) {
            array_push($insert, ['rank_id' => $rank_id, 'rank_rank' => $_rank, 'rank_grade' => $_POST['grades'][$rank_id], 'rank_years' => $_POST['years'][$rank_id], 'sort' => $i]);
            $i++;
        }

        $r = $s->update_ranks($insert);

        if ($r) {
            $_SESSION['status'] = ['type' => 'success', 'message' => 'Ranks is successfully updated'];
            go(URL . '/panel/ranks');
        }
        $error = "Cannot update the ranks.";

    }


}


include_once LAYOUT_DIR.'header.view.php';
include_once PAGE_DIR.'panel/ranks.view.php';
include_once LAYOUT_DIR.'footer.view.php';
