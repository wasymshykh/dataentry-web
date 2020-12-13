
<div class="border-bottom pt-2 pb-2 mb-2">
    <a href="<?=URL?>/panel/staff" class="btn btn-sm btn-outline-dark"><i class="fa fa-arrow-left"></i> Back to staffs</a>
    <h3 class="text-center font-weight-light">Viewing <b>Staff</b></h3>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="border p-2">
                    <?php if ($staff['staff_passport']): ?>
                        <div>
                            <img src="<?=URL?>/static/images/uploads/<?=$staff['staff_passport']?>" alt="<?=$staff['staff_first_name']?>" class="img-thumbnail" style="max-width:120px;max-height:120px">
                        </div>
                    <?php endif; ?>
                    <div>
                        <span class="badge badge-primary">Staff <strong>#<?=$staff['staff_id']?></strong></span> 
                        <?php if($staff['staff_status'] === 'R'): ?>
                        <span class="badge badge-warning">Retired Staff</strong></span>
                        <?php endif; ?>
                    </div>
                    <h3><?=$staff['staff_first_name']?> <?=$staff['staff_middle_name']?> <?=$staff['staff_last_name']?></h3>
                    <dd class="pl-4 pt-2">
                        <dl><strong class="mr-2"><i class="fa fa-birthday-cake mr-2"></i> <abbr title="Date of Birth">D.O.B.</abbr></strong> <?=normal_date($staff['staff_dob'], 'M d, Y')?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-genderless mr-2"></i> Sex</strong> <?=$staff['staff_sex'] === 'M' ? 'Male' : ($staff['staff_sex'] === 'F' ? 'Female' : 'Other') ?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-minus-square-o mr-2"></i> PF. No</strong> <?=$staff['staff_pf']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-flag-o mr-2"></i> Nationality</strong> <?=$staff['staff_nationality']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-map-marker mr-2"></i> State of Origin</strong> <?=$staff['staff_origin']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-phone mr-2"></i> Phone</strong> <?=$staff['staff_phone']?></dl>
                    </dd>
                    <?php if ($staff['staff_status'] !== 'R'): ?>
                        <a href="<?=URL?>/panel/edit_staff?s=<?=$staff['staff_id']?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil mr-2"></i> Edit Staff</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-6 mb-4">
                <div class="border text-center pt-2">
                    <h6 class="bg-dark d-table mx-auto mb-2 py-2 px-2 text-light" style="font-size: 1.4em;"><i class="fa fa-building"></i></h6>
                    <h5 class="mb-0"><?=$staff['mda_name']?></h5>
                    <p class="text-muted font-weight-light"><small>MDA</small></p>
                </div>
            </div>
            <div class="col-6 mb-4">
                <div class="border text-center pt-2">
                    <h6 class="bg-dark d-table mx-auto mb-2 py-2 px-2 text-light" style="font-size: 1.4em;"><i class="fa fa-calendar"></i></h6>
                    <h5 class="mb-0"><?=$staff['staff_mda_posted'] ? normal_date($staff['staff_mda_posted'], 'M d, Y') : '' ?></h5>
                    <p class="text-muted font-weight-light"><small>Date Posted</small></p>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="card p-2">
                    <div class="card-header">More Personal Information</div>
                    <dd class="pl-4 pt-2">
                        <dl><strong class="mr-2"><i class="fa fa-minus-square-o mr-2"></i> LGA</strong> <?=$staff['staff_lga']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-mercury mr-2"></i> Marrital Status</strong> <?=$staff['staff_marrital']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-child mr-2"></i> No of childern</strong> <?=$staff['staff_childern']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-location-arrow mr-2"></i> Permanent Home Address</strong> <?=$staff['staff_home_address']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-location-arrow mr-2"></i> Contact Address</strong> <?=$staff['staff_contact_address']?></dl>
                    </dd>
                </div>
            </div>
            
        </div>
    </div>

    <div class="col-lg-8">
        <div class="row">
            <div class="col-4 mb-4">
                <div class="border text-center pt-2">
                    <h6 class="bg-dark d-table mx-auto mb-2 py-2 px-2 text-light" style="font-size: 1.4em;"><i class="fa fa-get-pocket"></i></h6>
                    <h5 class="mb-0"><?=$staff['staff_rank']?></h5>
                    <p class="text-muted font-weight-light"><small><?=($staff['staff_status'] === 'R') ? '' : 'Present'?> Rank</small></p>
                </div>
            </div>
            <div class="col-4 mb-4">
                <div class="border text-center pt-2">
                    <h6 class="bg-dark d-table mx-auto mb-2 py-2 px-2 text-light" style="font-size: 1.4em;"><i class="fa fa-level-up"></i></h6>
                    <h5 class="mb-0"><?=$staff['staff_grade']?></h5>
                    <p class="text-muted font-weight-light"><small><?=($staff['staff_status'] === 'R') ? '' : 'Present'?> Grade Level</small></p>
                </div>
            </div>
            <?php if ($staff['staff_status'] !== 'R'): ?>
            <div class="col-4 mb-4">
                <div class="border text-center pt-2">
                    <h6 class="bg-dark d-table mx-auto mb-2 py-2 px-2 text-light" style="font-size: 1.4em;"><i class="fa fa-calendar"></i></h6>
                    <h5 class="mb-0"><?php if($staff['staff_mda_posted']): $age = $s->getAge($staff['staff_mda_posted'], current_date()); echo $age['years']. ' Years ' . $age['months'] . ' Months '. $age['days'] . ' Days'; else: echo ''; endif;?></h5>
                    <p class="text-muted font-weight-light"><small>Duration in MDA</small></p>
                </div>
            </div>
            <?php else: ?>
            <div class="col-4 mb-4">
                <div class="border text-center pt-2">
                    <h6 class="bg-dark d-table mx-auto mb-2 py-2 px-2 text-light" style="font-size: 1.4em;"><i class="fa fa-calendar"></i></h6>
                    <h5 class="mb-0"><?php if($staff['staff_retired_on']): $age = $s->getAge($staff['staff_retired_on'], current_date()); echo $age['years']. ' Years ' . $age['months'] . ' Months '. $age['days'] . ' Days'; else: echo ''; endif;?></h5>
                    <p class="text-muted mb-0 font-weight-light"><small>Retired</small></p>
                    <p>Dated: <strong><?=($staff['staff_retired_on']) ? normal_date($staff['staff_retired_on']) : ''?></strong></p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="row mt-4 border-top pt-4">
        
            <div class="col-lg-6 mb-4">
                <div class="card p-2">
                    <div class="card-header"><i class="fas fa-graduation-cap mr-2"></i> Education</div>
                    <dd class="pl-4 pt-2">
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Rank of 1st Appointment</strong> <?=$staff['staff_appointment_rank']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Date of 1st Appointment</strong> <?=$staff['staff_appointment_date'] ? normal_date($staff['staff_appointment_date'], 'M d, Y') : ''?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Next of Kin</strong> <?=$staff['staff_next_kin']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Next of Kin Phone No</strong> <?=$staff['staff_next_phone']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Next of Kin Address</strong> <?=$staff['staff_next_address']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Next of Kin Email</strong> <?=$staff['staff_next_email']?></dl>
                    </dd>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card p-2">
                    <div class="card-header"><i class="fas fa-briefcase mr-2"></i> Employment</div>
                    <dd class="pl-4 pt-2">
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Confirmation Date</strong> <?=$staff['staff_confirmation'] ? normal_date($staff['staff_confirmation'], 'M d, Y') : ''?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Cadre</strong> <?=$staff['staff_cadre']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Last Promotion Date</strong> </dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Last Posting</strong> <?=$staff['staff_last_posting']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Bank</strong> <?=$staff['staff_bank']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Account No</strong> <?=$staff['staff_account_no']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Membership to professional bodies</strong> <?=$staff['staff_membership']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Pension Fund Admin</strong> <?=$staff['staff_fund_admin']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> Pension Pin No</strong> <?=$staff['staff_pension_pin']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> NHF No</strong> <?=$staff['staff_nhf']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> NIN</strong> <?=$staff['staff_nin']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> TIN</strong> <?=$staff['staff_tin']?></dl>
                        <dl><strong class="mr-2"><i class="fa fa-circle-o-notch mr-2"></i> NHIS Hospital</strong> <?=$staff['staff_nhis_hospital']?></dl>
                    </dd>
                </div>
            </div>

            

        </div>

    </div>
</div>

