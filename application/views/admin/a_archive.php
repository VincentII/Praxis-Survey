<script>

    $(document).on('ready', function(){
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '0d'
        });
    });

    function getChangesTableDataWithID(tableID) {
        var table = document.getElementById(tableID);

        var jObject = [];
        for (var i = 1; i < table.rows.length; i++)
        {

            var row = i - 1;


            var valid = true;
            var columns = [];


            columns[0]=table.rows[i].id;
            columns[1]=table.rows[i].cells[1].childNodes[0].checked;
            columns[2]=table.rows[i].cells[2].childNodes[0].checked;


            if (valid) {
                jObject[row] = columns;
            }
        }
        return jObject;
    }

    function changeViewToEdit(table, buttons){
        //console.log(table);
        var tableA = document.getElementById(table);
        var rows = tableA.rows;
        var tID = table;
        var bID = buttons;

        //console.log(initialTableData);

        var funct = "submitChanges";

        var buttonsStr =
            "<span class = \"col-md-3\">"+
            "<button class=\"btn  btn-danger btn-block col-md-2\" type=\"button\" onclick=\"changeViewToView('"+tID+"','"+bID+"')\">Cancel</button>"+
            "</span>"+
            "<span class = \"col-md-3\">"+
            "<button class=\"btn  btn-success btn-block col-md-20\" type=\"button\" onclick=\""+funct+"('"+tID+"')\" ><span class=\"glyphicon glyphicon-floppy-disk\" aria-hidden=\"true\"></span> Save Changes </button>"+
            "</span>";



        document.getElementById(buttons).innerHTML = buttonsStr;


        rows[0].cells[1].innerHTML = 'Archived';
        rows[0].cells[2].innerHTML = 'Delete';

        for(var i = 1; i < rows.length; i++) {
            var cells = rows[i].cells;

            cells[1].id = "C1R" + i;
            cells[2].id = "C2R" + i;

            var curArchive = $(cells[1]).attr("id");
            var curDelete = $(cells[2]).attr("id");


            var curName = cells[0].innerHTML;

            //console.log(cells);


            //console.log(curDeptID);
            cells[1].innerHTML = '<input type="checkbox" class="checkbox-inline" value="" checked>';
            cells[2].innerHTML = '<input type="checkbox" class="checkbox-inline" value="">';
        }


    }

    function changeViewToView(table, button){
        reloadPage(); //TODO
    }


    function getChangedData(newTableData) {
        var changedData = [];
        var changedDataIndex = 0;

        console.log(newTableData);

        for (var i = 0; i < newTableData.length; i++) {


            if (
                    newTableData[i][1] == false||
                    newTableData[i][2] == true
            ) {

                changedData[changedDataIndex] = newTableData[i];
                changedDataIndex++;
            }
        }

        return changedData;
    }

    function submitChanges(tableID) {
        var changedData = getChangedData(getChangesTableDataWithID(tableID));

        var deleteCount = 0;
        var unArchiveCount = 0;

        for(var i = 0; i<changedData.length; i++) {
            if (changedData[i][2]){
                deleteCount++;
            }else
            if(!changedData[i][1]){
                unArchiveCount++
            }
        }


        if(tableID=='eventTable'){
            if(deleteCount>0||unArchiveCount>0){
                var func = function(changedData){
                    if(changedData.length>0) {
                        $.ajax({
                            url: '<?=base_url('admin/' . ADMIN_ARCHIVE_EVENTS)?>',
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
                                    toastr.success(result['message'], "Success");
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

                if(deleteCount>0){
                    showAlertModal("Are you sure you want to DELETE " + deleteCount +" event/s. All analytics will be gone!",func,changedData);
                }else
                    showAlertModal("Are you sure you want to remove " + unArchiveCount +" event/s from Archive.",func,changedData);

            }
            else
                toastr.error("No changes were made.", "Oops!");
        }
        else
        if(tableID=='setTable'){
            if(deleteCount>0||unArchiveCount>0){
                var func = function(changedData){
                    if(changedData.length>0) {
                        $.ajax({
                            url: '<?=base_url('admin/' . ADMIN_ARCHIVE_SETS)?>',
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
                                    toastr.success(result['message'], "Success");
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

                if(deleteCount>0){
                    showAlertModal("Are you sure you want to DELETE " + deleteCount +" set/s. All analytics will be gone!",func,changedData);
                }else
                    showAlertModal("Are you sure you want to remove " + unArchiveCount +" set/s from archive.",func,changedData);

            }
            else
                toastr.error("No changes were made.", "Oops!");
        }




    }

    function reloadPage() {
        <?php
        // TODO Might be better if it didn't have to reload page. Clear table data then query through database?
        echo 'window.location = "'. site_url("admin/".ADMIN_ARCHIVE) .'";';
        ?>
    }

    function isValidString($s){
       return /\w../mi.test($s);
    }

    function isValidDate($d){
        return/[0-9][0-9][\/][0-9][0-9][\/][0-9][0-9][0-9][0-9]/mi.test($d);
    }




</script>

<div class="col-md-10 col-md-offset-2" >
        <div class = "form-group">
            <ol class="breadcrumb">
                <li>Super Admin</li>
                <li class="active">Archive</li>
            </ol>
        </div>
</div>
    <div id="panels" class = "col-md-8 col-md-offset-2">

        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="collapseListGroupHeadingMod">
                    <h4 class="panel-title clearfix">
                        <div class="col-md-6">
                            List of Events
                        </div>

                        <div id = "eventTable_buttons">

                            <span class = "col-md-4 pull-right">
                               <button class="btn btn-default btn-block col-md-3" type="button" onclick="changeViewToEdit('eventTable','eventTable_buttons')">Edit Archived Events </button>
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
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php foreach($events as $event):?>
                                        <tr id="<?=$event->Event_ID?>">
                                            <td><?=$event->Event_Name?></td>
                                            <td></td>
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

<div id="panels" class = "col-md-8 col-md-offset-2">

    <div class="panel-group" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="collapseListGroupHeadingMod">
                <h4 class="panel-title clearfix">
                    <div class="col-md-6">
                        List of Question Sets
                    </div>

                    <div id = "setTable_buttons">

                            <span class = "col-md-4 pull-right">
                               <button class="btn btn-default btn-block col-md-3 pull-right" type="button" onclick="changeViewToEdit('setTable','setTable_buttons')">Edit Archived Sets</button>
                         </span>
                    </div>

                </h4>
            </div>
            <div class="panel-collapse collapse in" role="tabpanel" id="collapseListGroupEvent" aria-labelledby="collapseListGroupHeadingEvent" aria-expanded="false">
                <ul class="list-group">
                    <form>
                        <li class="list-group-item">
                            <table class="table table-hover" id="setTable">
                                <thead>
                                <tr>
                                    <th>Question Set Name</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>


                                <?php foreach($questionSets as $set):?>
                                    <tr id="<?=$set->Set_ID?>">
                                        <td><?=$set->Question_Set_Description?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </li>
                        <div class = "panel-footer clearfix" id = "settable_footer">
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</div>


