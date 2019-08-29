<style>

</style>

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover" style="width:100%;">
                                    <thead>
                                    <tr>
                                        <th>Contact Person Name</th>
                                        <th>Contact No</th>
                                        <th>Is Primary</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($client_contacts){
                                        foreach($client_contacts as $contact){
                                            $class= ($contact['id'] == $contact_id) ? "active_row" : '';
                                            echo "<tr class='{$class}'>
                                            <td>{$contact['person_name']}</td>
                                            <td>{$contact['phone']}</td>
                                            <td>{$contact['is_primary']}</td>
                                            <td><a class='' href='{$this->baseUrl}clients/contacts/{$contact['client_id']}/{$contact['id']}' title='Edit Client Contact'><i class='feather icon-edit'></i></a></td>
                                        </tr>";
                                        }
                                    }?>
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
                    <form action="<?php echo $this->baseUrl; ?>clients/contacts/<?php echo $client_id; ?>/<?php echo $contact_id; ?>" id="tagFrm" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo $form_title; ?></h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label for="equipment_id">Contact Person:</label>
                                            <input type="text" name="person_name" id="person_name" class="form-control" value="<?php echo $current_contact['person_name']; ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="equipment_id">Contact No.:</label>
                                            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $current_contact['phone']; ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input name="is_primary" type="checkbox" class="ace" value="Yes" <?php echo ($current_contact['is_primary']=='Yes') ? 'checked' : '';?>>
                                                <span class="lbl"> Set as Primary Contact</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary"><?php echo ($contact_id) ? "Update" : "Add";?></button>
                                    <?php if($contact_id):?>
                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'clients/contacts/'.$client_id; ?>">Cancel</a>
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
    $(".add_cilent_li").active();
</script>
@endscript