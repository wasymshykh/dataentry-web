<div class="row">
    <div class="col-3">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-manage-tab" data-toggle="pill" href="#v-pills-manage" role="tab" aria-controls="v-pills-manage" aria-selected="true">Manage Users</a>
            <a class="nav-link" id="v-pills-add-tab" data-toggle="pill" href="#v-pills-add" role="tab" aria-controls="v-pills-add" aria-selected="false">Add User</a>
            <a class="nav-link" id="v-pills-logs-tab" data-toggle="pill" href="#v-pills-logs" role="tab" aria-controls="v-pills-logs" aria-selected="false">View Logs</a>
        </div>
    </div>

    <div class="col-9">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-manage" role="tabpanel" aria-labelledby="v-pills-manage-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="border-bottom pt-2 pb-2 mb-2">
                            <h3 class="text-center font-weight-light">
                                Manage <b>Users</b>
                            </h3>
                        </div>
                    </div>

                    <div class="col-12">

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
                                    <td><?= $user['user_id'] ?></td>
                                    <td><?= $user['user_username'] ?></td>
                                    <td><?= ($user['user_role'] === 'A' ? 'Admin' : ($user['user_role'] === 'M' ? 'Manager' : ($user['user_role'] === 'N' ? 'Normal' : 'undefined'))) ?></td>
                                    <td><?= ($user['user_status'] === 'A' ? '<span class="badge badge-success">Active</span>' : ($user['user_status'] === 'U' ? '<span class="badge badge-warning">Inactive</span>' : 'undefined')) ?></td>
                                    <td><?= normal_date($user['user_created']) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editUser" data-userid="<?= $user['user_id'] ?>" data-username="<?= $user['user_username'] ?>" data-status="<?= $user['user_status'] ?>" data-type="<?= $user['user_type'] ?>">Edit</button>

                                    </td>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-add" role="tabpanel" aria-labelledby="v-pills-add-tab">...</div>
            <div class="tab-pane fade" id="v-pills-logs" role="tabpanel" aria-labelledby="v-pills-logs-tab">...</div>
        </div>
    </div>
</div>


<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" name="edit">
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
                            <option value="M">Manager</option>
                            <option value="A">Admin</option>
                            <option value="N">Normal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="e_status" class="col-form-label">Type:</label>
                        <select name="status" id="e_status" class="form-control">
                            <option value="A">Active</option>
                            <option value="U">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
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

            modal.find('.model-body #e_type').val(user_type);
            modal.find('.model-body #e_status').val(user_status)
        });

    });
</script>