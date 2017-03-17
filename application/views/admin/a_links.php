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
        if(addData[1]==null){
            toastr.error("Please choose an event","Error");
            return;
        }
        if(addData[2]==null){
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


            columns[0] = table.rows[i].cells[0].childNodes[0].data;
            columns[1] = table.rows[i].cells[1].title;
            columns[2] = table.rows[i].cells[2].title;


            console.log(columns);
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
            "<button class=\"btn  btn-success btn-block col-md-20\" type=\"button\" onclick=\""+funct+"('"+tID+"')\" ><span class=\"glyphicon glyphicon-floppy-disk\" aria-hidden=\"true\"></span> Save Changes</button>"+
            "</span>";



        document.getElementById(buttons).innerHTML = buttonsStr;

        rows[0].insertCell(3).outerHTML = "<th>Delete</th>";

        for(var i = 1; i < rows.length; i++) {
            var cells = rows[i].cells;

            rows[i].insertCell(4);

            cells[0].id = "C0R" + i;
            cells[1].id = "C1R" + i;
            cells[2].id = "C2R" + i;
            cells[3].id = "C4R" + i;

            var curLinkID = $(cells[0]).attr("id");
            var curEventID = $(cells[1]).attr("id");
            var curSetID = $(cells[2]).attr("id");
            var curDeleteID = $(cells[3]).attr("id");


            var curLink = cells[0].innerHTML;
            var curEvent = cells[1].innerHTML;
            var curSet = cells[2].innerHTML;
            var curDelete = cells[3].innerHTML;

            //console.log(cells);


            //console.log(curDeptID);
            cells[0].innerHTML = "<input type=\"text\" class=\"form-control\" id=\"" + curLinkID + "\"value=\"" + curLink + "\">";


            var drop = "<select type='text' class='form-control' id='"+curEventID+"'  >";
            var events = <?php echo json_encode($events); ?>;
            for(var j = 0; j<events.length; j++)
            {

                if(events[j].Event_Name==curEvent) {
                    drop+="<option value='"+events[j].Event_ID+"' selected >"+events[j].Event_Name+"</option>"
                }else
                    drop+="<option value='"+events[j].Event_ID+"'  >"+events[j].Event_Name+"</option>"

            }
            drop+="</select>";
            cells[1].innerHTML = drop;


            drop = "<select type='text' class='form-control' id='"+curSetID+"'  >";
            var sets = <?php echo json_encode($questionSets); ?>;
            for(var j = 0; j<sets.length; j++)
            {

                if(sets[j].Question_Set_Description==curSet) {
                    drop+="<option value='"+sets[j].Set_ID+"' selected >"+sets[j].Question_Set_Description+"</option>"
                }else
                    drop+="<option value='"+sets[j].Set_ID+"'  >"+sets[j].Question_Set_Description+"</option>"

            }

            drop+="</select>";

            cells[2].innerHTML = drop;


            cells[3].innerHTML = '<input type="checkbox" class="form-control" value="">';
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
                newTableData[i][3] == true
            ) {

                changedData[changedDataIndex] = newTableData[i];
                changedData[changedDataIndex][4] = initialTableData[i]['id'];
                changedDataIndex++;
            }
        }

        return changedData;
    }

    function submitChanges(tableID) {

        var newTable = getChangesTableDataWithID(tableID);

        for(var i = 0; i<newTable.length; i++) {
            for(var j=i+1;j<newTable.length;j++){
                console.log(newTable[i][0] +" "+ newTable[j][0]);
                if(newTable[i][0]==newTable[j][0]){
                    toastr.error("You can't have same named Links","Oops");
                    return;
                }
            }
        }

        var changedData = getChangedData(newTable);

        var deleteCount = 0;

        for(var i = 0; i<changedData.length; i++) {
            if (!isValidString(changedData[i][0])){
                toastr.error("Link given is Invalid","Error");
                return;
            }
            if(changedData[i][3])
                deleteCount++;
        }

        var func = function(changedData){
            if(changedData.length>0) {
                $.ajax({
                    url: '<?=base_url('admin/' . ADMIN_UPDATE_URLS)?>',
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

        if(deleteCount==0){
            func(changedData);
        }

        else{
            showAlertModal("Are you sure you want to delete " + deleteCount +" link/s.",func,changedData);
        }
    }


    function reloadPage() {
        <?php
        // TODO Might be better if it didn't have to reload page. Clear table data then query through database?
        echo 'window.location = "'. site_url("admin/".ADMIN_LINKS) .'";';
        ?>
    }
    
    function isValidString($s){
       return /\w../mi.test($s);
    }

    function isValidURL($s){
        return /^[\w][\w][\w][\w]*$/mi.test($s);
    }

    function isValidDate($d){
        return/[0-9][0-9][\/][0-9][0-9][\/][0-9][0-9][0-9][0-9]/mi.test($d);
    }

</script>

<div class="col-md-10 col-md-offset-2" >
        <div class = "form-group">
            <ol class="breadcrumb">
                <li>Admin</li>
                <li class="active">Manage Links</li>
            </ol>
        </div>
</div>
    <div id="panels" class = "col-md-8 col-md-offset-2">

        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="collapseListGroupHeadingMod">
                    <h4 class="panel-title clearfix">
                        <div class="col-md-6" data-toggle="collapse" href="#collapseListGroupMod" aria-expanded="true" aria-controls="collapseListGroupMod">
                            List of Links
                        </div>

                        <div id = "linkTable_buttons">

                        <span class = "col-md-3">
                            <button type ="button"data-toggle="modal" data-target="#AddNewLinkModal" class="btn btn-default btn-block  col-md-2"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Link</button>
                                  </span>
                            <span class = "col-md-3">
                               <button class="btn btn-default btn-block col-md-2 col-md-offset-0" type="button" onclick="changeViewToEdit('linkTable','linkTable_buttons', 'AddNewLinkModal')">Edit Links</button>
                         </span>
                        </div>

                    </h4>
                </div>
                <div class="panel-collapse collapse in" role="tabpanel" id="collapseListGroupEvent" aria-labelledby="collapseListGroupHeadingEvent" aria-expanded="false">
                    <ul class="list-group">
                        <form>
                            <li class="list-group-item">
                                <table class="table table-hover" id="linkTable">
                                    <thead>
                                    <tr>
                                        <th>Link</th>
                                        <th>Event</th>
                                        <th>Question Set</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php foreach($links as $link):?>
                                        <tr id="<?=$link->url_id?>">
                                            <td><?=$link->url?></td>
                                            <td title="<?=$link->event_id?>"><?=$link->event_name?></td>
                                            <td title="<?=$link->set_id?>"><?=$link->question_set_description?></td>
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



<div id="AddNewLinkModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Link</h4>
            </div>
            <form>
                <div class="modal-body clearfix">
                    <table class="table table-hover" id="add_table" name="">  <!-- TODO: somehow insert table id in name for add ? -->
                        <thead>
                        <tr>
                            <th>Link</th>
                            <th>Event Name</th>
                            <th>Question Set</th>

                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td><input type="text" class="form-control" placeholder="Enter Link"></td>
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