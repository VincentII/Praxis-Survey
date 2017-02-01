<script>




    function button(){
        toastr.info("Toast WORKS FUCKER", "Info");
    }

    $(document).on('ready', function(){

        console.log(<?php echo json_encode($events) ?>)
    });

</script>

<form class="col-md-4 col-md-offset-4" method="post" action="<?=base_url('questions')?>">
        <div class = "form-group col-md-2">
            Events:
            <select class="form-control" id="form_building" name="form-building"">
                <option value="" selected disabled>Choose an Event...</option>
                <?php foreach($events as $row):?>
                    <option value="<?=$row->Event_ID?>"><?=$row->Event_Name?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class = "form-group col-md-2">
            Question Set:
            <select class="form-control" id="form_building" name="form-building"">
                <option value="" selected disabled>Choose a Question Set...</option>
                <?php foreach($questionSets as $row):?>
                    <option value="<?=$row->Set_ID?>"><?=$row->Question_Set_Description?></option>
                <?php endforeach;?>
            </select>
        </div>
    <button type="submit" class="btn btn-default" id="submit-sign-in">Sign In</button>
</form>