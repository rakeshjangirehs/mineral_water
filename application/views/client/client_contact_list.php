<style>
    .editing_contact{
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
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
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
                                $class= ($contact['id'] == $contact_id) ? "editing_contact" : '';
                                echo "<tr class='{$class}'>
                                            <td>{$contact['person_name']}</td>
                                            <td>{$contact['phone']}</td>
                                            <td>{$contact['is_primary']}</td>
                                            <td><a class='orange' href='{$this->baseUrl}clients/contacts/{$contact['client_id']}/{$contact['id']}' title='Edit Client Contact'><i class='ace-icon fa fa-pencil-square bigger-130'></i></a></td>
                                        </tr>";
                            }
                        }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <form action="<?php echo $this->baseUrl; ?>clients/contacts/<?php echo $client_id; ?>/<?php echo $contact_id; ?>" id="tagFrm" method="post">
            <div class="panel-group">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php echo $form_title; ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
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
                    <div class="panel-footer">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary"><?php echo ($contact_id) ? "Update" : "Add";?></button>
                            <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl.'clients/contacts/'.$client_id; ?>">Cancel</a>
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
    $('.nav .nav-list').activeSidebar('.add_client_li');
</script>
@endscript