<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>

        <ul class="pcoded-item pcoded-left-item">
            <li class="dashboard_li">
                <a href="<?php echo $this->baseUrl; ?>">
                    <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
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
                </ul>
            </li>

            <li class="setting_li">
                <a href="<?php echo $this->baseUrl; ?>settings">
                    <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                    <span class="pcoded-mtext">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
