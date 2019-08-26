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
				<li class="department_li">
					<a href="<?php echo $this->baseUrl; ?>departments">
						<i class="menu-icon fa fa-caret-right"></i>
						Departments
					</a>

					<b class="arrow"></b>
				</li>
				<li class="plant_li">
					<a href="<?php echo $this->baseUrl; ?>plants">
						<i class="menu-icon fa fa-caret-right"></i>
						Plants
					</a>

					<b class="arrow"></b>
				</li>
				<li class="equipment_type_li">
					<a href="<?php echo $this->baseUrl; ?>equipment_types">
						<i class="menu-icon fa fa-caret-right"></i>
						Equipment Types
					</a>

					<b class="arrow"></b>
				</li>
				<li class="equipment_li">
					<a href="<?php echo $this->baseUrl; ?>equipments">
						<i class="menu-icon fa fa-caret-right"></i>
						Equipments
					</a>

					<b class="arrow"></b>
				</li>
				<li class="equipment_tag_li">
					<a href="<?php echo $this->baseUrl; ?>equipment_tags">
						<i class="menu-icon fa fa-caret-right"></i>
						Equipment Tags
					</a>

					<b class="arrow"></b>
				</li>
				<li class="">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-caret-right"></i>

						Imports
						<b class="arrow fa fa-angle-down"></b>
					</a>

					<b class="arrow"></b>

					<ul class="submenu">
						<li class="equipment_tags_import_li">
							<a href="<?php echo $this->baseUrl; ?>imports/import_equipment_tags">
								<i class="menu-icon fa fa-leaf green"></i>
								Equipment Tags
							</a>

							<b class="arrow"></b>
						</li>

						<li class="equipment_import_li">
							<a href="<?php echo $this->baseUrl; ?>imports/import_equipments">
								<i class="menu-icon fa fa-leaf green"></i>
								Equipments
							</a>

							<b class="arrow"></b>
						</li>
					</ul>
				</li>
			</ul>
		</li>
		<li class="">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-flag-o"></i>
				Reports
				<b class="arrow fa fa-angle-down"></b>
			</a>

			<b class="arrow"></b>

			<ul class="submenu">
				<li class="reports_li">
					<a href="<?php echo $this->baseUrl; ?>reports">
						<i class="menu-icon fa fa-caret-right"></i>
						Maintenance Report
					</a>

					<b class="arrow"></b>
				</li>

				<li class="reports_activity_li">
					<a href="<?php echo $this->baseUrl; ?>reports/routine_activity">
						<i class="menu-icon fa fa-caret-right"></i>
						Routine Activities
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