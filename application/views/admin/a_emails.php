<script type='text/javascript' src='https://code.jquery.com/jquery-1.11.0.min.js'></script>
<script>
    $(document).ready(function () {


        function exportTableToCSV($table, filename) {
            console.log("HELLO");
            var $headers = $table.find('tr:has(th)')
                ,$rows = $table.find('tr:has(td)')

                // Temporary delimiter characters unlikely to be typed by keyboard
                // This is to avoid accidentally splitting the actual contents
                ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                ,tmpRowDelim = String.fromCharCode(0) // null character

                // actual delimiter characters for CSV format
                ,colDelim = '","'
                ,rowDelim = '"\r\n"';

            // Grab text from table into CSV formatted string
            var csv = '"';
            csv += formatRows($headers.map(grabRow));
            csv += rowDelim;
            csv += formatRows($rows.map(grabRow)) + '"';

            // Data URI
            var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

            // For IE (tested 10+)
            if (window.navigator.msSaveOrOpenBlob) {
                var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
                    type: "text/csv;charset=utf-8;"
                });
                navigator.msSaveBlob(blob, filename);
            } else {
                $(this)
                    .attr({
                        'download': filename
                        ,'href': csvData
                        //,'target' : '_blank' //if you want it to open in a new window
                    });
            }

            //------------------------------------------------------------
            // Helper Functions
            //------------------------------------------------------------
            // Format the output so it has the appropriate delimiters
            function formatRows(rows){
                return rows.get().join(tmpRowDelim)
                    .split(tmpRowDelim).join(rowDelim)
                    .split(tmpColDelim).join(colDelim);
            }
            // Grab and format a row from the table
            function grabRow(i,row){

                var $row = $(row);
                //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                var $cols = $row.find('td');
                if(!$cols.length) $cols = $row.find('th');

                return $cols.map(grabCol)
                    .get().join(tmpColDelim);
            }
            // Grab and format a column from the table
            function grabCol(j,col){
                var $col = $(col),
                    $text = $col.text();

                return $text.replace('"', '""'); // escape double quotes

            }
        }


        // This must be a hyperlink
        $("#export").click(function (event) {
            // var outputFile = 'export'
            var outputFile = 'export';
            outputFile = outputFile.replace('.csv','') + '.csv'

            // CSV
            exportTableToCSV.apply(this, [$('#emailTable'), outputFile]);

            // IF CSV, don't do event.preventDefault() or return false
            // We actually need this to be a typical hyperlink
        });
    });
</script>

<div class="col-md-10 col-md-offset-2" >
        <div class = "form-group">
            <ol class="breadcrumb">
                <li>Admin</li>
                <li class="active">Emails</li></ol>
        </div>
</div>
    <div id="panels" class = "col-md-8 col-md-offset-2">

        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="collapseListGroupHeadingMod">
                    <h4 class="panel-title clearfix">
                        <div class="col-md-6">
                            List of Emails
                        </div>
                    </h4>
                </div>
                <div class="panel-collapse collapse in" role="tabpanel" id="collapseListGroupEvent" aria-labelledby="collapseListGroupHeadingEvent" aria-expanded="false">
                    <ul class="list-group">
                        <form>
                            <li class="list-group-item">
                                <table class="table table-hover" id="emailTable">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile#</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php foreach($emails as $email):?>
                                        <tr>
                                            <td><?=$email->Name?></td>
                                            <td><?=$email->Email?></td>
                                            <td><?=$email->Mobile?></td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </li>
                            <div class = "panel-footer clearfix" id = "emailtable_footer">
                                <a class="btn btn-default col-md-2 pull-left" href="#" id ="export" role='button'> <span class='glyphicon glyphicon-export' aria-hidden=\"true\"></span> Export Table
                                </a>
                            </div>

                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>

