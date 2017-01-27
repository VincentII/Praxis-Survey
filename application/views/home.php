<script>




    function button(){

        var $lol = <?php echo json_encode($stuff); ?>;
        console.log($('#input-id').val());
        toastr.info("Toast WORKS FUCKER", "Info");
    }

    $(document).on('ready', function(){



        $('.rating-loading').rating({
            step: 1,
            starCaptions: {1: 'Very Poor', 2: 'Poor', 3: 'Ok', 4: 'Good', 5: 'Very Good'},
            starCaptionClasses: {1: 'text-danger', 2: 'text-warning', 3: 'text-info', 4: 'text-primary', 5: 'text-success'}
        });
    });

</script>


<div id="yes">Hello</div>
<input id="input-id" name="input-name" type="number" class="rating-loading">

<button onclick="button()">LOL</button>