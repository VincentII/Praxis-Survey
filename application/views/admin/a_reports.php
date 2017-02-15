<script>

    $(document).on('ready', function(){

    });

    function getAnalytics(){

        if($('#form_set').val()!=null){
            $eventID = $('#form_event').val();
            $setID = $('#form_set').val();
            $('#form_event').prop('disabled', false);
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

                        var sum = function (a, b) {
                            return a + b
                        };

                        var actualLabels = ["Totally Disagree", "Partly Disagree", "Neutral", "Partly Agree", "Totally Agree"];

                        $('#charts').html("");

                        for (var i = 0; i < $questions.length; i++) {

                            var actualData = [];

                            for (var j = 0; j < 5; j++) {
                                actualData.push(parseInt($answers[i][j]['count']));
                            }

                            console.log(actualData);
                            var data = {
                                labels: actualLabels,
                                series: [
                                    actualData
                                ]
                            };

                            var options = {
                                seriesBarDistance: 15,
                                axisY: {onlyInteger: true},
                                showGridBackground: true,
                                distributeSeries: false

                            };

                            var responsiveOptions = [
                                ['screen and (min-width: 641px) and (max-width: 1024px)', {
                                    seriesBarDistance: 10,
                                    axisX: {
                                        labelInterpolationFnc: function (value) {
                                            return value;
                                        }
                                    }
                                }],
                                ['screen and (max-width: 640px)', {
                                    seriesBarDistance: 5,
                                    axisX: {
                                        labelInterpolationFnc: function (value) {
                                            return value[0];
                                        }
                                    }
                                }]
                            ];


                            $('#charts').append("<div class = 'report-questions'> Q" + (i + 1) + ". " + $questions[i]['Question_Act'] + "</div>");
                            $('#charts').append("<div class='ct-chart ct-square' id='dataChart" + i + "'></div>");

                            new Chartist.Bar("#dataChart" + i, data, options, responsiveOptions);

                        }
                    }else if(result['status']=='noReps'){
                        $('#charts').html("No Reports Available");

                    }

                })
                .fail(function() {
                    console.log("fail");
                })
                .always(function() {
                    console.log("complete");
                });
        }




    }





</script>

<div class="col-md-4 col-md-offset-2" >
        <div class = "form-group col-md-2">
        <b>REPORTS</b>
        </div>
</div>
<div class="col-md-10 col-md-offset-2">
        <div class = "form-group col-md-6">
            Question Set:
            <select class="form-control" id="form_set" name="form-set" onclick="getAnalytics() ">
            <option value="" selected disabled>Choose a Question Set...</option>
            <?php foreach($questionSets as $row):?>
                <option value="<?=$row->Set_ID?>"><?=$row->Question_Set_Description?></option>
            <?php endforeach;?>
            </select>
        </div>
        <div class = "form-group col-md-4">
            Events:
            <select class="form-control" id="form_event" name="form-event" onclick="getAnalytics()" disabled>
                <option value="0" selected>All Events</option>
                <?php foreach($events as $row):?>
                    <option value="<?=$row->Event_ID?>"><?=$row->Event_Name?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class = "col-md-10" id="charts"></div>
</div>
