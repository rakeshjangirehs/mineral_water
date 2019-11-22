<style>
    .hidden-fs{
        display: none;
    }

</style>
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-12">
                <div id="wizard2">
                    <section>
                        <div class="wizard-form wizard clearfix vertical" role="application">
                            <div class="steps clearfix">
                                <ul role="tablist">
                                    <li role="tab" class="first disabled <?php echo ($mode == 'system_setting') ? 'current': ''; ?>" aria-disabled="false" aria-selected="true">
                                        <a id="verticle-wizard-t-0" href="<?php echo $this->baseUrl; ?>settings/index/system_setting" aria-controls="verticle-wizard-p-0">
                                            System Settings
                                        </a>
                                    </li>
                                    <li role="tab" class="disabled <?php echo ($mode == 'logo') ? 'current': ''; ?>" aria-disabled="true" style="display:none;">
                                        <a id="verticle-wizard-t-1" href="<?php echo $this->baseUrl; ?>settings/index/logo" aria-controls="verticle-wizard-p-1">
                                            Upload Logo
                                        </a>
                                    </li>
                                    <li role="tab" class="disabled <?php echo ($mode == 'smtp') ? 'current': ''; ?>" aria-disabled="true">
                                        <a id="verticle-wizard-t-2" href="<?php echo $this->baseUrl; ?>settings/index/smtp" aria-controls="verticle-wizard-p-2">
                                            SMTP Setup
                                        </a>
                                    </li>
                                    <li role="tab" class="disabled <?php echo ($mode == 'maps') ? 'current': ''; ?>" aria-disabled="true">
                                        <a id="verticle-wizard-t-2" href="<?php echo $this->baseUrl; ?>settings/index/maps" aria-controls="verticle-wizard-p-2">
                                            Maps Setting
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="content clearfix">
                                <fieldset id="verticle-wizard-p-0" role="tabpanel" aria-labelledby="verticle-wizard-h-0" class="body <?php echo ($mode == 'system_setting') ? '': 'hidden-fs'; ?>" aria-hidden="false" >
                                    <form class="form-horizontal" method="post" action="<?php echo $this->baseUrl; ?>settings/index/system_setting" class="<?php echo ($mode == 'system_setting') ? 'active': ''; ?>">
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="system_name" class="block">System Name <span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input id="system_name" name="system_name" type="text" class="form-control" value="<?php echo $settings['system_name']; ?>">
                                                <span class="messages"><?php echo form_error('system_name');?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="default_credit_limit" class="block">Default Credit Limit for Client</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input id="default_credit_limit" name="default_credit_limit" type="text" class="form-control" value="<?php echo $settings['default_credit_limit']; ?>">
                                                <span class="messages"><?php echo form_error('default_credit_limit');?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </fieldset>

                                <fieldset id="verticle-wizard-p-1" role="tabpanel" aria-labelledby="verticle-wizard-h-1" class="body <?php echo ($mode == 'logo') ? '': 'hidden-fs'; ?>" aria-hidden="true" >
                                    Implementation Pending
                                </fieldset>

                                <fieldset id="verticle-wizard-p-2" role="tabpanel" aria-labelledby="verticle-wizard-h-2" class="body <?php echo ($mode == 'smtp') ? '': 'hidden-fs'; ?>" aria-hidden="true">
                                    <form class="form-horizontal" method="post" action="<?php echo $this->baseUrl; ?>settings/index/smtp" class="<?php echo ($mode == 'smtp') ? 'active': ''; ?>">

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">SMTP Host</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input id="userName-22" class="form-control" name="smtp_host" id="smtp_host" value="<?php echo $settings['email_host']; ?>">
                                                <span class="messages"><?php echo form_error('smtp_host');?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">SMTP User</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input id="userName-22" class="form-control" name="username" id="username" value="<?php echo $settings['username']; ?>">
                                                <span class="messages"><?php echo form_error('username');?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">SMTP Password</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="password" id="userName-22" class="form-control" name="password" id="password" value="<?php echo $settings['password']; ?>">
                                                <span class="messages"><?php echo form_error('password');?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">SMTP Person Name</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input id="userName-22" class="form-control" name="from_name" id="from_name" value="<?php echo $settings['from_name']; ?>">
                                                <span class="messages"><?php echo form_error('from_name');?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </fieldset>
                                <fieldset id="verticle-wizard-p-2" role="tabpanel" aria-labelledby="verticle-wizard-h-2" class="body <?php echo ($mode == 'maps') ? '': 'hidden-fs'; ?>" aria-hidden="true">
                                    <form class="form-horizontal" method="post" action="<?php echo $this->baseUrl; ?>settings/index/maps" class="<?php echo ($mode == 'maps') ? 'active': ''; ?>">

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">API Key</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input id="userName-22" class="form-control" name="maps_api_key" id="maps_api_key" value="<?php echo $settings['maps_api_key']; ?>">
                                                <span class="messages"><?php echo form_error('maps_api_key');?></span>
                                            </div>
                                        </div>

                                        <div class="form-group row" style="display:none;">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">Node Server URL</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input id="userName-22" class="form-control" name="node_server_url" id="node_server_url" value="<?php echo $settings['node_server_url']; ?>">
                                                <span class="messages"><?php echo form_error('node_server_url');?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </fieldset>
                            </div>
<!--                            <div class="actions clearfix">-->
<!--                                <ul role="menu" aria-label="Pagination">-->
<!--                                    <li aria-hidden="false" aria-disabled="false">-->
<!--                                        <a href="#next" role="menuitem">Submit</a>-->
<!--                                    </li>-->
<!--                                    <li aria-hidden="false" aria-disabled="false">-->
<!--                                        <a href="#next" role="menuitem">Cancel</a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    $(".setting_li").active();
</script>
@endscript
