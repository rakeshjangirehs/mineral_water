<style>
    .text-white{
        width: 213px;
    }
    .card-footer .text-white{
        text-align: right;
    }
    .col-4.text-right{
        height: 30px;
    }
    .col-4.text-right i{
        font-size: 30px;
    }
 </style>
 <div class="page-body">
    <div class="row">
        <!-- task, page, download counter  start -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-yellow update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white"><?php echo $total_clients;?></h4>
                            <h6 class="text-white m-b-0">Clients</h6>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <canvas id="update-chart-1" height="50"></canvas> -->
                            <i class="feather icon-user-check"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p> -->
                    <p class="text-white m-b-0"><a href="<?php echo $this->baseUrl; ?>clients" class="text-white">View Client List</a></p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-green update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white"><?php echo $total_pending_leads;?></h4>
                            <h6 class="text-white m-b-0">Prospective Customer</h6>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <canvas id="update-chart-2" height="50"></canvas> -->
                            <i class="feather icon-zap"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p> -->
                    <p class="text-white m-b-0"><a href="<?php echo $this->baseUrl; ?>leads" class="text-white">View Leads</a></p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-lite-green update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white"><?php echo $total_pending_orders;?></h4>
                            <h6 class="text-white m-b-0">Orders Pending</h6>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <canvas id="update-chart-4" height="50"></canvas> -->
                            <i class="feather icon-shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p> -->
                    <p class="text-white m-b-0"><a href="<?php echo $this->baseUrl; ?>orders" class="text-white">View Orders</a></p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-pink update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white"><?php echo $total_on_the_way_orders;?></h4>
                            <h6 class="text-white m-b-0">Out for Delivery</h6>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <canvas id="update-chart-3" height="50"></canvas> -->
                            <i class="fa fa-truck"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p> -->
                    <p class="text-white m-b-0"><a href="<?php echo $this->baseUrl; ?>delivery" class="text-white">View Delivery</a></p>
                </div>
            </div>
        </div>        
        <!-- task, page, download counter  end -->
    </div>
</div>

@script
<script type="text/javascript">
    // to active the sidebar
    $('.dashboard_li').active();
</script>
@endscript
