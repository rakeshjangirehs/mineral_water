<style>
    .editing_zipcodegroup{
        background: #337ab7!important;
        color: #fff!important;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php echo $page_title; ?>
                </div>
                <div class="panel-body">
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>zipcodegroups/index">
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
    <div class="col-xs-12 col-md-4">
        <form action="<?php echo $this->baseUrl; ?>zipcodegroups/index/<?php echo $zipcode_group_id; ?>" id="tagFrm" method="post">
            <div class="panel-group">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php echo $form_title; ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
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
                    <div class="panel-footer">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary"><?php echo ($zipcode_group_id) ? "Update" : "Add";?></button>
                            <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'zipcodegroups/index'; ?>">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@script
<script type="text/javascript">
    // to active the sidebar
    $('.nav .nav-list').activeSidebar('.user_list_li');

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
                        return "<a class='orange' href='<?php echo $this->baseUrl; ?>zipcodegroups/index/"+data.id+"' title='Edit Zip Code Group'><i class='ace-icon fa fa-pencil-square bigger-130'></i></a>";
                    }
                }
            ],
            "createdRow": function ( row, data, index ) {
                if(zipcodegroup_id == data.id){
                    $(row).addClass('editing_zipcodegroup');
                }
            }
        });
</script>
@endscript