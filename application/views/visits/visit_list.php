<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>visits/index" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Visit Mode</th>
                                        <th>Client/Lead Name</th>
                                        <th>Visit Date</th>
                                        <th>Visit Type</th>
                                        <th>Opportunity</th>
                                        <th>Visit Notes</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    // to active the sidebar
    // $('.nav .nav-list').activeSidebar('.zipcodegroup_li');
    $(".visits_li").active();

    var table = $("#dynamic-table");
    
    var oTable = table
        .DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax":{
                "url": table.data('url'),
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                { "data": "visit_mode" },
                { "data": "client_name" },
                { "data": "visit_date" },
                { "data": "visit_type" },
                { "data": "opportunity" },
                { "data": "visit_notes" },
            ]
        });
</script>
@endscript