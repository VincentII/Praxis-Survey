<form class="col-md-4 col-md-offset-4" method="post" action="<?=base_url('admin/' . ADMIN_SIGN_IN)?>">

    <span id="error-message"><?=$errorMessage?></span>

    <div class="form-group">
        <label for="adminName">Username:</label>
        <input  class="form-control" name="adminName" id="adminName" placeholder="Enter Username Here" required>
    </div>

    <BR><BR>

    <div class="form-group">
        <label for="adminPassword">Password:</label>
        <input type="password" class="form-control" name="adminPassword" id="adminPassword" placeholder="Enter Your Password Here" required>
    </div>

    <BR><BR>


    <button type="submit" class="btn btn-default" id="submit-sign-in">Sign In</button>
</form>