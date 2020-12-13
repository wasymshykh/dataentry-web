
<div class="row">
    <div class="col-lg-4 col-md-8 offset-lg-4">
        <div class="card">
            <div class="card-header">Take the action</div>
            <div class="card-body">
                <div class="border p-4">
                    <p class="mb-0"><strong>Staff ID:</strong> #<?=$staff['staff_id']?></p>
                    <p class="mb-0"><strong>Name:</strong> <?=$staff['staff_first_name'].' '. $staff['staff_middle_name'] . ' ' . $staff['staff_last_name']?></p>
                    <p class="mb-0 text-danger"><strong>Current MDA:</strong> <?=$mda->get_mda_by('mda_id', $staff['staff_mda_id'])['mda_name']?></p>
                    <p class="mb-0"><strong>Reason:</strong> <?=$record_reason;?></p>
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

                <form method="POST" action="" class="mt-4">
                    
                    <div class="pb-3 border-bottom mb-3">
                        <label for="mda">Choose MDA</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                            </div>
                            <select name="mda" id="mda" class="form-control select2">
                                <?php foreach ($mdas as $key => $value): ?>
                                    <option value="<?=$value['mda_id']?>" <?=(isset($_POST['mda']) && $_POST['mda']===$value['mda_id'])?'selected':($value['mda_id'] === $staff['staff_mda_id'] ? 'selected' : '')?>><?=$value['mda_name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <small class="p-2 d-block text-secondary bg-light bg-gradient">Change department to transfer and keep the selected item for extending.</small>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Update Posting</button>
                    </div>
                
                </form>

            </div>
        </div>
    </div>
</div>

