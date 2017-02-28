<script>

    $(document).on('ready', function(){
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '0d'
        });
    });


    function submitQuestionSet($tableID,$button) {
        var table = document.getElementById($tableID);
        var cells = 2;


        var allData =[];

        var questionSet = $('#form_submit_set_name').val();

        if (!isValidString(questionSet)) {
            toastr.error("Input valid question set name", "Error");
            return;
        }

        if(table.rows.length>1) {
            for (i = 1; i < table.rows.length; i++) {
                var addData = [];
                addData[0] = (table.rows[i].cells[0].innerHTML);
                addData[1] = (table.rows[i].cells[1].childNodes[0].value);

                console.log(addData);


                if (!isValidString(addData['question'])) {
                    toastr.error("Question given in Q#" + i + " is Invalid", "Error");
                    return;
                }

                allData.push(addData);

            }
        }
        else
        {
            toastr.error("No Questions were Added");
            return;
        }



        console.log(allData);

        $.ajax({
            url: '<?php echo base_url('admin/' . ADMIN_SUBMIT_QUESTION_SET) ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                questions: allData,
                questionSet: questionSet


            }
        })
            .done(function (result) {
                console.log("success");

                console.log(result['check']);

                if(result['status']=='success'){
                    toastr.success(result['message'], "Success");
                    $('#'+$button).prop('disabled', true);
                    var delay = 1000;
                    setTimeout(function () {
                        reloadPage();
                    }, delay);
                }else
                if(result['status']=='fail'){
                    toastr.error(result['message'], "Error");
                }

            })
            .fail(function () {
                console.log("fail");

                toastr.error("Something went wrong... Try again", "Error");
            })
            .always(function () {
                console.log("complete");
            });
    }

    function addQuestion(table){
        console.log(table);
        var tableA =document.getElementById(table);
        var row = tableA.insertRow();


        var cellNumber = row.insertCell(0);
        var cellQuestion = row.insertCell(1);
        var del       = row.insertCell(2);

        cellNumber.innerHTML = tableA.rows.length-1;
        cellQuestion.innerHTML = '<input type="text" class="form-control" placeholder="Enter question"></td>';
        del.innerHTML=      '<button type ="button" name="add_delete_'+(tableA.rows.length-1)+'" onclick="deleteRow(\'add_table\',this.name)" class="btn btn-default pull-right clearmod-btn">&times;</button>';

    }

    function addUpdateQuestion(table){
        console.log(table);
        var tableA =document.getElementById(table);
        var row = tableA.insertRow();

        row.id = 'new';

        var cellNumber = row.insertCell(0);
        var cellQuestion = row.insertCell(1);
        var del       = row.insertCell(2);

        /*
        cellNumber.id='C0R'+(tableA.rows.length-1);
        cellQuestion.id='C1R'+(tableA.rows.length-1);
        del.id='C2R'+(tableA.rows.length-1);
*/
        cellNumber.innerHTML = tableA.rows.length-1;
        cellQuestion.innerHTML = '<input type="text" class="form-control" placeholder="Enter question"></td>';
        del.innerHTML=      '<button type ="button" name="update_delete_'+(tableA.rows.length-1)+'" onclick="deleteUpdateRow(\'question_table\',this.name)" class="btn btn-default pull-right clearmod-btn">&times;</button>';

    }

    function deleteRow(table, $id){
        var tableA = document.getElementById(table);
        var index = parseInt($id.split("_")[2]);

        console.log($id);

        for(i=index;i<tableA.rows.length;i++){

            tableA.rows[i].cells[0].innerHTML = i-1;
            tableA.rows[i].cells[2].childNodes[0].name = "add_delete_" + (i-1);
        }

        tableA.deleteRow(index);
    }

    var deletedQuestions = [];

  function deleteUpdateRow(table, $id){
        var tableA = document.getElementById(table);
        var index = parseInt($id.split("_")[2]);

        //console.log($id);

        if(tableA.rows[index].id != 'new'){
            //console.log("deleted"+tableA.rows[index].id);
            deletedQuestions.push(tableA.rows[index].id);
        }

        for(i=index;i<tableA.rows.length;i++){

            tableA.rows[i].cells[0].innerHTML = i-1;
            tableA.rows[i].cells[2].childNodes[0].name = "update_delete_" + (i-1);
        }



        tableA.deleteRow(index);
    }


    var currSetID;

    function loadViewModal($setID){

        currSetID = $setID;
        var $questionSet = <?=json_encode($questionSets)?>;
        for(i=0;i<$questionSet.length;i++)
            if($questionSet[i]['Set_ID']==$setID){
            $("#modal_view_title").html($questionSet[i]['Question_Set_Description']);
            break;
            }

            console.log($questionSet);

        $.ajax({
            url: '<?php echo base_url('admin/' . ADMIN_GET_QUESTIONS) ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                setID:$setID
            }
        })
            .done(function (result) {
                console.log("success");
                $finalQuestions = result['questions'];
               // console.log($finalQuestions[1]);
                if(result['status']=='success'){
                    str ="";
                    for(i=0; i<$finalQuestions.length;i++){
                        str+="<tr id ='"+$finalQuestions[i]['question_ID']+"'>";
                        str+="<td>"+$finalQuestions[i]['Question_Num']+"</td>";
                        str+="<td>"+$finalQuestions[i]['Question_Act']+"</td>";
                        str+="</tr>";
                    }
                    $("#view_modal_body").html(str);

                }else
                if(result['status']=='fail'){
                    toastr.error(result['message'], "Error");
                }

            })
            .fail(function () {
                console.log("fail");

                toastr.error("Something went wrong... Try again", "Error");
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

            console.log(table.rows[i].cells);

            columns[0] = table.rows[i].cells[0].childNodes[0].data;
            columns[1] = table.rows[i].cells[1].childNodes[0].data;
            //columns[2] = table.rows[i].cells[2].childNodes[0].data;


//            console.log(columns);
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

            columns[0] = table.rows[i].cells[0].childNodes[0].data;
            columns[1] = table.rows[i].cells[1].childNodes[0].value;
            columns['id'] = table.rows[i].id;

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

    function changeViewToEdit(table, buttons){
        //console.log(table);
        var tableA = document.getElementById(table);
        var rows = tableA.rows;
        var tID = table;
        var bID = buttons;

        console.log("TABLE ID = "+table);

        initialTableData = getTableDataWithID(tID);
        console.log(initialTableData);



        var funct = "submitChanges";

        var buttonsStr =
            '<button type = "button" class = "btn btn-default btn-block  " onclick = "addUpdateQuestion(\'question_table\')">Add Another Question</button>'+
            '<br>'+
            "<span class = \"col-md-3 pull-right\">"+
            "<button class=\"btn  btn-danger btn-block col-md-2\" type=\"button\" onclick=\"changeViewToView('"+tID+"','"+bID+"')\">Cancel</button>"+
            "</span>"+
            "<span class = \"col-md-3 pull-right\">"+
            "<button class=\"btn  btn-success btn-block col-md-20\" type=\"button\" onclick=\""+funct+"('"+tID+"')\" >Save Changes</div>"+
            "</span>";



        document.getElementById(buttons).innerHTML = buttonsStr;

        rows[0].insertCell(2).outerHTML = "<th>Delete</th>";

        for(var i = 1; i < rows.length; i++) {
            var cells = rows[i].cells;

            rows[i].insertCell(2);

            cells[0].id = "C0R" + i;
            cells[1].id = "C1R" + i;
            cells[2].id = "C2R" + i;

            var curNumID = $(cells[0]).attr("id");
            var curActID = $(cells[1]).attr("id");
            var curDeleteID = $(cells[2]).attr("id");


            var curNum = cells[0].innerHTML;
            var curAct = cells[1].innerHTML;
            var curDelete = cells[2].innerHTML;

            //console.log(cells);


            //console.log(curDeptID);
           // cells[0].innerHTML = "<input type=\"text\" class=\"form-control\" id=\"" + curNumID + "\"value=\"" + curNum + "\">";
            cells[1].innerHTML = "<input type=\"text\" class=\"form-control\" id=\"" + curActID + "\"value=\"" + curAct + "\">";
            cells[2].innerHTML = '<button type ="button" name="update_delete_'+i+'" onclick="deleteUpdateRow(\'question_table\',this.name)" class="btn btn-default pull-right clearmod-btn">&times;</button>';
        }


    }

    function changeViewToView(table, button){
        reloadPage(); //TODO
    }


    function getChangedData(newTableData) {
        var changedData = [];
        var changedDataIndex = 0;

        console.log(newTableData);

        for (var i = 0; i < newTableData.length; i++){
            if(newTableData[i]['id']!='new'){
                for(var j=0; j<initialTableData.length;j++){
                    if(newTableData[i]['id']==initialTableData[j]['id']){
                        if( newTableData[i][0]!=initialTableData[j][0]||
                            newTableData[i][1]!=initialTableData[j][1])
                        {
                            changedData[changedDataIndex] = newTableData[i];
                           changedData[changedDataIndex][2] = newTableData[i]['id'];
                            changedDataIndex++;
                        }
                    }
                }
            }
            else{
                changedData[changedDataIndex] = newTableData[i];
                changedData[changedDataIndex][2] = newTableData[i]['id'];
                changedDataIndex++;
            }




            /*
            if (initialTableData[i][0] != newTableData[i][0] ||
                initialTableData[i][1] != newTableData[i][1] ||
                initialTableData[i][2] != newTableData[i][2] ||
                newTableData[i][3] == true
            ) {

                changedData[changedDataIndex] = newTableData[i];
                changedData[changedDataIndex][4] = initialTableData[i]['id'];
                changedDataIndex++;
            }
            */
        }

        return changedData;
    }

    function submitChanges(tableID) {

        var newTable = getChangesTableDataWithID(tableID);

       // console.log(newTable);

        if(newTable.length==0){
            toastr.error("You can't have an empty question set","Opps");
            return;
        }

        for(var i = 0; i<newTable.length; i++) {
            if (!isValidString(newTable[i][1])){
                toastr.error("One or more question/s given is Invalid","Error");
                return;
            }
        }

        /*
        for(var i = 0; i<newTable.length; i++) {
            for(var j=i+1;j<newTable.length;j++){
                console.log(newTable[i][0] +" "+ newTable[j][0]);
                if(newTable[i][0]==newTable[j][0]){
                    toastr.error("You can't have same named URLS","Oops");
                    return;
                }
            }
        }
        */

        var changedData = getChangedData(newTable);

        /*
        for(var i = 0; i<changedData.length; i++) {
            if (!isValidString(changedData[i][0])){
                toastr.error("Url given is Invalid","Error");
                return;
            }
        }
        */

        console.log(changedData);
        console.log(deletedQuestions);
        if(changedData.length>0||deletedQuestions.length>0) {
            $.ajax({
                url: '<?=base_url('admin/' . ADMIN_UPDATE_QUESTIONS)?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    changedData: changedData,
                    deletedQuestions: deletedQuestions,
                    setID: currSetID
                }
            })
                .done(function (result) {
                    console.log("done");
                    console.log(result);

                    if (result['status'] == "success") {
                        toastr.success("Changes were made successfully.", "Success");


                        var delay = 1000;
                        if(result['added']>0){
                            toastr.info(result['added']+" new Question/s", "Added");
                            delay+=1000;
                        }
                        if(result['updated']>0){
                            toastr.info(result['updated']+" Question/s", "Updated");
                            delay+=1000;
                        }
                        if(result['deleted']>0){
                            toastr.info(result['deleted']+" Question/s", "Deleted");
                            delay+=1000;
                        }

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
        echo 'window.location = "'. site_url("admin/".ADMIN_QUESTIONS) .'";';
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
        <b>Question Sets</b>
        </div>
</div>
    <div id="panels" class = "col-md-8 col-md-offset-2">

        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="collapseListGroupHeadingMod">
                    <h4 class="panel-title clearfix">
                        <a role="button" class="col-md-6" data-toggle="collapse" href="#collapseListGroupMod" aria-expanded="true" aria-controls="collapseListGroupMod">
                            List of Question Sets
                        </a>

                        <div id = "questionTable_buttons">

                        <span class = "col-md-4 pull-right">
                            <button type ="button"data-toggle="modal" data-target="#AddNewQuestionsModal" class="btn btn-default btn-block  col-md-2"> +Add Questions</button>

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
                                        <th>Question Set</th>
                                        <th>View</th>
                                        <th>Open</th>

                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php foreach($questionSets as $set):?>
                                        <tr id="<?=$set->Set_ID?>">
                                            <td><?=$set->Question_Set_Description?></td>
                                            <td> <button type ="button" data-toggle="modal" data-target="#ViewQuestionsModal" class="btn btn-default btn-block  col-md-1" onclick="loadViewModal(this.value)" value=<?=$set->Set_ID?>>View</button></td>
                                            <?php if($set->is_closed==0): ?>
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



<div id="AddNewQuestionsModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Questions</h4>
            </div>
            <form>
                <div class="modal-body clearfix">
                    Question Set Name:<input type="text" id="form_submit_set_name" class="form-control" placeholder="Enter Set name">
                    <table class="table table-hover" id="add_table" name="">  <!-- TODO: somehow insert table id in name for add ? -->
                        <thead>
                        <tr>
                            <th>Q#</th>
                            <th>Question</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>


                        <tr>
                            <td>1</td>
                            <td><input type="text" class="form-control" placeholder="Enter question"></td>
                            <td><button type ="button" name="add_delete_1" onclick="deleteRow('add_table',this.name)" class="btn btn-default pull-right clearmod-btn">&times;</button></td>

                        </tr>
                        </tbody>
                    </table>

                    <button type = "button" class = "btn btn-default btn-block  " onclick = "addQuestion('add_table')">Add Another Question</button>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" name="add-questiion-btn" onclick="submitQuestionSet('add_table',this.name)">Confirm</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div id="ViewQuestionsModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal_view_title">Question Set</h4>
            </div>
            <form>
                <div class="modal-body clearfix">
                    <table class="table table-hover" id="question_table" name="">  <!-- TODO: somehow insert table id in name for add ? -->
                        <thead>
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