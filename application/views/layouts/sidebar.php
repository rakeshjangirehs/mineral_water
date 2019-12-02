<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
<!--        <div class="pcoded-navigatio-lavel">Navigation</div>-->

        <ul class="pcoded-item pcoded-left-item">
            <li class="dashboard_li">
                <a href="<?php echo $this->baseUrl; ?>">
                    <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>

            <!--
            <li class="live_location_li">
                <a href="<?php //echo $this->baseUrl; ?>tracking/live_location">
                    <span class="pcoded-micon"><i class="fa fa-truck"></i></span>
                    <span class="pcoded-mtext">Delivery Tracking</span>
                </a>
            </li>
            -->

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-compass"></i></span>
                    <span class="pcoded-mtext">Tracking</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="live_location_li">
                        <a href="<?php echo $this->baseUrl; ?>tracking/live_location">
                            <span class="pcoded-mtext">Live Tracking</span>
                        </a>
                    </li>
                    <li class="tracking_path_li">
                        <a href="<?php echo $this->baseUrl; ?>tracking/tracking_path">
                            <span class="pcoded-mtext">Track Path</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="leads_li">
                <a href="<?php echo $this->baseUrl; ?>leads">
                    <span class="pcoded-micon"><i class="feather icon-zap"></i></span>
                    <span class="pcoded-mtext">Leads</span>
                </a>
            </li>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                    <span class="pcoded-mtext">Masters</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="zipcode_li">
                        <a href="<?php echo $this->baseUrl; ?>zipcodes">
                            <span class="pcoded-mtext">Zipcodes</span>
                        </a>
                    </li>
                    <li class="zipcodegroup_li">
                        <a href="<?php echo $this->baseUrl; ?>zipcodegroups">
                            <span class="pcoded-mtext">Zip Code Groups</span>
                        </a>
                    </li>
                    <li class="vehicle_li">
                        <a href="<?php echo $this->baseUrl; ?>vehicles">
                            <span class="pcoded-mtext">Vehicles</span>
                        </a>
                    </li>
                    <li class="brands_li">
                        <a href="<?php echo $this->baseUrl; ?>brands">
                            <span class="pcoded-mtext">Brands</span>
                        </a>
                    </li>
                    <li class="warehouses_li">
                        <a href="<?php echo $this->baseUrl; ?>warehouses">
                            <span class="pcoded-mtext">Warehouse</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">User Management</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="add_user_li">
                        <a href="<?php echo $this->baseUrl; ?>users/add_update">
                            <span class="pcoded-mtext">Add User</span>
                        </a>
                    </li>
                    <li class="user_list_li">
                        <a href="<?php echo $this->baseUrl; ?>users">
                            <span class="pcoded-mtext">User List</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-user-check"></i></span>
                    <span class="pcoded-mtext">Client Management</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="add_cilent_li">
                        <a href="<?php echo $this->baseUrl; ?>clients/add_update">
                            <span class="pcoded-mtext">Add Client</span>
                        </a>
                    </li>
                    <li class="cilent_list_li">
                        <a href="<?php echo $this->baseUrl; ?>clients">
                            <span class="pcoded-mtext">Client List</span>
                        </a>
                    </li>
                    <li class="clientcategory_li">
                        <a href="<?php echo $this->baseUrl; ?>clientcategory">
                            <span class="pcoded-mtext">Client Category</span>
                        </a>
                    </li>
                    <!--<li class="payments_list_li">
                        <a href="<?php echo $this->baseUrl; ?>payments">
                            <span class="pcoded-mtext">Post Payment</span>
                        </a>
                    </li>-->
                </ul>
            </li>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-package"></i></span>
                    <span class="pcoded-mtext">Product Management</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="add_product_li">
                        <a href="<?php echo $this->baseUrl; ?>products/add_update">
                            <span class="pcoded-mtext">Add Product</span>
                        </a>
                    </li>
                    <li class="product_list_li">
                        <a href="<?php echo $this->baseUrl; ?>products">
                            <span class="pcoded-mtext">Product List</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                    <span class="pcoded-mtext">Payments</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="payment_list_li">
                        <a href="<?php echo $this->baseUrl; ?>payments/payments_list">
                            <span class="pcoded-mtext">Payment List</span>
                        </a>
                    </li>
                    <li class="cash_collection_li">
                        <a href="<?php echo $this->baseUrl; ?>cashcollection">
                            <span class="pcoded-mtext">Cash Collection</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
                    <span class="pcoded-mtext">Orders</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="order_list_li">
                        <a href="<?php echo $this->baseUrl; ?>orders">
                            <span class="pcoded-mtext">Order List</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-truck"></i></span>
                    <span class="pcoded-mtext">Delivery</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="add_update_delivery_li">
                        <a href="<?php echo $this->baseUrl; ?>delivery/add_update">
                            <span class="pcoded-mtext">Create Delivery</span>
                        </a>
                    </li>
                    <li class="delivery_list_li">
                        <a href="<?php echo $this->baseUrl; ?>delivery">
                            <span class="pcoded-mtext">Delivery List</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-gift"></i></span>
                    <span class="pcoded-mtext">Schemes</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="add_update_scheme_li">
                        <a href="<?php echo $this->baseUrl; ?>schemes/add_update">
                            <span class="pcoded-mtext">Create Scheme</span>
                        </a>
                    </li>
                    <li class="scheme_list_li">
                        <a href="<?php echo $this->baseUrl; ?>schemes">
                            <span class="pcoded-mtext">Scheme List</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!--
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-map"></i></span>
                    <span class="pcoded-mtext">Tracking</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="tracking_li">
                        <a href="<?php //echo $this->baseUrl; ?>tracking/live_location">
                            <span class="pcoded-mtext">Live Tracking</span>
                        </a>
                    </li>
                    <li class="tracking_path_li">
                        <a href="<?php //echo $this->baseUrl; ?>tracking/tracking_path">
                            <span class="pcoded-mtext">Tracking Path</span>
                        </a>
                    </li>
                    <li class="add_marker_li">
                        <a href="<?php //echo $this->baseUrl; ?>tracking/add_marker">
                            <span class="pcoded-mtext">Add Marker</span>
                        </a>
                    </li>
                    <li class="set_route_li">
                        <a href="<?php //echo $this->baseUrl; ?>tracking/set_route">
                            <span class="pcoded-mtext">Set Route</span>
                        </a>
                    </li>
                </ul>
            </li>
            -->

            <li class="setting_li">
                <a href="<?php echo $this->baseUrl; ?>settings">
                    <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                    <span class="pcoded-mtext">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
