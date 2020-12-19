<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<div class="border-bottom pt-2 pb-2 mb-2">
    <h3 class="text-center font-weight-light">Create <b>Staff</b></h3>
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

<form action="" method="POST" enctype="multipart/form-data" class="row" style="margin-bottom: 5em;">
    <div class="col-xl-4 col-lg-4 col-md-6">
        <div class="card">
            <div class="card-header">Bio</div>
            <div class="card-body">
                <div class="pb-3">
                    <label for="fname">First Name</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="First name" value="<?= $_POST['fname'] ?? '' ?>">
                    </div>
                </div>
                <div class="pb-3">
                    <label for="mname">Middle Name</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="mname" id="mname" placeholder="Middle name" value="<?= $_POST['mname'] ?? '' ?>">
                    </div>
                </div>
                <div class="pb-3">
                    <label for="lname">Last Name</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Last name" value="<?= $_POST['lname'] ?? '' ?>">
                    </div>
                </div>
                <div class="pb-3">
                    <label for="dob">Date of Birth</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="date" class="form-control" name="dob" id="dob" value="<?= $_POST['dob'] ?? '' ?>">
                    </div>
                </div>
                <div class="pb-3">
                    <label for="sex">Sex</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="sex" id="sex" class="form-control">
                            <?php foreach ($sexes as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['sex']) && $_POST['sex']===$key)?'selected':''?>><?=$value?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="pf">PF. No</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="pf" id="pf" placeholder="PF. No" value="<?= $_POST['pf'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="nationality">Nationality</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="nationality" id="nationality" class="form-control select-nationality">
                            <?php foreach ($nationalities as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['nationality']) && $_POST['nationality']===$key)?'selected':''?>><?=$value?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="pb-3">
                    <label for="origin">State of origin</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="origin" id="origin" class="form-control select2">
                            <option value=""></option>
                            <?php foreach ($origins as $state): ?>
                                <option value="<?=$state['state_id']?>" <?=(isset($_POST['origin']) && $_POST['origin']=== $state['state_id'])?'selected':''?>><?=$state['state_name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="lga">LGA</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        
                        <select name="lga" id="lga" class="form-control select2">
                            <option value=""></option>
                            <?php if(isset($_POST['origin'])): ?>
                                <?php $s_lgas = $staff->get_lgas_by('lga_state_id', $_POST['origin']); foreach($s_lgas as $s_lga): ?>
                                    <option value="<?=$s_lga['lga_id']?>" <?=(isset($_POST['lga']) && $_POST['lga']=== $s_lga['lga_id'])?'selected':''?>><?=$s_lga['lga_name']?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="pb-3">
                    <label for="marrital">Marrital Status</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="marrital" id="marrital" class="form-control">
                            <?php foreach ($marritals as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['marrital']) && $_POST['marrital']===$key)?'selected':''?>><?=$value?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="pb-3">
                    <label for="childern">No of childern</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="number" class="form-control" name="childern" id="childern" placeholder="No of childern" value="<?= $_POST['childern'] ?? '' ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-6">
        <div class="card">
            <div class="card-header">Education</div>
            <div class="card-body">
                <div class="pb-3">
                    <label for="qualification">Highest Qualification</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="qualification" id="qualification" placeholder="Highest Qualification" value="<?= $_POST['qualification'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="appointment-rank">Rank of 1st Appointment</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="appointment-rank" id="appointment-rank" placeholder="Rank of 1st Appointment" value="<?= $_POST['appointment-rank'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="appointment-date">Date of 1st Appointment</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="date" class="form-control" name="appointment-date" id="appointment-date" value="<?= $_POST['appointment-date'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="next-kin">Next of Kin</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="next-kin" id="next-kin" placeholder="Next of Kin" value="<?= $_POST['next-kin'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="kin-phone">Next of Phone No</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="kin-phone" id="kin-phone" placeholder="Next of Phone No" value="<?= $_POST['kin-phone'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="kin-address">Next of Kin Address</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="kin-address" id="kin-address" placeholder="Next of Kin Address" value="<?= $_POST['kin-address'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="kin-email">Next of Kin Email</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="kin-email" id="kin-email" placeholder="Next of Kin Email" value="<?= $_POST['kin-email'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="confirmation">Confirmation Date</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="date" class="form-control" name="confirmation" id="confirmation" value="<?= $_POST['confirmation'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="last-promotion">Last Promotion Date</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="date" class="form-control" name="last-promotion" id="last-promotion" value="<?= $_POST['last-promotion'] ?? '' ?>">
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="present-rank">Present Rank</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="present-rank" id="present-rank" class="form-control select2">
                            <option value=""></option>
                            <?php foreach ($ranks as $rank): ?>
                                <option value="<?=$rank['rank_id']?>" <?=(isset($_POST['present-rank']) && $_POST['present-rank']===$rank['rank_id'])?'selected':''?>><?=$rank['rank_rank']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="pb-3">
                    <label for="present-grade">Present Grade Level</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" name="present-grade" id="present-grade" class="form-control" value="<?=$_POST['present-grade'] ?? ''?>" readonly>
                    </div>
                </div>

                <div class="pb-3">
                    <label for="cadre">Cadre</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="cadre" id="cadre" class="form-control select-cadre">
                            <?php foreach ($cadres as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['cadre']) && $_POST['cadre']===$key)?'selected':''?>><?=$value?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-6">
        <div class="card">
            <div class="card-header">Employment</div>
            <div class="card-body">
            
                <div class="pb-3">
                    <label for="mda">Current MDA</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="mda" id="mda" class="form-control select2">
                            <?php foreach ($mdas as $key => $value): ?>
                                <option value="<?=$value['mda_id']?>" <?=(isset($_POST['mda']) && $_POST['mda']===$value['mda_id'])?'selected':''?>><?=$value['mda_name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="pb-3">
                    <label for="mda-posted">Date Posted to MDA</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="date" class="form-control" name="mda-posted" id="mda-posted" value="<?= $_POST['mda-posted'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="last-posting">Last Posting</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="last-posting" id="last-posting" class="form-control select2">
                            <option value=""></option>
                            <?php foreach ($mdas as $key => $value): ?>
                                <option value="<?=$value['mda_id']?>" <?=(isset($_POST['last-posting']) && $_POST['last-posting']===$value['mda_id'])?'selected':''?>><?=$value['mda_name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="pb-3">
                    <label for="duration-mda">Duration in MDA</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control disabled" name="duration-mda" id="duration-mda" placeholder="Duration in MDA" value="<?= $_POST['duration-mda'] ?? '' ?>" readonly>
                    </div>
                </div>

                <div class="pb-3">
                    <label for="home-address">Permanent Home Address</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="home-address" id="home-address" placeholder="Home Address" value="<?= $_POST['home-address'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="contact-address">Contact Address</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="contact-address" id="contact-address" placeholder="Contact Address" value="<?= $_POST['contact-address'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="phone-no">Phone No</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="phone-no" id="phone-no" placeholder="Phone No" value="<?= $_POST['phone-no'] ?? '' ?>">
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="email-address">Email Address</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="email" class="form-control" name="email-address" id="email-address" placeholder="Email Address" value="<?= $_POST['email-address'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="bank">Bank</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="bank" id="bank" class="form-control select2">
                            <option value=""></option>
                            <?php foreach ($banks as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['bank']) && $_POST['bank']===$value)?'selected':''?>><?=$value?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="pb-3">
                    <label for="account-no">Account No</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="account-no" id="account-no" placeholder="account no" value="<?= $_POST['account-no'] ?? '' ?>">
                    </div>
                </div>
                
                <div class="pb-3">
                    <label>Membership to professional bodies</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="simple-tags" id="membership-fields" data-simple-tags="<?= $_POST['membership'] ?? '' ?>"></div>
                        <input type="hidden" name="membership" id="membership" value="<?= $_POST['membership'] ?? '' ?>">
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="fund-admin">Pension Fund Admin</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="fund-admin" id="fund-admin" class="form-control select-admin">
                            <option value=""></option>
                            <?php foreach ($fund_admins as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['fund-admin']) && $_POST['fund-admin']===$value)?'selected':''?>><?=$value?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="pension-pin">Pension Pin No</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="pension-pin" id="pension-pin" placeholder="Pension Pin No" value="<?= $_POST['pension-pin'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="nhf-no">NHF No</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="nhf-no" id="nhf-no" placeholder="NHF No" value="<?= $_POST['nhf-no'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="nin">NIN</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="nin" id="nin" placeholder="NIN" value="<?= $_POST['nin'] ?? '' ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="tin">TIN</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="tin" id="tin" placeholder="TIN" value="<?= $_POST['tin'] ?? '' ?>">
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="nhis">NHIS Hospital</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="nhis" id="nhis" class="form-control select-nhis">
                            <option value=""></option>
                            <?php foreach ($nhis_hospitals as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['nhis']) && $_POST['nhis']===$value)?'selected':''?>><?=$value?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="e" class="form-label">Insert Passport</label>
                    <div>
                        <label for="passport-image">
                            <img src="<?=URL?>/static/images/no_picture.jpg" alt="picture" class="passportimg" id="picture">
                        </label>
                    </div>
                    <div class="row align-items-end">
                        <div class="col">
                            <label for="passport-image"><small class="badge">Upload photo</small></label>
                            <input class="form-control" type="file" id="passport-image" name="passport-image" accept="image/*" onchange="loadFile(event)">
                            <input type="hidden" name="snapfile" id="snapfile" value="">
                        </div>
                        <div class="col-auto border-right border-left">OR</div>
                        <div class="col">
                            <button type="button" class="btn btn-danger" id="takePhotoBtn"><i class="fa fa-camera"></i> Take photo</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="fixed-bottom">
        <div class="row bg-dark">
            <div class="col-12 p-4 text-center d-flex justify-content-center align-items-center">
                <h5 class="my-0 mr-4 text-white font-weight-light text-uppercase" style="opacity: 0.5;letter-spacing:1px;">Perform Action</h5>
                <button type="submit" class="btn btn-success">Create Record <i class="fa fa-check"></i></button>
            </div>
        </div>
    </div>

</form>


<div class="modal fade" id="takePhoto" tabindex="-1" aria-labelledby="takePhotoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="takePhotoLabel">Take a photo</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <img src="" class="d-none mb-2" id="preview" alt="Preview" style="width:460px;height:460px;">
                        <video id="webcam" autoplay playsinline width="460" height="460"></video>
                        <canvas id="canvas" class="d-none"></canvas>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-sm btn-success" id="snap"><i class="fa fa-camera"></i> Snap</button>
                        <button type="button" class="btn btn-sm btn-danger d-none" id="takeagain"><i class="fa fa-repeat"></i> take again</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
<script src="<?=URL?>/static/js/script-min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


<script>

    let state_lgas = {<?php foreach ($origins as $state): $s_lgas = $staff->get_lgas_by('lga_state_id', $state['state_id']); ?>
        '<?=$state['state_id']?>': [<?php foreach ($s_lgas as $s_lga): ?>{'id':'<?=$s_lga['lga_id']?>', 'text':"<?=$s_lga['lga_name']?>"},<?php endforeach?>],
        <?php endforeach; ?>};

    $('#origin').on('change', (e) => {
        let state_data = state_lgas[e.target.value];
        $('#lga').html('').select2({
            data: state_data
        })
    })

    $(document).ready(function() {
        $('.select2').select2();
        $('.select-admin').select2({tags: true});
        $('.select-nhis').select2({tags: true});
        $('.select-cadre').select2({tags: true});
        $('.select-nationality').select2({tags: true});
    });

    function dateDiff(startingDate, endingDate) {
        var startDate = new Date(new Date(startingDate).toISOString().substr(0, 10));
        if (!endingDate) {
            endingDate = new Date().toISOString().substr(0, 10);    // need date in YYYY-MM-DD format
        }
        var endDate = new Date(endingDate);
        if (startDate > endDate) {
            var swap = startDate;
            startDate = endDate;
            endDate = swap;
        }
        var startYear = startDate.getFullYear();
        var february = (startYear % 4 === 0 && startYear % 100 !== 0) || startYear % 400 === 0 ? 29 : 28;
        var daysInMonth = [31, february, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        var yearDiff = endDate.getFullYear() - startYear;
        var monthDiff = endDate.getMonth() - startDate.getMonth();
        if (monthDiff < 0) {
            yearDiff--;
            monthDiff += 12;
        }
        var dayDiff = endDate.getDate() - startDate.getDate();
        if (dayDiff < 0) {
            if (monthDiff > 0) {
                monthDiff--;
            } else {
                yearDiff--;
                monthDiff = 11;
            }
            dayDiff += daysInMonth[startDate.getMonth()];
        }

        return yearDiff + ' Years ' + monthDiff + ' Months ' + dayDiff + ' Days';
    }

    $('#mda-posted').on('change', (e) => {
        var starts = new Date($('#mda-posted').val());
        var ends = new Date();
        var diff = dateDiff(starts, ends);
        $('#duration-mda').val(diff);
    })

    let grades = {<?php foreach($ranks as $rank): ?> '<?=$rank['rank_id']?>': '<?=$rank['rank_grade']?>', <?php endforeach; ?>};

    $('#present-rank').on('change', (e) => {
        $('#present-grade').val(grades[$('#present-rank').val()]);
    })

    const takephotobtn = document.getElementById('takePhotoBtn');

    const webcamElement = document.getElementById('webcam');
    const canvasElement = document.getElementById('canvas');
    const webcam = new Webcam(webcamElement, 'user', canvasElement, null);

    takephotobtn.addEventListener('click', (e) => {
        webcam.start()
        .then(result =>{
            console.log("webcam started.");
            $('#takePhoto').modal('show');
        })
        .catch(err => {
            console.log(err);
        });
    })

    $('#takePhoto').on('hide.bs.modal', (e) => {
        webcam.stop();
    })


    $('#snap').on('click', (e) => {
        var picture = webcam.snap();
        document.querySelector('#picture').src = picture;
        document.querySelector('#preview').src = picture;
        
        $('#snapfile').val(picture);

        $(webcamElement).addClass('d-none');
        $('#preview').removeClass('d-none');
        $('#snap').addClass('d-none');
        $('#takeagain').removeClass('d-none');
    })

    $('#takeagain').on('click', (e)=> {
        $(webcamElement).removeClass('d-none');
        $('#preview').addClass('d-none');
        $('#snap').removeClass('d-none');
        $('#takeagain').addClass('d-none');
    })
    

    const loadFile = function(event) {
        let output = document.getElementById('picture');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
    };
</script>
