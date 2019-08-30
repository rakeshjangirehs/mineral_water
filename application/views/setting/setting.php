<!-- Page body start -->
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <!-- Nav tabs -->
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($_GET['q']) && $_GET['q'] == 'system_setting') ? 'active': ''; ?>" href="<?php echo $this->baseUrl; ?>settings?q=system_setting" role="tab">System Setting</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($_GET['q']) && $_GET['q'] == 'logo') ? 'active': ''; ?>" href="<?php echo $this->baseUrl; ?>settings?q=logo" role="tab">Upload Logo</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($_GET['q']) && $_GET['q'] == 'smtp') ? 'active': ''; ?>" href="<?php echo $this->baseUrl; ?>settings?q=smtp" role="tab">SMTP Setup</a>
                            <div class="slide"></div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Tab panes -->
                            <div class="tab-content card-block">
                                <div class="tab-pane <?php echo (isset($_GET['q']) && $_GET['q'] == 'system_setting') ? 'active': ''; ?>">
                                    <form class="form-horizontal" method="post" action="<?php echo $this->baseUrl; ?>settings">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">System Name</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="system_name">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane <?php echo (isset($_GET['q']) && $_GET['q'] == 'logo') ? 'active': ''; ?>" role="tabpanel">
                                    <p class="m-0">2.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                </div>
                                <div class="tab-pane <?php echo (isset($_GET['q']) && $_GET['q'] == 'smtp') ? 'active': ''; ?>" role="tabpanel">
                                    <form class="form-horizontal" method="post" action="<?php echo $this->baseUrl; ?>settings?q=smtp">
                                        <div class="card">
                                            <div class="card-block">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label" for="smtp_host">SMTP Host</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="smtp_host" id="smtp_host" value="<?php echo $smtp['email_host']; ?>">
                                                        <span class="messages"><?php echo form_error('smtp_host');?></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label" for="username">SMTP User</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="username" id="username" value="<?php echo $smtp['username']; ?>">
                                                        <span class="messages"><?php echo form_error('username');?></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label" for="password">SMTP Password</label>
                                                    <div class="col-sm-6">
                                                        <input type="password" class="form-control" name="password" id="password" value="<?php echo $smtp['password']; ?>">
                                                        <span class="messages"><?php echo form_error('password');?></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label" for="from_name">SMTP Person Name</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="from_name" id="from_name" value="<?php echo $smtp['from_name']; ?>">
                                                        <span class="messages"><?php echo form_error('from_name');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                                    <a class="btn btn-sm btn-default" href="<?php echo $this->baseUrl; ?>products/">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>   
                        </div>                        
                    </div> 
                </div>  
            </div>
        </div>
    </div>
</div>
<!-- Page body end -->

@script
<script type="text/javascript">
    $(".setting_li").active();
</script>
@endscript
