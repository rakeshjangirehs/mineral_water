<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-right" style="padding:0px 0px;">
                                <ul class="list-unstyled card-option">
                                    <li><i class="feather icon-maximize full-card"></i></li>
                                    <!--<li title="Export Excel"><a href="<?php //echo $this->baseUrl; ?>zipcodegroups/zip_group_export"><i class="fa fa-file-excel-o"></i></a></li>-->
                                </ul>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl."clients/client_delivery_addresses/".$client_id; ?>" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Address</th>
                                        <th>Coordinates</th>
                                        <th>ZipCode</th>
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
                    <form action="<?php echo $this->baseUrl; ?>clients/client_delivery_addresses/<?php echo $client_id.'/'.$address_id; ?>" id="tagFrm" method="post" autocomplete="off">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo $form_title; ?></h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label for="title" class="control-label">Title:</label>
                                            <input type="text" name="title" id="title" class="form-control" value="<?php echo (isset($_POST['title']))? set_value('title') : $address['title']; ?>"  />
                                            <span class="messages"><?php echo form_error('title');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="control-label">Address:</label>
                                            <input type="text" name="address" id="address" class="form-control" value="<?php echo (isset($_POST['address']))? set_value('address') : $address['address']; ?>"  />
                                            <span class="messages"><?php echo form_error('address');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="zip_code_id" class="control-label">Zip Codes:</label>                                            
                                            <select class="form-control select2" name="zip_code_id" id="zip_code_id" data-placeholder="Choose ZIP Code">
                                                <option value=""></option>
                                                <?php
                                                if(!empty($all_zipcodes)):
                                                    foreach($all_zipcodes as $zip_codes_id=>$zip_code):                                                        
                                                        $selected = ($zip_codes_id==$address['zip_code_id']) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $zip_codes_id; ?>" <?php echo $selected; ?>><?php echo $zip_code; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            <span class="messages"><?php echo form_error('zip_code_id');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="lat" class="control-label">Latitude:</label>
                                            <input type="text" name="lat" id="lat" class="form-control" value="<?php echo (isset($_POST['lat']))? set_value('lat') : $address['lat']; ?>"  />
                                            <span class="messages"><?php echo form_error('lat');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="lng" class="control-label">Longitude:</label>
                                            <input type="text" name="lng" id="lng" class="form-control" value="<?php echo (isset($_POST['lng']))? set_value('lng') : $address['lng']; ?>"  />
                                            <span class="messages"><?php echo form_error('lng');?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary"><?php echo ($address_id) ? "Update" : "Add";?></button>
                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'clients/client_delivery_addresses/'.$client_id; ?>">Cancel</a>
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
    $(".cilent_list_li").active();

    var address_id = <?php echo ($address_id) ? $address_id : "null";?>;
    var table = $("#dynamic-table");
    
    // var validator = $("#tagFrm").validate({
    //     rules   : 	{
    //                     "group_name"		:	{
    //                         required:true,
    //                         maxlength: 200
    //                     },
    //                     "zip_code[]"		:	{
    //                         required:true
    //                     },
    //                 },
    //     errorElement: "p",
    //     errorClass:"text-danger error",
    //     errorPlacement: function ( error, element ) {
    //         $(element).closest(".form-group").append(error);
    //     },
    // });

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
                { "data": "title" },
                { "data": "address" },
                { "data": "coordinates" },
                { "data": "zip_code" },
                {
                    "data": 'link',
                    "orderable" : false,
                    "render": function ( data, type, row, meta ) {
                        return "<a class='' href='<?php echo $this->baseUrl; ?>clients/client_delivery_addresses/"+data.client_id+"/"+data.id+"' title='Edit Address'><i class='feather icon-edit'></i></a>";
                    }
                }
            ],
            "createdRow": function ( row, data, index ) {
                if(address_id == data.id){
                    $(row).addClass('active_row');
                }
            }
        });
</script>
@endscript