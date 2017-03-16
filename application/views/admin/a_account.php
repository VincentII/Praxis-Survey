<script>

    function isValidString($s){
        return /[a-z|0-9][a-z|0-9][a-z|0-9]/mi.test($s);
    }
    function isValidPassword($s){
        return /^.{8,25}$/mi.test($s);
    }


    function changePassword() {
        if(!isValidString($('#currPassword').val())){
            toastr.error('Current Password entered is not correct','OOPS');
        }
        else if(!isValidPassword($('#newPassword').val())){
            toastr.error('Password needs to be 8-25 characters long.','OOPS');
        }
        else if(!isValidPassword($('#rePassword').val())){
            toastr.error('New and Re-entered passwords do not match','OOPS');
        }
        else if($('#newPassword').val()!=$('#rePassword').val()){
            toastr.error('New and Re-entered passwords do not match','OOPS');
        }
        else{
            $.ajax({
                url: '<?=base_url('admin/' . ADMIN_UPDATE_PASSWORD)?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    curr:$('#currPassword').val(),
                    new:$('#newPassword').val(),
                    adminID:<?=$_SESSION['adminID']?>
                }
            })
                .done(function (result) {
                    console.log("done");
                    if (result['status'] == "success") {
                        toastr.success(result['message'],'Success');
                        setTimeout(reloadPage, 1000);


                    }
                    else{
                        toastr.error(result['message'],'Oops');
                    }
                })
                .fail(function (result) {
                    console.log("fail");
                })
                .always(function () {
                    console.log("complete");
                });
        }
    }

    function reloadPage() {
        <?php
        // TODO Might be better if it didn't have to reload page. Clear table data then query through database?
        echo 'window.location = "'. site_url("admin/".ADMIN_ACCOUNT) .'";';
        ?>
    }
</script>




<div class="col-md-10 col-md-offset-2" >
    <div class = "form-group">
        <ol class="breadcrumb">
            <li>Admin</li>
            <li class="active">Your Account</li>
        </ol>
    </div>
</div>

<div class="col-lg-10 col-md-offset-2" >
    <div class = "panel panel-default col-lg-10">
        <div class="panel-group">
            <br>
            <b>Username: </b>
            <?=$_SESSION['adminUsername']?>
            <br>
            <b>Account Type: </b>
            <?php
            if($_SESSION['adminType']==0)
                echo 'Admin';
            else if($_SESSION['adminType']==1)
                echo 'Super Admin';

            ?>
            <br>
            <br>
            <div>
                <button type ="button" data-toggle="modal" data-target="#ChangeModal" class="btn btn-danger">Change Password</button>
            </div>
        </div>
    </div>
</div>

<div id="ChangeModal" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
                <h4 class="modal-title" id="modal_view_title">Change Password</h4>
            </div>
            <form>
                <div class="modal-body clearfix">
                    <div class="form-group">
                        <label for="currPassword">Old Password:</label>
                        <input type="password" class="form-control" name="currPassword" id="currPassword" placeholder="Enter Your Old Password Here" required>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter Your New Password Here" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="adminPassword">Re-Enter Password:</label>
                        <input type="password" class="form-control" name="rePassword" id="rePassword" placeholder="Enter Your New Password Again" required>
                    </div>

                </div>
                                <div class="modal-footer" id="modal_button">
                                    <span class = "col-md-3 pull-right">
                                               <button class="btn btn-success btn-block col-md-2 " type="button" onclick="changePassword()"><span class=\"glyphicon glyphicon-floppy-disk\" aria-hidden=\"true\"></span> Save Password Changes</button>
                                         </span>
                                </div>
            </form>
        </div>

    </div>
</div>