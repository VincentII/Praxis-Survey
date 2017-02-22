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
        cellQuestion.innerHTML = '<input type="text" class="form-control" placeholder="Enter event name"></td>';
        del.innerHTML=      '<button type ="button" name="add_delete_'+(tableA.rows.length-1)+'" onclick="deleteRow(\'add_table\',this.name)" class="btn btn-default clearmod-btn">&times;</button>';

    }

    function deleteRow(table, $id){
        var tableA = document.getElementById(table);
        var index = parseInt($id.split("_")[2]);



        for(i=index;i<tableA.rows.length;i++){

            tableA.rows[i].cells[0].innerHTML = i-1;
            tableA.rows[i].cells[2].childNodes[0].name = "add_delete_" + (i-1);
        }

        tableA.deleteRow(index);
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
                                        <th>Question Set</th>
                                        <th>View</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php foreach($questionSets as $set):?>
                                        <tr id="<?=$set->Set_ID?>">
                                            <td><?=$set->Question_Set_Description?></td>
                                            <td> <button type ="button" class="btn btn-default btn-block  col-md-1" value=<?=$set->Set_ID?>>View</button></td>
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



<div id="AddNewEventModal" class="modal fade" role="dialog">
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
                            <td><input type="text" class="form-control" placeholder="Enter event name"></td>
                            <td><button type ="button" id="add_delete_1" onclick="deleteRow('add_table',this.id)" class="btn btn-default clearmod-btn">&times;</button></td>

                        </tr>
                        </tbody>
                    </table>

                    <button type = "button" class = "btn btn-default btn-block  " onclick = "addQuestion('add_table')">Add Another Question</button>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" name="add-event-btn" onclick="submitQuestionSet('add_table',this.name)">Confirm</button>
                </div>
            </form>
        </div>

    </div>
</div>