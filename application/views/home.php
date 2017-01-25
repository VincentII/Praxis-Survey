<script>
    function button(){

        var $lol = <?php echo json_encode($stuff); ?>;
        console.log($lol);
        toastr.info("Toast WORKS FUCKER", "Info");
    }
</script>
<div id="yes">Hello</div>
<button onclick="button()">LOL</button>