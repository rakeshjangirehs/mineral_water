<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>leads/index" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
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
                    <form action="<?php echo $this->baseUrl; ?>leads/index/<?php echo $zipcode_group_id; ?>" id="tagFrm" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo $form_title; ?></h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label for="first_name" class="control-label">First Name:</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo (isset($_POST['first_name']))? set_value('first_name') : $group_details['first_name']; ?>"  />
                                            <span class="messages"><?php echo form_error('first_name');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="last_name" class="control-label">Last Name:</label>
                                            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo (isset($_POST['last_name']))? set_value('last_name') : $group_details['last_name']; ?>"  />
                                            <span class="messages"><?php echo form_error('last_name');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="control-label">Email:</label>
                                            <input type="email" name="email" id="email" class="form-control" value="<?php echo (isset($_POST['email']))? set_value('email') : $group_details['email']; ?>" />
                                            <span class="messages"><?php echo form_error('email');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="control-label">Phone:</label>
                                            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo (isset($_POST['phone']))? set_value('phone') : $group_details['phone']; ?>" />
                                            <span class="messages"><?php echo form_error('phone');?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary"><?php echo ($zipcode_group_id) ? "Update" : "Add";?></button>
                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'leads/index'; ?>">Cancel</a>
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
    $(".leads_li").active();

    var zipcodegroup_id = <?php echo ($zipcode_group_id) ? $zipcode_group_id : "null";?>;
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
                { "data": "first_name" },
                { "data": "last_name" },
                { "data": "email" },
                { "data": "phone" },
                {
                    "data": 'action',
                    "orderable" : false,
                    "render": function ( data, type, row, meta ) {
                        return "<a class='' href='<?php echo $this->baseUrl; ?>leads/index/"+row.id+"' title='Edit Lead'><i class='feather icon-edit'></i></a>"+
                            "<a class='text-danger' id='delete_vehicle' href='<?php echo $this->baseUrl; ?>leads/delete/"+row.id+"' title='Delete Lead'><i class='feather icon-trash-2'></i></a>";
                    }
                }
            ],
            "createdRow": function ( row, data, index ) {
                if(zipcodegroup_id == data.id){
                    $(row).addClass('active_row');
                }
            }
        }).on('click','#delete_vehicle',function(e){
            e.preventDefault();

            var url = this.getAttribute('href');

            swal(
                {
                    title: "Delete Lead ?",
                    text: "You will not be able to recover this lead!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No"
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = url;
                    }
                }
            );
        });
</script>
@endscript