
<script>

    $(document).on('ready', function(){

    });

    function enter() {
        var $link = $('#link').val();

        if($link!=null&&$link!="")
        window.location.href='<?=base_url()?>survey/'+$link;
    }

    document.getElementById("#link")
        .addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode == 13) {
                enter()
            }
        });

</script>

<div class="center_container">
    <div class="col-md-8 center">

        <center><img src="<?=base_url()?>/assets/img/Praxis%20Logo.svg" style="width: 50%; height: auto; padding-bottom: 2%"></center>
        <div class="input-group">
            <span class="input-group-addon" id="sizing-addon1">
                Praxis-Survey.com/survey/
            </span>
            <input type="text" id="link" class="form-control" placeholder="Link" onkeydown = "if (event.keyCode == 13)enter()">
            <span class="input-group-btn">
                <button class="btn btn-default" id="submit-sign-in" onclick="enter()">GO!</button>
            </span>
        </div><!-- /input-group -->
        <div>
            <div class="error_message"><?=$errorMessage?>
            </div>
        </div>



    </div>
</div>
