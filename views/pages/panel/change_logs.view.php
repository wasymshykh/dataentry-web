<div class="col-12">
    <div class="border-bottom pt-2 pb-2 mb-2">
        <h3 class="text-center font-weight-light">
            Change <b>Logs</b>
        </h3>
    </div>
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

<div class="col-lg-10 offset-lg-1 mt-2">
    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                <input type="hidden" name="clear_logs">
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Clear Logs</button>
            </form>
        </div>
    </div>
</div>


<div class="col-lg-10 offset-lg-1 mb-4 mt-2">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="mainTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>By</th>
                        <th>To</th>
                        <th>Changes</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><div class="badge badge-secondary"><?=normal_date($log['change_created'])?></div></td>
                            <td><a href="<?=URL?>/panel/change_logs?user=<?=$log['change_user_id']?>"><?=$log['user_username']?></a></td>
                            <td><a href="<?=URL?>/panel/change_logs?staff=<?=$log['change_staff_id']?>"><?=$log['change_staff_id']?></a></td>
                            <td><?=$log['change_text']?></td>
                            <td><?=$log['change_raw']?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="<?= URL ?>/static/js/jquery.dataTables.min.js"></script>
<script src="<?= URL ?>/static/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#mainTable').DataTable();
    })
</script>
