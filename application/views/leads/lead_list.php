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
                                        <th>Company</th>
                                        <th>Contact Person</th>
                                        <th>Email</th>
                                        <th>Phone 1</th>
                                        <th>Phone 2</th>
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
                                            <label for="company_name" class="control-label">Company Name:</label>
                                            <input type="text" name="company_name" id="company_name" class="form-control" value="<?php echo (isset($_POST['company_name']))? set_value('company_name') : $group_details['company_name']; ?>"  />
                                            <span class="messages"><?php echo form_error('company_name');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_person_name" class="control-label">Contact Person Name:</label>
                                            <input type="text" name="contact_person_name" id="contact_person_name" class="form-control" value="<?php echo (isset($_POST['contact_person_name']))? set_value('contact_person_name') : $group_details['contact_person_name']; ?>"  />
                                            <span class="messages"><?php echo form_error('contact_person_name');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="control-label">Email:</label>
                                            <input type="text" name="email" id="email" class="form-control" value="<?php echo (isset($_POST['email']))? set_value('email') : $group_details['email']; ?>" />
                                            <span class="messages"><?php echo form_error('email');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_1" class="control-label">Phone 1:</label>
                                            <input type="text" name="phone_1" id="phone_1" class="form-control" value="<?php echo (isset($_POST['phone_1']))? set_value('phone_1') : $group_details['phone_1']; ?>" />
                                            <span class="messages"><?php echo form_error('phone_1');?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_2" class="control-label">Phone 2:</label>
                                            <input type="text" name="phone_2" id="phone_2" class="form-control" value="<?php echo (isset($_POST['phone_2']))? set_value('phone_2') : $group_details['phone_2']; ?>" />
                                            <span class="messages"><?php echo form_error('phone_2');?></span>
                                        </div>
                                        <?php if($zipcode_group_id):?>
                                            <div class="form-group">
                                                <label for="phone_2" class="control-label">Converted to Client:
                                                <?php echo ($group_details['is_converted']) ? "<span class='pcoded-badge label label-success'>Yes</span>" : "<span class='pcoded-badge label label-warning'>No</span>";?>
                                                </label>
                                            </div>
                                        <?php endif;?>
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

    var validator = $("#tagFrm").validate({
        rules   : 	{
                        "company_name"		:	{
                            required:true,
                            maxlength: 200,
                        },
                        "contact_person_name":	{
                            required:true,
                            maxlength: 200,
                        },
                        "phone_1"		:	{
                            required:true,
                            maxlength: 12,
                            minlength: 6,
                            remote:	function(){
                                return "<?php echo $this->baseUrl.'zipcodes/check_unique_ajax'; ?>?table=leads&fieldsToCompare=phone_1,phone_2&fieldName=phone_1&id=<?php echo $zipcode_group_id;?>"
                            },
                            notEqual:"#phone_2"
                        },
                        "email"		:	{
                            maxlength: 200,
                            email: true,
                            remote:	function(){
                                return "<?php echo $this->baseUrl.'zipcodes/check_unique_ajax'; ?>?table=leads&fieldsToCompare=email&fieldName=email&id=<?php echo $zipcode_group_id;?>"
                            },                            
                        },
                        "phone_2"		:	{
                            maxlength: 12,
                            minlength: 6,
                            remote:	function(){
                                return "<?php echo $this->baseUrl.'zipcodes/check_unique_ajax'; ?>?table=leads&fieldsToCompare=phone_1,phone_2&fieldName=phone_2&id=<?php echo $zipcode_group_id;?>"
                            },
                            notEqual:"#phone_1"
                        },
                    },
        messages	:	{
            phone_1		:	{
                remote			:	"Phone 1 already Exists",
                notEqual		:	"Phone 1 and Phone 2 must be different",
            },
            phone_2		:	{
                remote			:	"Phone 2 already Exists",
                notEqual		:	"Phone 1 and Phone 2 must be different",
            },
            email		:	{
                remote			:	"Email already Exists"
            },
        },
        errorElement: "p",
        errorClass:"text-danger error",
        errorPlacement: function ( error, element ) {
            $(element).closest(".form-group").append(error);
        },
    });

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
                { "data": "company_name" },
                { "data": "contact_person_name" },
                { "data": "email" },
                { "data": "phone_1" },
                { "data": "phone_2" },
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