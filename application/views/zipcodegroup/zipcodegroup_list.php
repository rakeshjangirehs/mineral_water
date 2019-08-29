<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>zipcodegroups/index" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>ZIP Code Group</th>
                                        <th>ZIP Codes</th>
                                        <th>Action</th>
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
    <div class="col-sm-12 col-md-4">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <form action="<?php echo $this->baseUrl; ?>zipcodegroups/index/<?php echo $zipcode_group_id; ?>" id="tagFrm" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo $form_title; ?></h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label for="equipment_id">Group Name:</label>
                                            <input type="text" name="group_name" id="group_name" class="form-control" value="<?php echo $group_details['group_name']; ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="role">Zip Codes:</label>
                                            <select class="form-control" name="zip_code[]" id="zip_code" multiple="multiple">
                                                <option value="">Choose ZIP Codes</option>
                                                <?php
                                                if(!empty($all_zipcodes)):
                                                    foreach($all_zipcodes as $zip_codes_id=>$zip_code):
                                                        $selected = (in_array($zip_codes_id,$group_zip_codes)) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $zip_codes_id; ?>" <?php echo $selected; ?>><?php echo $zip_code; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary"><?php echo ($zipcode_group_id) ? "Update" : "Add";?></button>
                                    <?php if($zipcode_group_id):?>
                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'zipcodegroups/index'; ?>">Cancel</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    // to active the sidebar
    // $('.nav .nav-list').activeSidebar('.zipcodegroup_li');
    $(".zipcodegroup_li").active();

    var zipcodegroup_id = <?php echo ($zipcode_group_id) ? $zipcode_group_id : "null";?>;
    var table = $("#dynamic-table");
    var imgUrl = table.attr('data-imageUrl');
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
                { "data": "group_name" },
                { "data": "zip_codes" },
                {
                    "data": 'link',
                    "orderable" : false,
                    "render": function ( data, type, row, meta ) {
                        return "<a class='' href='<?php echo $this->baseUrl; ?>zipcodegroups/index/"+data.id+"' title='Edit Zip Code Group'><i class='feather icon-edit'></i></a>";
                    }
                }
            ],
            "createdRow": function ( row, data, index ) {
                if(zipcodegroup_id == data.id){
                    $(row).addClass('active_row');
                }
            }
        });
</script>
@endscript