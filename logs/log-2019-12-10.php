<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-10 12:01:55 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.client_name,
                        clients.contact_person_name_1,
         ' at line 3 - Invalid query: SELECT
                        clients.id AS client_id,d
                        clients.client_name,
                        clients.contact_person_name_1,
                        clients.contact_person_1_phone_1,
                        clients.contact_person_1_email,                        
                        IFNULL(sub_pending.pending,0) AS pending_count,
                        IFNULL(sub_partial.partial,0) AS partial_count,
                        IFNULL(sub_paid.paid,0) AS paid_count
                    FROM clients
                    LEFT JOIN client_delivery_addresses ON client_delivery_addresses.client_id = clients.id
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS pending,
                            client_id,
                            payment_status,
                            orders.created_by
                        FROM orders
                        LEFT JOIN clients on clients.id = orders.client_id
                        WHERE orders.order_status ='Delivered'
                        AND orders.payment_status = 'Pending'
                        AND `orders`.`client_id` IN (
                            SELECT
                                DISTINCT(`orders`.`client_id`) AS `client_id`
                            FROM `delivery_config_orders`
                            left join orders on orders.id = delivery_config_orders.order_id
                            LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                            WHERE `delivery_config`.`delivery_boy_id` = 4 OR `delivery_config`.`driver_id` = 4
                        )
                        GROUP BY client_id
                    ) sub_pending ON sub_pending.client_id = clients.id
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS paid,
                            client_id,
                            payment_status,
                            orders.created_by
                        FROM orders
                        LEFT JOIN clients on clients.id = orders.client_id
                        WHERE orders.order_status ='Delivered'
                        AND orders.payment_status = 'Paid'
                        AND `orders`.`client_id` IN (
                            SELECT
                                DISTINCT(`orders`.`client_id`) AS `client_id`
                            FROM `delivery_config_orders`
                            left join orders on orders.id = delivery_config_orders.order_id
                            LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                            WHERE `delivery_config`.`delivery_boy_id` = 4 OR `delivery_config`.`driver_id` = 4
                        )
                        GROUP BY client_id
                    ) sub_paid ON sub_paid.client_id = clients.id
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS partial,
                            client_id,
                            payment_status,
                            orders.created_by
                        FROM orders
                        LEFT JOIN clients on clients.id = orders.client_id
                        WHERE orders.order_status ='Delivered'
                        AND orders.payment_status = 'Partial'
                        AND `orders`.`client_id` IN (
                            SELECT
                                DISTINCT(`orders`.`client_id`) AS `client_id`
                            FROM `delivery_config_orders`
                            left join orders on orders.id = delivery_config_orders.order_id
                            LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                            WHERE `delivery_config`.`delivery_boy_id` = 4 OR `delivery_config`.`driver_id` = 4
                        )
                        GROUP BY client_id
                    ) sub_partial ON sub_partial.client_id = clients.id
                    GROUP BY clients.id
                    HAVING  ( pending_count > 0 OR partial_count > 0 OR paid_count > 0 )
ERROR - 2019-12-10 14:59:56 --> Severity: Notice --> Undefined variable: payable_amount E:\XAMPP\htdocs\mineral_water\application\views\order\order_print.php 179
ERROR - 2019-12-10 16:52:50 --> Severity: Notice --> Undefined offset: 5 E:\XAMPP\htdocs\mineral_water\application\core\MY_Model.php 155
ERROR - 2019-12-10 16:52:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'desc' at line 50 - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    tbl.pickup_location,
                    tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NOT NULL AND actual_delivey_datetime IS NULL AND ( id LIKE '%f%' OR client_name LIKE '%f%' OR expected_delivery_date LIKE '%f%' OR payable_amount LIKE '%f%' OR effective_price LIKE '%f%'  ) ORDER BY  desc
ERROR - 2019-12-10 16:52:51 --> Severity: Notice --> Undefined offset: 5 E:\XAMPP\htdocs\mineral_water\application\core\MY_Model.php 155
ERROR - 2019-12-10 16:52:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'desc' at line 50 - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    tbl.pickup_location,
                    tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NOT NULL AND actual_delivey_datetime IS NULL AND ( id LIKE '%fg%' OR client_name LIKE '%fg%' OR expected_delivery_date LIKE '%fg%' OR payable_amount LIKE '%fg%' OR effective_price LIKE '%fg%'  ) ORDER BY  desc
ERROR - 2019-12-10 16:52:57 --> Severity: Notice --> Undefined offset: 5 E:\XAMPP\htdocs\mineral_water\application\core\MY_Model.php 155
ERROR - 2019-12-10 16:52:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'desc' at line 50 - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    tbl.pickup_location,
                    tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NOT NULL AND actual_delivey_datetime IS NULL AND ( id LIKE '%f%' OR client_name LIKE '%f%' OR expected_delivery_date LIKE '%f%' OR payable_amount LIKE '%f%' OR effective_price LIKE '%f%'  ) ORDER BY  desc
ERROR - 2019-12-10 17:03:18 --> Query error: Unknown column 'delivery.amount' in 'field list' - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    tbl.pickup_location,
                    tbl.warehouse,
                    tbl.amount AS `delivery_amount`,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        delivery.amount,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NULL 
ERROR - 2019-12-10 17:03:18 --> Query error: Unknown column 'delivery.amount' in 'field list' - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    tbl.pickup_location,
                    tbl.warehouse,
                    tbl.amount AS `delivery_amount`,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        delivery.amount,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NOT NULL AND actual_delivey_datetime IS NULL 
ERROR - 2019-12-10 17:03:18 --> Query error: Unknown column 'delivery.amount' in 'field list' - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    tbl.pickup_location,
                    tbl.warehouse,
                    tbl.amount AS `delivery_amount`,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        delivery.amount,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND actual_delivey_datetime IS NOT NULL 
ERROR - 2019-12-10 17:10:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '(CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE' at line 18 - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NULL 
ERROR - 2019-12-10 17:10:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '(CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE' at line 18 - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NOT NULL AND actual_delivey_datetime IS NULL 
ERROR - 2019-12-10 17:10:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '(CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE' at line 18 - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND actual_delivey_datetime IS NOT NULL 
ERROR - 2019-12-10 17:10:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '(CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE' at line 18 - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NULL 
ERROR - 2019-12-10 17:10:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '(CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE' at line 18 - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND actual_delivey_datetime IS NOT NULL 
ERROR - 2019-12-10 17:10:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '(CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE' at line 18 - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NOT NULL AND actual_delivey_datetime IS NULL 
ERROR - 2019-12-10 17:21:50 --> Query error: Unknown column 'tbl.vehicle_details' in 'field list' - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id                
                #below join                
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NULL 
ERROR - 2019-12-10 17:21:50 --> Query error: Unknown column 'tbl.vehicle_details' in 'field list' - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id                
                #below join                
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NOT NULL AND actual_delivey_datetime IS NULL 
ERROR - 2019-12-10 17:21:50 --> Query error: Unknown column 'tbl.vehicle_details' in 'field list' - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id                
                #below join                
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND actual_delivey_datetime IS NOT NULL 
ERROR - 2019-12-10 17:22:57 --> Query error: Unknown column 'tbl.expected_delivey_datetime' in 'field list' - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    #GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    #GROUP_CONCAT(tbl.driver_details) as drivers,
                    #GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id                
                #below join                
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NULL 
ERROR - 2019-12-10 17:22:57 --> Query error: Unknown column 'tbl.expected_delivey_datetime' in 'field list' - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    #GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    #GROUP_CONCAT(tbl.driver_details) as drivers,
                    #GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id                
                #below join                
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND delivery_id IS NOT NULL AND actual_delivey_datetime IS NULL 
ERROR - 2019-12-10 17:22:57 --> Query error: Unknown column 'tbl.expected_delivey_datetime' in 'field list' - Invalid query: SELECT * FROM (SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    #GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    #GROUP_CONCAT(tbl.driver_details) as drivers,
                    #GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    #tbl.pickup_location,
                    #tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id                
                #below join                
                GROUP BY `orders`.`id`) AS `tmp` WHERE 1=1  AND status = 'Active' AND actual_delivey_datetime IS NOT NULL 
ERROR - 2019-12-10 19:10:30 --> Severity: Notice --> Undefined variable: dt E:\XAMPP\htdocs\mineral_water\application\controllers\api\Apiv1.php 659
ERROR - 2019-12-10 19:10:31 --> Severity: Notice --> Undefined variable: dt E:\XAMPP\htdocs\mineral_water\application\controllers\api\Apiv1.php 661
