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
                    console.log(result)

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

<div class="col-md-4 col-md-offset-4" >
        <div class = "form-group col-md-2">
        <b>REPORTS</b>
        </div>
        <div class = "form-group col-md-2">
            Question Set:
            <select class="form-control" id="form_set" name="form-set" onclick="getAnalytics() ">
            <option value="" selected disabled>Choose a Question Set...</option>
            <?php foreach($questionSets as $row):?>
                <option value="<?=$row->Set_ID?>"><?=$row->Question_Set_Description?></option>
            <?php endforeach;?>
            </select>
        </div>
        <div class = "form-group col-md-2">
            Events:
            <select class="form-control" id="form_event" name="form-event" disabled>
                <option value="0" selected>All Events</option>
                <?php foreach($events as $row):?>
                    <option value="<?=$row->Event_ID?>"><?=$row->Event_Name?></option>
                <?php endforeach;?>
            </select>
        </div>
</div>