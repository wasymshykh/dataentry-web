<div class="row">
    <div class="col-auto border-right">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link <?=empty($errors) && !$success ? 'active' : ''?>" id="v-pills-manage-tab" data-toggle="pill" href="#v-pills-manage" role="tab" aria-controls="v-pills-manage" aria-selected="true"><i class="fa fa-users mr-2"></i> Manage Users</a>
            <a class="nav-link <?=!empty($errors) || $success ? 'active' : ''?>" id="v-pills-add-tab" data-toggle="pill" href="#v-pills-add" role="tab" aria-controls="v-pills-add" aria-selected="false"><i class="fa fa-user mr-2"></i> Add User</a>
            <a class="nav-link" id="v-pills-logs-tab" data-toggle="pill" href="#v-pills-logs" role="tab" aria-controls="v-pills-logs" aria-selected="false"><i class="fa fa-server mr-2"></i> View Logs</a>
        </div>
    </div>

    <div class="col">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade <?=empty($errors) && !$success ? 'show active' : ''?>" id="v-pills-manage" role="tabpanel" aria-labelledby="v-pills-manage-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="border-bottom pt-2 pb-2 mb-2">
                            <h3 class="text-center font-weight-light">
                                Manage <b>Users</b>
                            </h3>
                        </div>
                    </div>

                    <div class="col-12">

                            <?php if(!empty($main_errors)): ?>
                                <div class="alert alert-danger">
                                    <dl class="mb-0">
                                        <dt>Error!</dt>
                                    <?php foreach($main_errors as $error): ?>
                                        <dd><?=$error?></dd>            
                                    <?php endforeach; ?>
                                    </dl>
                                </div>
                            <?php endif; ?>
                            <?php if($main_success): ?>
                                <div class="alert alert-success">
                                    <?=$main_success?>
                                </div>
                            <?php endif; ?>

                        <table id="usersTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Added on</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $user['user_id'] ?></td>
                                    <td><?= $user['user_username'] ?></td>
                                    <td><?= ($user['user_role'] === 'A' ? 'Admin' : ($user['user_role'] === 'M' ? 'Manager' : ($user['user_role'] === 'D' ? 'Data Entry' : 'undefined'))) ?></td>
                                    <td><?= ($user['user_status'] === 'A' ? '<span class="badge badge-success">Active</span>' : ($user['user_status'] === 'U' ? '<span class="badge badge-warning">Inactive</span>' : 'undefined')) ?></td>
                                    <td><?= normal_date($user['user_created']) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editUser" data-userid="<?=$user['user_id'] ?>" data-username="<?=$user['user_username'] ?>" data-status="<?= $user['user_status'] ?>" data-type="<?=$user['user_role'] ?>">Edit</button>
                                        <?php if ($user['user_id'] !== SUPER_ADMIN_ID): ?>
                                        <form class="my-0 d-inline" action="" method="post">
                                            <input type="hidden" name="delete" value="<?=$user['user_id']?>">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="tab-pane fade <?=!empty($errors) || $success ? 'show active' : ''?>" id="v-pills-add" role="tabpanel" aria-labelledby="v-pills-add-tab">

                <div class="row">
                    <div class="col-12">
                        <div class="border-bottom pt-2 pb-2 mb-2">
                            <h3 class="text-center font-weight-light">
                                Add a <b>User</b>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-8 offset-lg-2 mb-4 mt-2">
                        
                        <div class="card">
                            <div class="card-body">
                            <?php if(!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <dl>
                                        <dt>Error!</dt>
                                    <?php foreach($errors as $error): ?>
                                        <dd><?=$error?></dd>            
                                    <?php endforeach; ?>
                                    </dl>
                                </div>
                            <?php endif; ?>
                            <?php if($success): ?>
                                <div class="alert alert-success">
                                    <?=$success?>
                                </div>
                            <?php endif; ?>

                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                                    <input type="hidden" name="create">
                                    <div class="form-group">
                                        <label for="username" class="col-form-label">Username:</label>
                                        <input type="text" class="form-control" value="<?=$_POST['username']??''?>" name="username" id="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-form-label">Password:</label>
                                        <input type="password" class="form-control" value="<?=$_POST['password']??''?>" name="password" id="password">
                                        <small class="form-text text-muted">Leave empty if you don't want to change</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="col-form-label">Type:</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="A" <?=!empty($_POST['type']) && $_POST['type'] === 'A' ? 'selected':''?>>Admin</option>
                                            <option value="M" <?=!empty($_POST['type']) && $_POST['type'] === 'M' ? 'selected':''?>>Manager</option>
                                            <option value="D" <?=!empty($_POST['type']) && $_POST['type'] === 'D' ? 'selected':''?>>Date Entry</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status" class="col-form-label">Status:</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="A" <?=!empty($_POST['status']) && $_POST['status'] === 'A' ? 'selected':''?>>Active</option>
                                            <option value="U" <?=!empty($_POST['status']) && $_POST['status'] === 'U' ? 'selected':''?>>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-success">
                                            Add User
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>

            </div>


            <div class="tab-pane fade" id="v-pills-logs" role="tabpanel" aria-labelledby="v-pills-logs-tab">

                <div class="col-12">
                    <div class="border-bottom pt-2 pb-2 mb-2">
                        <h3 class="text-center font-weight-light">
                            Action <b>Logs</b>
                        </h3>
                    </div>
                </div>

                <div class="col-lg-10 offset-lg-1 mb-4 mt-2">
                    
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Log type</th>
                                        <th>Log message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($site_logs as $site_log): ?>
                                        <tr>
                                            <td><div class="badge badge-secondary"><?=normal_date($site_log['sitelog_created'])?></div></td>
                                            <td><?=$site_log['sitelog_type']?></td>
                                            <td><?=$site_log['sitelog_text']?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="edit">
                <input type="hidden" name="user_id" id="user-id-input">
                <div class="form-group">
                    <label for="e_username" class="col-form-label">Username:</label>
                    <input type="text" class="form-control" name="username" id="e_username">
                </div>
                <div class="form-group">
                    <label for="e_password" class="col-form-label">Password:</label>
                    <input type="password" class="form-control" name="password" id="e_password">
                    <small class="form-text text-muted">Leave empty if you don't want to change</small>
                </div>
                <div class="form-group">
                    <label for="e_type" class="col-form-label">Type:</label>
                    <select name="type" id="e_type" class="form-control">
                        <option value="A">Admin</option>
                        <option value="M">Manager</option>
                        <option value="D">Data Entry</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_status" class="col-form-label">Status:</label>
                    <select name="status" id="e_status" class="form-control">
                        <option value="A">Active</option>
                        <option value="U">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>


<script src="<?= URL ?>/static/js/jquery.dataTables.min.js"></script>
<script src="<?= URL ?>/static/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable();

        $('#editUser').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_id = button.data('userid')
            var user_username = button.data('username');
            var user_status = button.data('status')
            var user_type = button.data('type');

            var modal = $(this)
            modal.find('.modal-title').html('Edit User <b>' + user_username + '</b>');
            modal.find('.modal-body #user-id-input').val(user_id);
            modal.find('.modal-body #e_username').val(user_username);

            modal.find('#e_type').val(user_type);
            modal.find('#e_status').val(user_status);
        });

    });
</script>
