<div class="border-bottom pt-2 pb-2 mb-2">
    <h3 class="text-center font-weight-light">Due for Promotion <b>Staff</b></h3>
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
    <div class="col-12">
    
        <table class="table table-striped table-bordered" id="mainTable">
            <thead class="thead-dark">
                <tr>
                    <th width=30>S#</th>
                    <th>Name</th>
                    <th>Reason</th>
                    <th>Last Promotion</th>
                    <th>Rank</th>
                    <th>Grade Level</th>
                    <th>Current MDA</th>
                    <th>Date Posted</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($peoples as $people): if($logged['user_role'] !== 'A' && $people['staff_status'] === 'AP'){continue;} ?>
                <tr>
                    <td><?=$people['staff_id']?></td>
                    <td><?=$people['staff_first_name'] . ' ' . $people['staff_middle_name'] . ' ' . $people['staff_last_name']?></td>
                    <td><?=$people['retirement_type']?></td>
                    <td><?=$people['staff_last_promotion'] ? normal_date($people['staff_last_promotion'], 'M d, Y') : '-'?></td>
                    <td><?=$people['staff_rank']?></td>
                    <td><?=$people['staff_grade']?></td>
                    <td><a href="<?=URL?>/panel/staff?d=<?=$people['mda_id']?>"><?=$people['mda_name']?></a></td>
                    <td><?=$people['staff_mda_posted'] ? normal_date($people['staff_mda_posted'], 'M d, Y') : '-'?></td>
                    <td>
                        <?php if ($people['staff_status'] === 'A'): ?>
                            <span class="badge badge-success">Need action</span>
                        <?php endif; ?>
                        <?php if ($people['staff_status'] === 'AP'): ?>
                            <span class="badge badge-warning">Need approval</span>
                            <span class="badge badge-dark">Requested by <strong class="font-weight-bold"><?=$u->get_by_id($people['staff_promotion_requested_by'])['user_username']?></strong></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?=URL?>/panel/view_staff?s=<?=$people['staff_id']?>" class="btn btn-sm btn-success">View <i class="fa fa-arrow-right ml-1"></i></a>
                        <?php if ($people['staff_status'] !== 'AP'): ?>
                            <a href="<?=URL?>/panel/edit_staff?s=<?=$people['staff_id']?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil mr-1"></i> Edit</a>
                            <a href="<?=URL?>/panel/promote?s=<?=$people['staff_id']?>" class="btn btn-sm btn-danger"><i class="fa fa-arrow-right mr-1"></i> Promote Level</a>
                        <?php else: ?>
                            <a href="<?=URL?>/panel/promote?s=<?=$people['staff_id']?>" class="btn btn-sm btn-danger"><i class="fa fa-check mr-1"></i> Approve</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<script src="<?= URL ?>/static/js/jquery.dataTables.min.js"></script>
<script src="<?= URL ?>/static/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#mainTable').DataTable();
    })
</script>
