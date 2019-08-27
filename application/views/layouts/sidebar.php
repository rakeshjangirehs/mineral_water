<div id="sidebar" class="sidebar responsive ace-save-state">
	<script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>

	<!--<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button class="btn btn-success">
				<i class="ace-icon fa fa-signal"></i>
			</button>

			<button class="btn btn-info">
				<i class="ace-icon fa fa-pencil"></i>
			</button>

			<button class="btn btn-warning">
				<i class="ace-icon fa fa-users"></i>
			</button>

			<button class="btn btn-danger">
				<i class="ace-icon fa fa-cogs"></i>
			</button>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>

			<span class="btn btn-info"></span>

			<span class="btn btn-warning"></span>

			<span class="btn btn-danger"></span>
		</div>
	</div>--><!-- /.sidebar-shortcuts -->

	<ul class="nav nav-list">
		<li class="">
			<a href="<?php echo $this->baseUrl; ?>">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> Dashboard </span>
			</a>

			<b class="arrow"></b>
		</li>
		<li class="">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-users"></i>
				<span class="menu-text">
					User Management
				</span>

				<b class="arrow fa fa-angle-down"></b>
			</a>
			<b class="arrow"></b>
			<ul class="submenu">
				<li class="add_user_li">
					<a href="<?php echo $this->baseUrl; ?>users/add_update">
						<i class="menu-icon fa fa-caret-right"></i>
						Add
					</a>

					<b class="arrow"></b>
				</li>
				<li class="user_list_li">
					<a href="<?php echo $this->baseUrl; ?>users">
						<i class="menu-icon fa fa-caret-right"></i>
						List
					</a>

					<b class="arrow"></b>
				</li>
			</ul>
		</li>

        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-user"></i>
                <span class="menu-text">
					Client Management
				</span>

                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="add_client_li">
                    <a href="<?php echo $this->baseUrl; ?>clients/add_update">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add
                    </a>

                    <b class="arrow"></b>
                </li>
                <li class="cilent_list_li">
                    <a href="<?php echo $this->baseUrl; ?>clients">
                        <i class="menu-icon fa fa-caret-right"></i>
                        List
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

		<li class="">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-sitemap"></i>
				<span class="menu-text">
					Masters
				</span>

				<b class="arrow fa fa-angle-down"></b>
			</a>

			<b class="arrow"></b>

			<ul class="submenu">
				<li class="zipcode_li">
					<a href="<?php echo $this->baseUrl; ?>zipcodes">
						<i class="menu-icon fa fa-caret-right"></i>
						Zipcodes
					</a>

					<b class="arrow"></b>
				</li>

                <li class="zipcodegroup_li">
                    <a href="<?php echo $this->baseUrl; ?>zipcodegroups">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Zip Code Groups
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="vehicle_li">
                    <a href="<?php echo $this->baseUrl; ?>vehicles">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Vehicles
                    </a>

                    <b class="arrow"></b>
                </li>

				<li class="product_li">
					<a href="<?php echo $this->baseUrl; ?>products/add_update">
						<i class="menu-icon fa fa-caret-right"></i>
						Products
					</a>

					<b class="arrow"></b>
				</li>
			</ul>
		</li>
	</ul><!-- /.nav-list -->

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>
</div>