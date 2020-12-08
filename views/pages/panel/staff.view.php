<div class="border-bottom pt-2 pb-2 mb-2">
    <h3 class="text-center font-weight-light"><?=$page_title?></h3>
</div>


<div class="row">
    <div class="col-12">
    
        <table class="table table-striped table-bordered" id="mainTable">
            <thead class="thead-dark">
                <tr>
                    <th width=30>S#</th>
                    <th>Name</th>
                    <th><abbr title="Date of Birth">DOB</abbr></th>
                    <th>Rank</th>
                    <th>Grade Level</th>
                    <th>Current MDA</th>
                    <th>Date Posted</th>
                    <th>Address</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($peoples as $people): ?>
                <tr>
                    <td><?=$people['staff_id']?></td>
                    <td><?=$people['staff_first_name'] . ' ' . $people['staff_middle_name'] . ' ' . $people['staff_last_name']?></td>
                    <td><?=$people['staff_dob'] ? normal_date($people['staff_dob'], 'M d, Y') : '-'?></td>
                    <td><?=$people['staff_rank']?></td>
                    <td><?=$people['staff_grade']?></td>
                    <td><a href="<?=URL?>/panel/staff?d=<?=$people['mda_id']?>"><?=$people['mda_name']?></a></td>
                    <td><?=$people['staff_mda_posted'] ? normal_date($people['staff_dob'], 'M d, Y') : '-'?></td>
                    <td><?=$people['staff_home_address'] ?? '-'?></td>
                    <td>
                        <a href="<?=URL?>/panel/view_staff?s=<?=$people['staff_id']?>" class="btn btn-sm btn-primary">View <i class="fa fa-arrow-right ml-1"></i></a>
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