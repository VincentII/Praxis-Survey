<script>

    $(document).on('ready', function(){



        //console.log(<?php echo json_encode($events) ?>)
    });

    function enter(){
        $eventID = $('#form_event').val();
        $setID = $('#form_set').val();



        $.ajax({
            url: '<?php echo base_url('home/checkInputs') ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                eventID : $eventID,
                setID : $setID
            }
        })
            .done(function(result) {
                console.log("done");
                if (result['status']=="success") {
                    toastr.success("WOW");

                    window.location.href = '<?=base_url('questions')?>';

                }
                else {
                    toastr.error(result['message']);
                }

            })
            .fail(function() {
                console.log("fail");
            })
            .always(function() {
                console.log("complete");
            });

    }

</script>

<div class="col-md-4 col-md-offset-4" >
        <div class = "form-group col-md-2">
            Events:
            <select class="form-control" id="form_event" name="form-event"">
                <option value="" selected disabled>Choose an Event...</option>
                <?php foreach($events as $row):?>
                    <option value="<?=$row->Event_ID?>"><?=$row->Event_Name?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class = "form-group col-md-2">
            Question Set:
            <select class="form-control" id="form_set" name="form-set"">
                <option value="" selected disabled>Choose a Question Set...</option>
                <?php foreach($questionSets as $row):?>
                    <option value="<?=$row->Set_ID?>"><?=$row->Question_Set_Description?></option>
                <?php endforeach;?>
            </select>
        </div>
    <button class="btn btn-default" id="submit-sign-in" onclick="enter()">Enter</button>
</div>