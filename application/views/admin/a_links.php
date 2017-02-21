<script>

    $(document).on('ready', function(){

    });


    function submitURL($tableID,$button) {
        var table = document.getElementById($tableID);
        var cells = 3;

        var addData = [];

        addData.push(table.rows[1].cells[0].childNodes[0].value);
        addData.push($('#form_submit_event').val());
        addData.push($('#form_submit_set').val());

        console.log(addData);

        if(!isValidString(addData[0])){
            toastr.error("URL given is Invalid","Error");
            return;
        }
        if(addData[1]=="0"){
            toastr.error("Please choose an event","Error");
            return;
        }
        if(addData[2]=="0"){
            toastr.error("Please choose a question set","Error");
            return;
        }

        $.ajax({
            url: '<?php echo base_url('admin/' . ADMIN_SUBMIT_URL) ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                url: addData[0],
                eventID: addData[1],
                setID: addData[2]
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
        echo 'window.location = "'. site_url("admin/".ADMIN_EVENTS) .'";';
        ?>
    }
    
    function isValidString($s){
       return /[a-z|0-9][a-z|0-9][a-z|0-9]/mi.test($s);
    }

    function isValidDate($d){
        return/[0-9][0-9][\/][0-9][0-9][\/][0-9][0-9][0-9][0-9]/mi.test($d);
    }
    
    


</script>

<div class="col-md-2 col-md-offset-2" >
        <div class = "form-group col-md-2">
        <b>Links</b>
        </div>
</div>
    <div id="panels" class = "col-md-8 col-md-offset-2">

        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="collapseListGroupHeadingMod">
                    <h4 class="panel-title clearfix">
                        <a role="button" class="col-md-6" data-toggle="collapse" href="#collapseListGroupMod" aria-expanded="true" aria-controls="collapseListGroupMod">
                            List of Links
                        </a>

                        <div id = "eventTable_buttons">

                        <span class = "col-md-3">
                            <button type ="button"data-toggle="modal" data-target="#AddNewEventModal" class="btn btn-default btn-block  col-md-2"> +Add Link</button>

                                  </span>
                            <span class = "col-md-3">
                               <button class="btn btn-default btn-block col-md-2 col-md-offset-0" type="button" onclick="changeViewToEdit('modtable','modtable_buttons', 'AddNewModeratorModal')">Edit Links</button>
                         </span>
                        </div>

                    </h4>
                </div>
                <div class="panel-collapse collapse in" role="tabpanel" id="collapseListGroupEvent" aria-labelledby="collapseListGroupHeadingEvent" aria-expanded="false">
                    <ul class="list-group">
                        <form>
                            <li class="list-group-item">
                                <table class="table table-hover" id="eventTable">
                                    <thead>
                                    <tr>
                                        <th>URL</th>
                                        <th>Event</th>
                                        <th>Question Set</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php foreach($links as $link):?>
                                        <tr id="<?=$link->url_id?>">
                                            <td><?=$link->url?></td>
                                            <td><?=$link->event_name?></td>
                                            <td><?=$link->question_set_description?></td>
                                            <td></td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </li>
                            <div class = "panel-footer clearfix" id = "eventtable_footer">
                            </div>
                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>



<div id="AddNewEventModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Link</h4>
            </div>
            <form>
                <div class="modal-body clearfix">
                    <table class="table table-hover" id="add_table" name="">  <!-- TODO: somehow insert table id in name for add ? -->
                        <thead>
                        <tr>
                            <th>URL</th>
                            <th>Event Name</th>
                            <th>Question Set</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tbody>

                        <tr>
                            <td><input type="text" class="form-control" placeholder="Enter URL"></td>
                            <td>
                                <select class="form-control" id="form_submit_event" name="form-submit-event"">
                                <option value="0" selected disabled>Choose an Event...</option>
                                <?php foreach($events as $row):?>
                                    <option value="<?=$row->Event_ID?>"><?=$row->Event_Name?></option>
                                <?php endforeach;?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" id="form_submit_set" name="form-submit-set"">
                                <option value="0" selected disabled>Choose a Question Set...</option>
                                <?php foreach($questionSets as $row):?>
                                    <option value="<?=$row->Set_ID?>"><?=$row->Question_Set_Description?></option>
                                <?php endforeach;?>
                                </select>
                            </td>


                        </tr>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="add-event-btn" onclick="submitURL('add_table',this.id)">Confirm</button>
                </div>
            </form>
        </div>

    </div>
</div>