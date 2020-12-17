<style>
    #items {
        width: 100%;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    #items li .col-auto i {
        font-size: 1.2em;
        color: #555555;
        padding: 1em 0.5em;
    }
</style>

<div class="border-bottom pt-2 pb-2 mb-2">
    <h3 class="text-center font-weight-light">Ranks</h3>
</div>

<?php if ($success) : ?>
    <div class="alert alert-success">
        <?= $success ?>
    </div>
<?php endif; ?>
<?php if ($error) : ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php endif; ?>


<div class="row">
    <div class="card col-lg-8 offset-lg-2 p-1 mb-4">
        <div class="card-body p-1">
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addRank"><i class="fa fa-plus mr-2"></i> add new rank</button>
        </div>
    </div>

    <div class="card col-xl-10 offset-xl-1 col-lg-12 px-0">

        <div class="card-header">
            <strong>Currently available ranks</strong> <i>drag handle to sort, top is highest and bottom is lowest</i>
        </div>

        <form action="" method="POST" class="card-body p-4">
            <input type="hidden" name="edit_ranks">
            <ul id="items">
            
                <?php foreach($ranks as $rank): ?>
                <li class="border row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-arrows-alt handle"></i>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group border-right pr-3">
                                    <label for="rank-<?=$rank['rank_id']?>" class="input-group-prepend m-0">
                                        <span class="input-group-text">Rank</span>
                                    </label>
                                    <input type="text" name="ranks[<?=$rank['rank_id']?>]" id="rank-<?=$rank['rank_id']?>" class="form-control" value="<?=$rank['rank_rank']?>" placeholder="write here">
                                </div>
                            </div>
                            <div class="col-lg-3 pl-0">
                                <div class="input-group border-right pr-3">
                                    <label for="grade-<?=$rank['rank_id']?>" class="input-group-prepend m-0">
                                        <span class="input-group-text">Grade Level</span>
                                    </label>
                                    <input type="text" name="grades[<?=$rank['rank_id']?>]" id="grade-<?=$rank['rank_id']?>" class="form-control" value="<?=$rank['rank_grade']?>" placeholder="write here">
                                </div>
                            </div>
                            <div class="col-lg-3 pl-0">
                                <div class="input-group">
                                    <label for="years-<?=$rank['rank_id']?>" class="input-group-prepend m-0">
                                        <span class="input-group-text">Years Required</span>
                                    </label>
                                    <input type="text" name="years[<?=$rank['rank_id']?>]" id="years-<?=$rank['rank_id']?>" class="form-control" value="<?=$rank['rank_years']?>" placeholder="e.g 1">
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            
            </ul>

            
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>


    </div>
</div>



<div class="modal fade" id="addRank" tabindex="-1" role="dialog" aria-labelledby="addRankCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" action="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRankLongTitle">Add Rank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="add_rank">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-circle-o"></i></span>
                    </div>
                    <input type="text" class="form-control" name="rankRank" id="rankRank" placeholder="Rank" value="">
                </div>
                <div class="input-group mt-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-circle-o"></i></span>
                    </div>
                    <input type="text" class="form-control" name="gradeLevel" id="gradeLevel" placeholder="Grade level" value="">
                </div>
                <div class="input-group mt-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-circle-o"></i></span>
                    </div>
                    <input type="number" class="form-control" name="rankYears" id="rankYears" placeholder="Years required for promotion" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.12.0/dist/sortable.umd.min.js"></script>

<script>
    var el = document.getElementById("items");
    var sortable = Sortable.create(el, {
        handle: '.handle',
        animation: 150,
        ghostClass: 'blue-background-class'
    });
</script>