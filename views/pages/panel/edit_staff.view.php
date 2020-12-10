<div class="border-bottom pt-2 pb-2 mb-2">
    <a href="<?=URL?>/panel/staff" class="btn btn-sm btn-outline-dark"><i class="fa fa-arrow-left"></i> Back to staffs</a>

    <h3 class="text-center font-weight-light">Edit <b>Staff</b> - S#<?=$staff['staff_id']?></h3>
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
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="First name" value="<?= $_POST['fname'] ?? $staff['staff_first_name'] ?>">
                    </div>
                </div>
                <div class="pb-3">
                    <label for="mname">Middle Name</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="mname" id="mname" placeholder="Middle name" value="<?= $_POST['mname'] ?? $staff['staff_middle_name'] ?>">
                    </div>
                </div>
                <div class="pb-3">
                    <label for="lname">Last Name</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Last name" value="<?= $_POST['lname'] ?? $staff['staff_last_name'] ?>">
                    </div>
                </div>
                <div class="pb-3">
                    <label for="dob">Date of Birth</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="date" class="form-control" name="dob" id="dob" value="<?= $_POST['dob'] ?? $staff['staff_dob'] ?>">
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
                                <option value="<?=$key?>" <?=(isset($_POST['sex']) && $_POST['sex']===$key)?'selected': ($staff['staff_sex'] === $key ? 'selected' : '')?>><?=$value?></option>
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
                        <input type="text" class="form-control" name="pf" id="pf" placeholder="PF. No" value="<?= $_POST['pf'] ?? $staff['staff_pf'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="nationality">Nationality</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="nationality" id="nationality" placeholder="Nationality" value="<?= $_POST['nationality'] ?? $staff['staff_nationality'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="origin">State of origin</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="origin" id="origin" class="form-control">
                            <?php foreach ($origins as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['origin']) && $_POST['origin']===$key)?'selected': ($staff['staff_origin'] === $key ? 'selected' : '') ?>><?=$value?></option>
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
                        <input type="text" class="form-control" name="lga" id="lga" placeholder="LGA" value="<?= $_POST['lga'] ?? $staff['staff_lga'] ?>">
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
                                <option value="<?=$key?>" <?=(isset($_POST['marrital']) && $_POST['marrital']===$key)?'selected': ($staff['staff_marrital'] === $key ? 'selected' : '') ?>><?=$value?></option>
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
                        <input type="number" class="form-control" name="childern" id="childern" placeholder="No of childern" value="<?= $_POST['childern'] ?? $staff['staff_childern'] ?>">
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
                        <input type="text" class="form-control" name="qualification" id="qualification" placeholder="Highest Qualification" value="<?= $_POST['qualification'] ?? $staff['staff_qualification'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="appointment-rank">Rank of 1st Appointment</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="appointment-rank" id="appointment-rank" placeholder="Rank of 1st Appointment" value="<?= $_POST['appointment-rank'] ?? $staff['staff_appointment_rank'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="appointment-date">Date of 1st Appointment</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="date" class="form-control" name="appointment-date" id="appointment-date" value="<?= $_POST['appointment-date'] ?? $staff['staff_appointment_date'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="next-kin">Next of Kin</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="next-kin" id="next-kin" placeholder="Next of Kin" value="<?= $_POST['next-kin'] ?? $staff['staff_next_kin'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="kin-phone">Next of Phone No</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="kin-phone" id="kin-phone" placeholder="Next of Phone No" value="<?= $_POST['kin-phone'] ?? $staff['staff_next_phone'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="kin-address">Next of Kin Address</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="kin-address" id="kin-address" placeholder="Next of Kin Address" value="<?= $_POST['kin-address'] ?? $staff['staff_next_address'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="kin-email">Next of Kin Email</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="kin-email" id="kin-email" placeholder="Next of Kin Email" value="<?= $_POST['kin-email'] ?? $staff['staff_next_email'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="confirmation">Confirmation Date</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="date" class="form-control" name="confirmation" id="confirmation" value="<?= $_POST['confirmation'] ?? $staff['staff_confirmation'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="last-promotion">Last Promotion Date</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="date" class="form-control" name="last-promotion" id="last-promotion" value="<?= $_POST['last-promotion'] ?? $staff['staff_last_promotion'] ?>">
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="present-rank">Present Rank</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="present-rank" id="present-rank" class="form-control">
                            <?php foreach ($ranks as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['present-rank']) && $_POST['present-rank']===$key)?'selected':($staff['staff_rank'] === $key ? 'selected' : '')?>><?=$value?></option>
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
                        <select name="present-grade" id="present-grade" class="form-control">
                            <?php foreach ($grades as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['present-grade']) && $_POST['present-grade']===$key)?'selected':($staff['staff_grade'] === $key ? 'selected' : '')?>><?=$value?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="pb-3">
                    <label for="cadre">Cadre</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="cadre" id="cadre" class="form-control">
                            <?php foreach ($cadres as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['cadre']) && $_POST['cadre']===$key)?'selected':($staff['staff_cadre'] === $key ? 'selected' : '')?>><?=$value?></option>
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
                        <select name="mda" id="mda" class="form-control">
                            <?php foreach ($mdas as $key => $value): ?>
                                <option value="<?=$value['mda_id']?>" <?=(isset($_POST['mda']) && $_POST['mda']===$value['mda_id'])?'selected':($staff['staff_mda_id'] === $value['mda_id'] ? 'selected' : '')?>><?=$value['mda_name']?></option>
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
                        <input type="date" class="form-control" name="mda-posted" id="mda-posted" value="<?= $_POST['mda-posted'] ?? $staff['staff_mda_posted'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="last-posting">Last Posting</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="last-posting" id="last-posting" placeholder="Last Posting" value="<?= $_POST['last-posting'] ?? $staff['staff_last_posting'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="duration-mda">Duration in MDA</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="duration-mda" id="duration-mda" placeholder="Duraion in MDA" value="<?= $_POST['duration-mda'] ?? $staff['staff_duration'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="home-address">Permanent Home Address</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="home-address" id="home-address" placeholder="Home Address" value="<?= $_POST['home-address'] ?? $staff['staff_home_address'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="contact-address">Contact Address</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="contact-address" id="contact-address" placeholder="Contact Address" value="<?= $_POST['contact-address'] ?? $staff['staff_contact_address'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="phone-no">Phone No</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="phone-no" id="phone-no" placeholder="Phone No" value="<?= $_POST['phone-no'] ?? $staff['staff_phone'] ?>">
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="email-address">Email Address</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="email" class="form-control" name="email-address" id="email-address" placeholder="Email Address" value="<?= $_POST['email-address'] ?? $staff['staff_email'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="bank">Bank</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="bank" id="bank" class="form-control">
                            <option value=""></option>
                            <?php foreach ($banks as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['bank']) && $_POST['bank']===$value)?'selected':($staff['staff_bank'] === $key ? 'selected' : '')?>><?=$value?></option>
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
                        <input type="text" class="form-control" name="account-no" id="account-no" placeholder="account No" value="<?= $_POST['account-no'] ?? $staff['staff_account_no'] ?>">
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="membership">Membership to professional bodies</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="membership" id="membership" placeholder="Membership to professional bodies" value="<?= $_POST['membership'] ?? $staff['staff_membership'] ?>">
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="fund-admin">Pension Fund Admin</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="fund-admin" id="fund-admin" class="form-control">
                            <option value=""></option>
                            <?php foreach ($fund_admins as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['fund-admin']) && $_POST['fund-admin']===$value)?'selected':($staff['staff_fund_admin'] === $key ? 'selected' : '')?>><?=$value?></option>
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
                        <input type="text" class="form-control" name="pension-pin" id="pension-pin" placeholder="Pension Pin No" value="<?= $_POST['pension-pin'] ?? $staff['staff_pension_pin'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="nhf-no">NHF No</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="nhf-no" id="nhf-no" placeholder="NHF No" value="<?= $_POST['nhf-no'] ?? $staff['staff_nhf'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="nin">NIN</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="nin" id="nin" placeholder="NIN" value="<?= $_POST['nin'] ?? $staff['staff_nin'] ?>">
                    </div>
                </div>

                <div class="pb-3">
                    <label for="tin">TIN</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <input type="text" class="form-control" name="tin" id="tin" placeholder="TIN" value="<?= $_POST['tin'] ?? $staff['staff_tin'] ?>">
                    </div>
                </div>
                
                <div class="pb-3">
                    <label for="nhis">NHIS Hospital</label>
                    <div class="input-group border-bottom pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-circle-o-notch"></i></span>
                        </div>
                        <select name="nhis" id="nhis" class="form-control">
                            <option value=""></option>
                            <?php foreach ($nhis_hospitals as $key => $value): ?>
                                <option value="<?=$key?>" <?=(isset($_POST['nhis']) && $_POST['nhis']===$value)?'selected':($staff['staff_nhis_hospital'] === $key ? 'selected' : '')?>><?=$value?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="pb-3">
                    <div>
                        <label for="passport-image">
                            <img src="<?=URL?>/static/images/<?=$staff['staff_passport'] ? 'uploads/'.$staff['staff_passport'] : 'no_picture.jpg'?>" alt="picture" class="passportimg" id="picture">
                        </label>
                    </div>
                    <label for="passport-image" class="form-label">Update Passport</label>
                    <input class="form-control" type="file" id="passport-image" name="passport-image" accept="image/*" onchange="loadFile(event)">
                </div>

            </div>
        </div>
    </div>

    <div class="fixed-bottom">
        <div class="row bg-dark">
            <div class="col-12 p-4 text-center d-flex justify-content-center align-items-center">
                <h5 class="my-0 mr-4 text-white font-weight-light text-uppercase" style="opacity: 0.5;letter-spacing:1px;">Perform Action</h5>
                <button type="submit" class="btn btn-success">Save Record <i class="fa fa-check"></i></button>
            </div>
        </div>
    </div>
</div>

<script>
    const loadFile = function(event) {
        let output = document.getElementById('picture');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
    };
</script>
