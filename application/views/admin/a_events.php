<script>

    $(document).on('ready', function(){
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '0d'
        });
    });


    function submitEvent($tableID,$button) {
        var table = document.getElementById($tableID);
        var cells = 4;

        var addData = [];
        for (i = 0; i < cells - 1; i++) {
            addData.push(table.rows[1].cells[i].childNodes[0].value)
        }
        addData.push(table.rows[1].cells[cells - 1].childNodes[0].checked)
        console.log(addData);


        if(!isValidString(addData[0])){
            toastr.error("Name given is Invalid","Error");
            return;
        }
        if(!isValidDate(addData[1])){
            toastr.error("Date given is Invalid","Error");
            return;
        }
        if(!isValidString(addData[2])){
            toastr.error("Location given is Invalid","Error");
            return;
        }



        $.ajax({
            url: '<?php echo base_url('admin/' . ADMIN_SUBMIT_EVENT) ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                name: addData[0],
                date: addData[1],
                location: addData[2],
                isClosed: !addData[3]

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
        <b>Events</b>
        </div>
</div>
    <div id="panels" class = "col-md-8 col-md-offset-2">

        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="collapseListGroupHeadingMod">
                    <h4 class="panel-title clearfix">
                        <a role="button" class="col-md-6" data-toggle="collapse" href="#collapseListGroupMod" aria-expanded="true" aria-controls="collapseListGroupMod">
                            List of Events
                        </a>

                        <div id = "eventTable_buttons">

                        <span class = "col-md-3">
                            <button type ="button"data-toggle="modal" data-target="#AddNewEventModal" class="btn btn-default btn-block  col-md-2"> +Add Event</button>

                                  </span>
                            <span class = "col-md-3">
                               <button class="btn btn-default btn-block col-md-2 col-md-offset-0" type="button" onclick="changeViewToEdit('modtable','modtable_buttons', 'AddNewModeratorModal')">Edit Events</button>
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
                                        <th>Event Name</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Open</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php foreach($events as $event):?>
                                        <tr id="<?=$event->Event_ID?>">
                                            <td><?=$event->Event_Name?></td>
                                            <td><?php
                                                $time = strtotime($event->event_date);
                                                echo date("M d, Y", $time);
                                                ?></td>
                                            <td><?=$event->Event_Location?></td>
                                            <?php if($event->is_closed==0): ?>
                                            <td>Yes</td>
                                            <?php else:?>
                                            <td>No</td>
                                            <?php endif;?>
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
                <h4 class="modal-title">Add Event</h4>
            </div>
            <form>
                <div class="modal-body clearfix">
                    <table class="table table-hover" id="add_table" name="">  <!-- TODO: somehow insert table id in name for add ? -->
                        <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Open</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tbody>

                        <tr>
                            <td><input type="text" class="form-control" placeholder="Enter event name"></td>
                            <td><input type="text" class="form-control datepicker" data-provide="datepicker" placeholder="Enter date" value=<?php echo date('m/d/Y'); ?>></td>
                            <td><input type="text" class="form-control" placeholder="Enter Location"></td>
                            <td><input type="checkbox" value=""></td>

                        </tr>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="add-event-btn" onclick="submitEvent('add_table',this.id)">Confirm</button>
                </div>
            </form>
        </div>

    </div>
</div>