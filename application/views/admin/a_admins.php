<script>

    $(document).on('ready', function(){


    });


    function submitAdmin($tableID,$button) {
        var table = document.getElementById($tableID);
        var addData = [];

        addData.push(table.rows[1].cells[0].childNodes[0].value);
        addData.push($('#form_submit_type').val());
        addData.push($('#form_submit_password').val());
        addData.push($('#form_confirm_password').val());

        console.log(addData);

        if(!isValidString(addData[0])){
            toastr.error("Username given is Invalid","Oops");
            return;
        }
        else if(addData[1]==null){
            toastr.error("Please choose an Admin Type","Oops");
            return;
        }
        else if(!isValidPassword(addData[2])){
            toastr.error('Password needs to be 8-25 characters long.','Oops');
            return;
        }
        else if(addData[2]!=addData[3]){
            toastr.error('Passwords do not match','Oops');
            return;
        }

        $.ajax({
            url: '<?php echo base_url('admin/' . ADMIN_SUBMIT_ADMIN) ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                name: addData[0],
                type: addData[1],
                password: addData[2]
            }
        })
            .done(function (result) {
                console.log("success");

                if(result['status']=='success'){
                    toastr.success(result['message'], "Success");
                    $('#'+$button).prop('disabled', true);
                    var delay = 1000;
                    setTimeout(function () {
                        reloadPage();
                    }, delay);
                }
                else{
                    toastr.error(result['message'], "Error");
                }
            })
            .fail(function () {
                console.log("fail");
            })
            .always(function () {
                console.log("complete");
            });
    }


    function reloadPage() {
        <?php
        // TODO Might be better if it didn't have to reload page. Clear table data then query through database?
        echo 'window.location = "'. site_url("admin/".ADMIN_ADMINS) .'";';
        ?>
    }

    function isValidString($s){
        return /[a-z|0-9][a-z|0-9][a-z|0-9]/mi.test($s);
    }

    function isValidLink($s){
        return /[a-z|0-9][a-z|0-9][a-z|0-9]/mi.test($s);
    }

    function isValidDate($d){
        return/[0-9][0-9][\/][0-9][0-9][\/][0-9][0-9][0-9][0-9]/mi.test($d);
    }
    function isValidPassword($s){
        return /^.{8,25}$/mi.test($s);
    }

</script>

<div class="col-md-2 col-md-offset-2" >
    <div class = "form-group col-md-2">
        <b>Admins</b>
    </div>
</div>
<div id="panels" class = "col-md-8 col-md-offset-2">

    <div class="panel-group" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="collapseListGroupHeadingMod">
                <h4 class="panel-title clearfix">
                    <a role="button" class="col-md-6" data-toggle="collapse" href="#collapseListGroupMod" aria-expanded="true" aria-controls="collapseListGroupMod">
                        List of Admins
                    </a>

                    <div id = "adminTable_buttons">

                        <span class = "col-md-3 pull-right">
                            <button type ="button"data-toggle="modal" data-target="#AddNewAdminModal" class="btn btn-default btn-block  col-md-2"> +Add Admin</button>
                                  </span>
                    </div>

                </h4>
            </div>
            <div class="panel-collapse collapse in" role="tabpanel" id="collapseListGroupEvent" aria-labelledby="collapseListGroupHeadingEvent" aria-expanded="false">
                <ul class="list-group">
                    <form>
                        <li class="list-group-item">
                            <table class="table table-hover" id="adminTable">
                                <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Admin Type</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>


                                <?php foreach($admins as $admin):?>
                                    <?php if($admin->Admin_ID!=$_SESSION['adminID']):?>
                                        <tr id="<?=$admin->Admin_ID?>">
                                            <td><?=$admin->Username?></td>
                                            <?php if(intval($admin->Admin_Type)==0):?>
                                            <td title="<?=$admin->Admin_Type?>">Admin</td>
                                            <?php else: ?>
                                            <td title="<?=$admin->Admin_Type?>">Super Admin</td>
                                            <?php endif;?>
                                            <td> <button type ="button" data-toggle="modal" data-target="#ViewQuestionsModal" class="btn btn-default btn-block  col-md-1" onclick="loadViewModal(this.value)" value=<?=$admin->Admin_ID?>><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</button></td>

                                        </tr>
                                    <?php endif;?>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </li>
                        <div class = "panel-footer clearfix" id = "admintable_footer">
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</div>



<div id="AddNewAdminModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Admin</h4>
            </div>
            <form>
                <div class="modal-body clearfix">
                    <table class="table table-hover" id="add_table" name="">  <!-- TODO: somehow insert table id in name for add ? -->
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Admin Type</th>
                            <th>Password</th>
                            <th>Confirm Password</th>

                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td><input id="form_submit_username" type="text" class="form-control" placeholder="Enter Username"></td>
                            <td>
                                <select class="form-control" id="form_submit_type" name="form-submit-type"">
                                <option value="0" selected>Admin</option>
                                <option value="1">Super Admin</option>
                                </select>
                            </td>
                            <td>
                                <input type="password" class="form-control" id="form_submit_password" placeholder="Enter Password">
                            </td>
                            <td>
                                <input type="password" class="form-control" id="form_confirm_password" placeholder="Confirm Password">
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="add-event-btn" onclick="submitAdmin('add_table',this.id)">Confirm</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div id="ViewQuestionsModal" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
                <h4 class="modal-title" id="modal_view_title">Question Set</h4>
            </div>
            <form>
                <div class="modal-body clearfix">
                    <table class="table table-hover" id="question_table" name="">  <!-- TODO: somehow insert table id in name for add ? -->
                        <thead id="view_modal_header">
                        <tr>
                            <th>Q#</th>
                            <th>Question</th>

                        </tr>
                        </thead>
                        <tbody id="view_modal_body">

                        </tbody>
                    </table>

                </div>
                <div class="modal-footer" id="question_table_button">
                    <span class = "col-md-3 pull-right">
                               <button class="btn btn-default btn-block col-md-2 " type="button" onclick="changeViewToEdit('question_table','question_table_button')">Edit Question Set</button>
                         </span>
                </div>
            </form>
        </div>

    </div>
</div>