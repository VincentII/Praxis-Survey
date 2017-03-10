<div id="alertModal" class="modal fade" role="dialog"
     data-backdrop="static"
     data-keyboard="false"
     href="#">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Wait a second!</h4>
            </div>


            <div class="modal-body clearfix">
                <h3 id="alertTitle" class="modal-title"></h3>
                <button type="button" class="btn btn-danger" id="btn_alert_no">NO!</button>
                <button type="button" class="btn btn-success" id="btn_alert_yes")">YES!</button>
            </div>
            <div class="modal-footer">

            </div>

        </div>

    </div>
</div>

<script>


    function showAlertModal($s,$callback,$data){
        $('#alertModal').modal('toggle');
        $('#alertTitle').html($s);
        $('#btn_alert_yes').on("click",function(){
            console.log("YES")
            $callback($data);
            $('#alertModal').modal('hide');
        });
        $('#btn_alert_no').on("click",function(){
            $('#alertModal').modal('hide');
        });
    }

</script>