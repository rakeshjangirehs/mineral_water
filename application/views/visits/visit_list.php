<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="row m-b-20">
                                <div class="col-sm-12 col-md-3 offset-md-9">
                                    <div class="input-group">
                                        <div class="input-group-addon" id="date_decrease" title="Decrease Date"><i class="feather icon-chevrons-left"></i></div>
                                        <input type="text" name="" id="visit_date" class="form-control pull-right" value="<?php //echo date('Y-m-d');?>" placeholder="Choose Date to filter"/>
                                        <div class="input-group-addon" id="date_increase" title="Increase Date"><i class="feather icon-chevrons-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>visits/index" style="width:100%;" data-order="[[2,&quot;desc&quot;]]">
                                    <thead>
                                    <tr>
                                        <th>Visit Mode</th>
                                        <th>Client/Lead Name</th>
                                        <th>Visit Date Time</th>
                                        <th>Visit Type</th>
                                        <th>Opportunity</th>
                                        <th>Visit Notes</th>
                                        <th>Created By</th>
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
                "data": function(d){
                    return $.extend({},d,{
                        'date':$("#visit_date").val()
                    });
                }
            },
            "columns": [
                { "data": "visit_mode" },
                { "data": "client_name" },
                { "data": "visit_date" },
                { "data": "visit_type" },
                { "data": "opportunity" },
                { "data": "visit_notes" },
                { "data": "created_by_emp" },
            ]
        });

        $("#visit_date").datepicker({
            format		:	"yyyy-mm-dd",
            autoclose	:	true,
            todayBtn	:	"linked",
            clearBtn	:	true,
            // endDate		: 	moment().format("YYYY-MM-DD"),
            // maxViewMode : 	2
            orientation: "bottom left"
        }).on('change.dp',function(e){
            
            // console.log('Date Changed');
            oTable.draw();
            
        });

        $("#date_decrease").click(function(e){
            
            var cur_date = $("#visit_date").val();
            
            // console.log("Decrease Date",cur_date);
            
            if(cur_date){
                
                var cur_date_moment = moment(cur_date);

                // console.log("isValid? ",cur_date_moment.isValid());
                
                if(cur_date_moment.isValid()){
                    cur_date_moment.subtract(1,'days');
                    // console.log("Changed Date : ",cur_date_moment.format("YYYY-MM-DD"));
                    $("#visit_date").datepicker('update', cur_date_moment.format("YYYY-MM-DD"));
                }else{

                }                
            }
        });

        $("#date_increase").click(function(e){

            var cur_date = $("#visit_date").val();
            
            // console.log("Increase Date",cur_date);
            
            if(cur_date){
                
                var cur_date_moment = moment(cur_date);

                // console.log("isValid? ",cur_date_moment.isValid());
                
                if(cur_date_moment.isValid()){
                    cur_date_moment.add(1,'days');
                    // console.log("Changed Date : ",cur_date_moment.format("YYYY-MM-DD"));
                    $("#visit_date").datepicker('update', cur_date_moment.format("YYYY-MM-DD"));
                }else{

                }                
            }
        });

</script>
@endscript