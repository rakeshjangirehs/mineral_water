<?php if($this->session->flashdata('message')) : ?>
    <div class="row align-items-end m-t-20">
        <div class="col-sm-12">
            <div class="alert alert-success background-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top: 2px;">
                    <i class="feather icon-x text-white"></i>
                </button>
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('success')) : ?>
    <div class="row align-items-end m-t-20">
        <div class="col-sm-12">
            <div class="alert alert-success background-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top: 2px;">
                    <i class="feather icon-x text-white"></i>
                </button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('error')) : ?>
    <div class="row align-items-end m-t-20">
        <div class="col-sm-12">
            <div class="alert alert-warning background-warning">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top: 2px;">
                    <i class="feather icon-x text-white"></i>
                </button>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div id="inactivity_logout" style="display:none;">
    <div class="row align-items-end m-t-20">
        <div class="col-sm-12">
            <div class="alert alert-block alert-warning background-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top: 2px;">
                    <i class="feather icon-x text-white"></i>
                </button>
                You are logout after <span id="timers"></span>
            </div>
        </div>
    </div>
</div>
