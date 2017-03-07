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

    function getTableDataWithID(tableID) {
        var table = document.getElementById(tableID);

        var jObject = [];
        for (var i = 1; i < table.rows.length; i++)
        {

            var row = i - 1;
            // create array within the array - 2nd dimension
            //jObject[row] = [];

            var valid = true;
            var columns = [];
            // columns within the row
            //for (var j = 0; j < table.rows[i].cells.length; j++)


            for (var j = 0; j < 3; j++)
            {
                //jObject[row][j] = table.rows[i].cells[j].childNodes[0].value;
                //console.log(table.rows[i].cells[j].childNodes[0].data);
                columns[j] = table.rows[i].cells[j].childNodes[0].data;

            }

            if(table.rows[i].cells[3].childNodes[0].data=="Yes")
                columns[3] = true;
            else
                columns[3]=false;

            //console.log(columns);
            /*columns[1] = table.rows[i].cells[0].childNodes[0].value;
             columns[2] = table.rows[i].cells[1].childNodes[0].value;*/

            columns['id'] = table.rows[i].id;

            if (valid) {
                jObject[row] = columns;
            }
        }
        return jObject;
    }

    function getChangesTableDataWithID(tableID) {
        var table = document.getElementById(tableID);

        var jObject = [];
        for (var i = 1; i < table.rows.length; i++)
        {

            var row = i - 1;
            // create array within the array - 2nd dimension
            //jObject[row] = [];

            var valid = true;
            var columns = [];
            // columns within the row
            //for (var j = 0; j < table.rows[i].cells.length; j++)


            for (var j = 0; j < 3; j++)
            {
                //jObject[row][j] = table.rows[i].cells[j].childNodes[0].value;
                //console.log(table.rows[i].cells[j].childNodes[0].data);
                columns[j] = table.rows[i].cells[j].childNodes[0].value;

            }

                columns[3]=table.rows[i].cells[3].childNodes[0].checked;

            columns[4]=table.rows[i].cells[4].childNodes[0].checked;

            //console.log(columns);
            /*columns[1] = table.rows[i].cells[0].childNodes[0].value;
             columns[2] = table.rows[i].cells[1].childNodes[0].value;*/

            if (valid) {
                jObject[row] = columns;
            }
        }
        return jObject;
    }

    var initialTableData;

    function changeViewToEdit(table, buttons, modal){
        //console.log(table);
        var tableA = document.getElementById(table);
        var rows = tableA.rows;
        var tID = table;
        var bID = buttons;

        console.log("TABLE ID = "+table);

            initialTableData = getTableDataWithID(tID);
        //console.log(initialTableData);

        var funct = "submitChanges";

        var buttonsStr =
            "<span class = \"col-md-3\">"+
            "<button class=\"btn  btn-danger btn-block col-md-2\" type=\"button\" onclick=\"changeViewToView('"+tID+"','"+bID+"', '"+modal+"')\">Cancel</button>"+
            "</span>"+
            "<span class = \"col-md-3\">"+
            "<button class=\"btn  btn-success btn-block col-md-20\" type=\"button\" onclick=\""+funct+"('"+tID+"')\" ><span class=\"glyphicon glyphicon-floppy-disk\" aria-hidden=\"true\"></span> Save Changes </button>"+
            "</span>";



        document.getElementById(buttons).innerHTML = buttonsStr;

        rows[0].insertCell(4).outerHTML = "<th>Archive</th>";

        for(var i = 1; i < rows.length; i++) {
            var cells = rows[i].cells;

            rows[i].insertCell(4);

            cells[0].id = "C0R" + i;
            cells[1].id = "C1R" + i;
            cells[2].id = "C2R" + i;
            cells[3].id = "C3R" + i;
            cells[4].id = "C4R" + i;

            var curNameID = $(cells[0]).attr("id");
            var curDateID = $(cells[1]).attr("id");
            var curLocationID = $(cells[2]).attr("id");
            var curOpenID = $(cells[3]).attr("id");
            var curArchivedID = $(cells[4]).attr("id");


            var curName = cells[0].innerHTML;
            var curDate = cells[1].innerHTML;
            var curLocation = cells[2].innerHTML;
            var curOpen = cells[3].innerHTML;
            var curArchived = cells[4].innerHTML;

            //console.log(cells);


            //console.log(curDeptID);
            cells[0].innerHTML = "<input type=\"text\" class=\"form-control\" id=\"" + curNameID + "\"value=\"" + curName + "\">";
            cells[1].innerHTML = '<input type="text" id="' + curDateID + '" class="form-control datepicker" data-provide="datepicker" placeholder="Enter date" value='+curDate+' ?></td>';
            cells[2].innerHTML = "<input type=\"text\" class=\"form-control\" id=\"" + curLocationID + "\" value=\"" + curLocation + "\">";

            var check="";
            if(curOpen=="Yes"){
                check = '<input type="checkbox" class="form-control" value="" checked>'
            }else
                check = '<input type="checkbox" class="form-control" value="">'

            cells[3].innerHTML = check;
            cells[4].innerHTML = '<input type="checkbox" class="form-control" value="">';
        }


    }

    function changeViewToView(table, button, modal){
        reloadPage(); //TODO
    }


    function getChangedData(newTableData) {
        var changedData = [];
        var changedDataIndex = 0;

        console.log(newTableData);

        for (var i = 0; i < initialTableData.length; i++) {


            if (initialTableData[i][0] != newTableData[i][0] ||
                initialTableData[i][1] != newTableData[i][1] ||
                initialTableData[i][2] != newTableData[i][2] ||
                initialTableData[i][3] != newTableData[i][3] ||
                    newTableData[i][4] == true
            ) {

                changedData[changedDataIndex] = newTableData[i];
                changedData[changedDataIndex][5] = initialTableData[i]['id'];
                changedDataIndex++;
            }
        }

        return changedData;
    }

    function submitChanges(tableID) {
        var changedData = getChangedData(getChangesTableDataWithID(tableID));


        for(var i = 0; i<changedData.length; i++) {
            if (!isValidString(changedData[i][0])){
                toastr.error("Name given is Invalid","Error");
                return;
            }
           // if (!isValidDate(changedData[i][2])){
             //   toastr.error("Date given is Invalid","Error");
               // return;
            //}
            if (!isValidString(changedData[i][3])){
                toastr.error("Location given is Invalid","Error");
                return;
            }
        }

//        console.log(changedData);
        if(changedData.length>0) {
            $.ajax({
                url: '<?=base_url('admin/' . ADMIN_UPDATE_EVENTS)?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    changedData: changedData
                }
            })
                .done(function (result) {
                    console.log("done");
                    console.log(result);

                    if (result['status'] == "success") {
                        toastr.success("Changes were made successfully.", "Success");
                        var delay = 1000;
                        setTimeout(reloadPage, delay);


                    }
                })
                .fail(function (result) {
                    console.log("fail");
                })
                .always(function () {
                    console.log("complete");
                });
        }
        else
            toastr.error("No changes were made.", "Oops!");

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
                               <button class="btn btn-default btn-block col-md-2 col-md-offset-0" type="button" onclick="changeViewToEdit('eventTable','eventTable_buttons', 'AddNewEventModal')">Edit Events</button>
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
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php foreach($events as $event):?>
                                        <tr id="<?=$event->Event_ID?>">
                                            <td><?=$event->Event_Name?></td>
                                            <td><?php
                                                $time = strtotime($event->event_date);
                                                echo date("m/d/Y", $time);
                                                ?></td>
                                            <td><?=$event->Event_Location?></td>
                                            <?php if($event->is_closed==0): ?>
                                            <td>Yes</td>
                                            <?php else:?>
                                            <td>No</td>
                                            <?php endif;?>
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
                            <td><input type="checkbox" class="form-control" value=""></td>

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