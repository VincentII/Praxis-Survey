<script>

    $(document).on('ready', function(){

    });





</script>

<div class="col-md-4 col-md-offset-4" >
        <div class = "form-group col-md-2">
        <b>Events</b>
        </div>

    <div id="panels" class = "col-md-8 col-md-offset-2">

        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="collapseListGroupHeadingMod">
                    <h4 class="panel-title clearfix">
                        <a role="button" class="col-md-6" data-toggle="collapse" href="#collapseListGroupMod" aria-expanded="true" aria-controls="collapseListGroupMod">
                            List of Events
                        </a>
                        <!--  TODO ADD THE MODAL BUTTON
                        <div id = "eventTable_buttons">

                        <span class = "col-md-3">
                            <button type ="button"data-toggle="modal" data-target="#AddNewModeratorModal" class="btn btn-default btn-block  col-md-2"> +Add Moderators</button>

                                  </span>
                            <span class = "col-md-3">
                               <button class="btn btn-default btn-block col-md-2 col-md-offset-0" type="button" onclick="changeViewToEdit('modtable','modtable_buttons', 'AddNewModeratorModal')">Edit Accounts</button>
                         </span>
                        </div>
                        -->
                    </h4>
                </div>
                <div class="panel-collapse collapse in" role="tabpanel" id="collapseListGroupEvent" aria-labelledby="collapseListGroupHeadingEvent" aria-expanded="false">
                    <ul class="list-group">
                        <form>
                            <li class="list-group-item">
                                <table class="table table-hover" id="eventTable">
                                    <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Closed</th>
                                        <th>Archived</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php foreach($events as $event):?>
                                        <tr>
                                            <td><?=$event->Event_Name?></td>
                                            <td><?php
                                                $time = strtotime($event->event_date);
                                                echo date("M d, Y", $time);
                                                ?></td>
                                            <td><?=$event->Location?></td>
                                            <?php if($event->is_closed==1): ?>
                                            <td>Yes</td>
                                            <?php else:?>
                                            <td>No</td>
                                            <?php endif;?>
                                            <?php if($event->is_archived==1): ?>
                                                <td>Yes</td>
                                            <?php else:?>
                                                <td>No</td>
                                            <?php endif;?>
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

</div>