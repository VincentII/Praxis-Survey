<!--CHARTS-->
<script type="text/javascript">

    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
   // google.charts.setOnLoadCallback(getAnalytics());
</script>

<script>

    $(document).on('ready', function(){

    });

    function viewComments(){
        var $eventID = $('#form_event').val();
        var $setID = $('#form_set').val();

        $.ajax({
            url: '<?php echo base_url('admin/'.ADMIN_GET_COMMENTS) ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                eventID : $eventID,
                setID : $setID
            }
        })
            .done(function(result) {
                console.log("done");

                var comments = result['comments'];
                $('#view_modal_body').html('');
                var str = "No Comments";

                if(comments.length>0) {
                 str = '';
                    for (i = 0; i < comments.length; i++) {
                        str += '<tr>';
                        str += '<td>' + (i + 1) + '</td>';
                        str += '<td>' + comments[i]['Comment_Ans'] + '</td>';
                        str += '</tr>';
                    }
                }

                $('#view_modal_body').html(str);
            })
            .fail(function() {
                console.log("fail");
            })
            .always(function() {
                console.log("complete");
            });
    }

    function getAnalytics($formSet,$formEvent,$container,$chart,$type){

        if($($formSet).val()!=null){

            $($container).show();
            $('#btn-comments').prop('disabled', false);


            var $eventID = $($formEvent).val();
            var $setID = $($formSet).val();
            $($formEvent).prop('disabled', false);
            $.ajax({
                url: '<?php echo base_url('admin/'.ADMIN_GET_REPORTS) ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    eventID : $eventID,
                    setID : $setID
                }
            })
                .done(function(result) {
                    console.log("done");

                    if(result['status']=='success') {
                        var $answers = result['answers'];
                        var $questions = result['questions'];

                        if($type=='s'){
                            $singleAnswers = $answers;
                            $singleQuestions = $questions;
                        }

                        redrawTables($chart,$type,$answers,$questions);

                    }else if(result['status']=='noReps'){
                        $($chart).html("No Reports Available");
                        if($type=='s'){
                            $singleAnswers = null;
                            $singleQuestions = null;
                        }

                    }

                })
                .fail(function() {
                    console.log("fail");
                    $($chart).html('Oops! Please reconnect to the internet and try again!');
                    if($type=='s'){
                        $singleAnswers = null;
                        $singleQuestions = null;
                    }

                })
                .always(function() {
                    console.log("complete");


                });
        }




    }

    var $singleAnswers = null, $singleQuestions = null;

    function redrawTables($chart,$type,$answers,$questions){

        if($answers!=null&&$questions!=null){
            var actualLabels = ["Totally Disagree", "Partly Disagree", "Neutral", "Partly Agree", "Totally Agree"];

            $($chart).html("");

            try {
                for (var i = 0; i < $questions.length; i++) {


                    var sum = 0;
                    var actualData = [];
                    for (var j = 0; j < 5; j++) {
                        sum += parseInt($answers[i][j]['count']);
                    }

                    actualData.push(['Rating', 'Count', {role: 'style'}, {role: 'annotation'}]);

                    for (var j = 0; j < 5; j++) {
                        var count = parseInt($answers[i][j]['count']);
                        actualData.push([actualLabels[j], count, '#127094', (Math.round(count / sum * 100 * 10) / 10) + '%']);
                    }


                    var chartData = google.visualization.arrayToDataTable(actualData);


                    $($chart).append("<div class = 'report-questions'> Q" + (i + 1) + ". " + $questions[i]['Question_Act'] + "</div>");
                    $($chart).append("<div id='dataChart" + $type + i + "' class='chart-b'></div>");

                    var options = {
                        legend: {position: "none"},
                        height: 400
                    }

                    var chart = new google.visualization.ColumnChart(document.getElementById('dataChart' + $type + i));
                    chart.draw(chartData, options);

                }
            }
            catch (err) {
                $($chart).html('Oops! Please reconnect to the internet and try again!');
            }
        }
    }


function selectSingle() {
    $('#panel_single').toggleClass('col-md-5 col-md-10');
    $('#btn_single').prop('disabled', true);
    $('#btn_compare').prop('disabled', false);
    $('#btn_single').toggleClass('btn-primary btn-default');
    $('#btn_compare').toggleClass('btn-primary btn-default');
    $('#panel_compare').hide();
    $('.comment-button').show();
    redrawTables('#charts','s',$singleAnswers,$singleQuestions);
}
function selectCompare() {
    $('#panel_single').toggleClass('col-md-10 col-md-5');
    $('#btn_compare').prop('disabled', true);
    $('#btn_single').prop('disabled', false);
    $('#btn_single').toggleClass('btn-primary btn-default');
    $('#btn_compare').toggleClass('btn-primary btn-default');
    $('#panel_compare').show();
    $('.comment-button').hide();
    redrawTables('#charts','s',$singleAnswers,$singleQuestions);
}


</script>

<div class="col-md-10 col-md-offset-1" >
        <div class = "form-group col-md-2">
        <b>REPORTS</b>
    </div>

    <div class = "col-md-2 pull-right">
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button id="btn_single" type="button" disabled class="btn btn-primary" onclick="selectSingle()">Single</button>
            </div>
            <div class="btn-group" role="group">
                <button id="btn_compare" type="button" class="btn btn-default" onclick="selectCompare()">Compare</button>
            </div>
        </div>
    </div>
</div>

<div id="panel_single" class="panel panel-default col-md-10 col-md-offset-1">
    <div class="panel-body ">
        <div class = "form-group col-md-6">
            Question Set:
            <select class="form-control" id="form_set" name="form-set" onchange="getAnalytics('#form_set','#form_event','#container-chart','#charts','s') ">
                <option value="" selected disabled>Choose a Question Set...</option>
                <?php foreach($questionSets as $row):?>
                    <option value="<?=$row->Set_ID?>"><?=$row->Question_Set_Description?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class = "form-group col-md-4">
            Events:
            <select class="form-control" id="form_event" name="form-event" onchange="getAnalytics('#form_set','#form_event','#container-chart','#charts','s')" disabled>
                <option value="0" selected>All Events</option>
                <?php foreach($events as $row):?>
                    <option value="<?=$row->Event_ID?>"><?=$row->Event_Name?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class = "form-group col-md-2">
            <br>
            <button id="btn-comments" type ="button" data-toggle="modal" data-target="#ViewCommentsModal" class="btn btn-toolbar btn-block  col-md-1 comment-button" onclick="viewComments()" disabled>View Comments</button>
        </div>


    </div>
    <div class="panel panel-default" hidden id="container-chart">
        <div class="panel-body">
            <div class = "form-group col-md-10">
                <div  id="charts"></div>
            </div>
        </div>
    </div>
</div>

<div id="panel_compare" hidden>
    <div class="panel panel-default col-md-5">
        <div class="panel-body ">
            <div class = "form-group col-md-6">
                Question Set:
                <select class="form-control" id="form_set2" name="form-set" onchange="getAnalytics('#form_set2','#form_event2','#container-chart2','#charts2','c') ">
                    <option value="" selected disabled>Choose a Question Set...</option>
                    <?php foreach($questionSets as $row):?>
                        <option value="<?=$row->Set_ID?>"><?=$row->Question_Set_Description?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class = "form-group col-md-4">
                Events:
                <select class="form-control" id="form_event2" name="form-event" onchange="getAnalytics('#form_set2','#form_event2','#container-chart2','#charts2','c')" disabled>
                    <option value="0" selected>All Events</option>
                    <?php foreach($events as $row):?>
                        <option value="<?=$row->Event_ID?>"><?=$row->Event_Name?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class = "form-group col-md-2">
                <br>
                <button id="btn-comments2" type ="button" data-toggle="modal" data-target="#ViewCommentsModal" class="btn btn-toolbar btn-block  col-md-1 comment-button" onclick="viewComments()" disabled>View Comments</button>
            </div>


        </div>
        <div class="panel panel-default" hidden id="container-chart2">
            <div class="panel-body">
                <div class = "form-group col-md-10">
                    <div  id="charts2"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="ViewCommentsModal" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
                <h4 class="modal-title" id="modal_view_title">Comments</h4>
            </div>
            <form>
                <div class="modal-body clearfix">
                    <table class="table table-hover" id="comment_table" name="">  <!-- TODO: somehow insert table id in name for add ? -->
                        <thead id="view_modal_header">
                        <tr>
                            <th>#</th>
                            <th>Comment</th>

                        </tr>
                        </thead>
                        <tbody id="view_modal_body">

                        </tbody>
                    </table>

                </div>
<!--                <div class="modal-footer" id="question_table_button">-->
<!--                    <span class = "col-md-3 pull-right">-->
<!--                               <button class="btn btn-default btn-block col-md-2 " type="button" onclick="changeViewToEdit('question_table','question_table_button')">Edit Question Set</button>-->
<!--                         </span>-->
<!--                </div>-->
            </form>
        </div>

    </div>
</div>