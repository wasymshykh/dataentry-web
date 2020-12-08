<div class="row m-4">
    <div class="col-xl-3 col-lg-4 border-bottom border-right">
        <h4 class="display-5">Hello, <?=$logged['user_username']?>!</h4>
        <h5>Your Role - <div class="badge badge-success"><?=($logged['user_role'] === 'A' ? 'Admin' : ($logged['user_role'] === 'M' ? 'Manager' : ($logged['user_role'] === 'D' ? 'Data Entry' : 'undefined'))) ?></div></h5>
    </div>
    <div class="col-xl-9 col-lg-8 border-bottom py-0 px-4">

        <h6 class="text-uppercase font-weight-bold" style="letter-spacing: 1px;"><i class="mr-2 fa fa-line-chart"></i> System Statistics</h6>

        <div class="row">
            <div class="col-lg-4 p-4">
                <div class="border text-center pt-4">
                    <h6 class="bg-dark d-table mx-auto mb-2 py-2 px-3 text-light" style="font-size: 1.8em;"><i class="fa fa-users"></i></h6>
                    <h4 class="mb-0"><?=count($users)?></h4>
                    <p class="text-muted font-weight-light">System Users</p>
                    
                    <a href="<?=URL?>/panel/manage_users" class="btn btn-dark btn-sm mb-3">Manage <i class="fa fa-arrow-right ml-2"></i></a>
                </div>
            </div>
            <div class="col-lg-4 p-4">
                <div class="border text-center pt-4">
                    <h6 class="bg-dark d-table mx-auto mb-2 py-2 px-3 text-light" style="font-size: 1.8em;"><i class="fa fa-black-tie"></i></h6>
                    <h4 class="mb-0"><?=count($staff)?></h4>
                    <p class="text-muted font-weight-light">Staff Registered</p>
                    
                    <a href="<?=URL?>/panel/staff" class="btn btn-dark btn-sm mb-3">Manage <i class="fa fa-arrow-right ml-2"></i></a>
                </div>
            </div>
            <div class="col-lg-4 p-4">
                <div class="border text-center pt-4">
                    <h6 class="bg-dark d-table mx-auto mb-2 py-2 px-3 text-light" style="font-size: 1.8em;"><i class="fa fa-black-tie"></i></h6>
                    <h4 class="mb-0"><?=count($retiring)?></h4>
                    <p class="text-muted font-weight-light">Retiring Users</p>
                    
                    <a href="<?=URL?>/panel/retirement" class="btn btn-dark btn-sm mb-3">Update <i class="fa fa-arrow-right ml-2"></i></a>
                </div>
            </div>

        </div>

    </div>
</div>
