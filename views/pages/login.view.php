<div class="row">
    <div class="col-12">
        <div class="border-bottom pt-2 pb-2 mb-2">
            <h2 class="text-center font-weight-light">
                Login to <b>Panel</b>
            </h2>
        </div>
    </div>

    <div class="col-12">

        <div class="row justify-content-center my-4">
            
            <form class="col col-lg-6" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
                
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

                <div class="form-group">
                    <label for="usernameField">Username</label>
                    <input type="text" name="username" class="form-control" id="usernameField" required>
                </div>
                <div class="form-group">
                    <label for="passwordField">Password</label>
                    <input type="password" name="password" class="form-control" id="passwordField" aria-describedby="passwordHelp">
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        
        </div>


    </div>
</div>

