<div class="border-bottom pt-2 pb-2 mb-2">
    <h3 class="text-center font-weight-light">Manage <b>MDA</b></h3>
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
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><i class="fa fa-plus"></i> Add MDA</div>
            <div class="card-body">

                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                    <input type="hidden" name="mda_create">
                    <div class="mb-3">
                        <label for="name">MDA Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-building"></i></span>
                            </div>
                            <input type="text" class="form-control" name="name" id="name" placeholder="MDA name" value="<?= $_POST['name'] ?? '' ?>">
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Create <i class="fa fa-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">

        <table class="table table-bordered mt-4">
            <thead class="thead-dark">
                <tr>
                    <th width=40></th>
                    <th>Name</th>
                    <th>Added</th>
                    <th>Staff</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $department): ?>
                <tr>
                    <td><input class="rMda-radio" type="radio" name="Mda-action" value="<?=$department['mda_id']?>"></td>
                    <td><?=$department['mda_name']?></td>
                    <td><small><?=normal_date($department['mda_created'])?></small></td>
                    <td>-</td>
                    <td>
                        <a href="<?=URL?>/panel/staff?d=<?=$department['mda_id']?>" class="btn btn-sm btn-primary">View Staff <i class="fa fa-arrow-right ml-2"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <button class="btn btn-sm btn-primary" id="renameMdaBtn"><i class="fa fa-pencil"></i> Rename</button>
                        <button class="btn btn-sm btn-danger" id="deleteMdaBtn"><i class="fa fa-trash"></i> Delete</button>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>
</div>


<div class="modal fade" id="renameMda" tabindex="-1" role="dialog" aria-labelledby="renameMdaCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" action="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renameMdaLongTitle">Rename Mda - <strong id="rMda-name"></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="rename_Mda" id="rename_Mda">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-building"></i></span>
                    </div>
                    <input type="text" class="form-control" name="rMda" id="rMda" placeholder="Mda name" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Rename MDA</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="deleteMda" tabindex="-1" role="dialog" aria-labelledby="deleteMdaCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" action="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMdaLongTitle">Confirm Deleting - <strong id="dMda-name"></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="delete_Mda" id="delete_Mda">
                <p>Are you sure about deleting the department?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>


<script>

    $("#renameMdaBtn").on('click', (e) => {
        _checked = $(".rMda-radio:checked");
        if (_checked.length > 0) {
            _Mda_id = _checked.val();
            _Mda_name = _checked.parent().next().text();
            $("#rMda").val(_Mda_name);
            $("#rename_Mda").val(_Mda_id);
            $("#rMda-name").text(_Mda_name);
            $('#renameMda').modal('show')
        }
    })

    $("#deleteMdaBtn").on('click', (e) => {
        _checked = $(".rMda-radio:checked");
        if (_checked.length > 0) {
            _Mda_id = _checked.val();
            _Mda_name = _checked.parent().next().text();
            $("#dMda").val(_Mda_name);
            $("#delete_Mda").val(_Mda_id);
            $("#dMda-name").text(_Mda_name);
            $('#deleteMda').modal('show')
        }
    })
</script>
