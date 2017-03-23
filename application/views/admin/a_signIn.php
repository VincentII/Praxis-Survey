<form class="col-md-4 col-md-offset-4" method="post" action="<?=base_url('admin/' . ADMIN_SIGN_IN)?>" style="padding-top: 10%">

    <span id="error-message"><?=$errorMessage?></span>


    <center><img src="<?=base_url()?>/assets/img/Praxis%20Logo.svg" style="width: 60%; height: auto;"></center>

    <div class="form-group">
        <label for="adminName">Username:</label>
        <input type="text" class="form-control" name="adminName" id="adminName" placeholder="Enter Username Here" required>
    </div>


    <div class="form-group">
        <label for="adminPassword">Password:</label>
        <input type="password" class="form-control" name="adminPassword" id="adminPassword" placeholder="Enter Your Password Here" required>
    </div>



    <button type="submit" class="btn btn-default" id="submit-sign-in">Sign In</button>
</form>