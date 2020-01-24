<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-01-24 16:57:41 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'IS NULL' at line 4 - Invalid query: SELECT
							count(*) as `total_pending_orders`
						FROM orders
						delivery_id IS NULL
ERROR - 2020-01-24 16:57:41 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'IS NULL' at line 4 - Invalid query: SELECT
							count(*) as `total_pending_orders`
						FROM orders
						delivery_id IS NULL
ERROR - 2020-01-24 16:58:01 --> Severity: Notice --> Array to string conversion E:\XAMPP\htdocs\mineral_water\application\views\dashboard.php 64
ERROR - 2020-01-24 16:58:01 --> Severity: Notice --> Array to string conversion E:\XAMPP\htdocs\mineral_water\application\views\dashboard.php 64
ERROR - 2020-01-24 17:00:15 --> Query error: Unknown column 'actual_delivey_datetime' in 'where clause' - Invalid query: SELECT
												count(*) as `total_on_the_way_orders`
											FROM `orders`
											WHERE `delivery_id` IS NULL AND `actual_delivey_datetime` IS NULL
ERROR - 2020-01-24 17:00:15 --> Query error: Unknown column 'actual_delivey_datetime' in 'where clause' - Invalid query: SELECT
												count(*) as `total_on_the_way_orders`
											FROM `orders`
											WHERE `delivery_id` IS NULL AND `actual_delivey_datetime` IS NULL
ERROR - 2020-01-24 17:37:35 --> Severity: Notice --> Undefined index: total_pending_leads E:\XAMPP\htdocs\mineral_water\application\controllers\Dashboard.php 29
ERROR - 2020-01-24 17:37:36 --> Severity: Notice --> Undefined index: total_pending_leads E:\XAMPP\htdocs\mineral_water\application\controllers\Dashboard.php 29
ERROR - 2020-01-24 17:54:01 --> 404 Page Not Found: Orders/ontheway
ERROR - 2020-01-24 17:54:01 --> 404 Page Not Found: Orders/ontheway
