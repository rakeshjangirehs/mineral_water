<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-11 13:20:20 --> 9166650505 - hi rakesh - Ok|</br>
ERROR - 2019-12-11 13:21:09 --> Severity: Notice --> Undefined variable: msg E:\XAMPP\htdocs\mineral_water\application\libraries\Fcm.php 130
ERROR - 2019-12-11 13:42:36 --> Severity: Notice --> Undefined variable: order_id E:\XAMPP\htdocs\mineral_water\application\controllers\api\Apiv1.php 653
ERROR - 2019-12-11 15:43:19 --> Severity: Notice --> Undefined variable: user E:\XAMPP\htdocs\mineral_water\application\controllers\api\Apiv1.php 723
ERROR - 2019-12-11 15:45:43 --> Severity: error --> Exception: Too few arguments to function ApiV1::logout_get(), 0 passed and exactly 1 expected E:\XAMPP\htdocs\mineral_water\application\controllers\api\Apiv1.php 721
ERROR - 2019-12-11 16:51:09 --> Severity: Notice --> Undefined variable: notifiable_user E:\XAMPP\htdocs\mineral_water\application\models\Delivery_model.php 135
ERROR - 2019-12-11 17:54:28 --> Severity: Notice --> Constant API_ACCESS_KEY already defined E:\XAMPP\htdocs\mineral_water\application\libraries\Fcm.php 31
ERROR - 2019-12-11 17:55:15 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '/a>'), orders.order_status) SEPARATOR '<br/>') AS order_short_info,
           ' at line 7 - Invalid query: SELECT * FROM (SELECT
                            delivery.*,
                            DATE_FORMAT(expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime_f,
                            DATE_FORMAT(actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime_f,
                            warehouses.name as warehouse_name,
                            GROUP_CONCAT(clients.client_name SEPARATOR ',<br/>') AS client_name,
                            GROUP_CONCAT(CONCAT_WS(' - ', CONCAT('<a href=''>,orders.id,'</a>'), orders.order_status) SEPARATOR '<br/>') AS order_short_info,
                            (
                                CASE
                                WHEN sub_delivery_boy.delivery_boy IS NULL
                                    THEN CONCAT('Driver : ', sub_driver.driver)
                                ELSE CONCAT('Delivery Boy : ', sub_delivery_boy.delivery_boy, '<br/>', 'Driver : ', sub_driver.driver)
                                END
                            ) AS deliverying_staff
                        FROM delivery
                        LEFT JOIN warehouses ON warehouses.id = delivery.warehouse
                        LEFT JOIN delivery_config ON delivery_config.delivery_id = delivery.id
                        LEFT JOIN delivery_config_orders ON delivery_config_orders.delivery_config_id = delivery_config.id
                        LEFT JOIN orders ON orders.id = delivery_config_orders.order_id
                        LEFT JOIN clients ON clients.id = orders.client_id
                        LEFT JOIN (
                            SELECT
                                CONCAT_WS(' ', first_name, last_name) as delivery_boy,
                                id
                            FROM users
                            GROUP BY users.id
                        ) AS sub_delivery_boy ON sub_delivery_boy.id = delivery_config.delivery_boy_id
                        LEFT JOIN (
                            SELECT
                                CONCAT_WS(' ', first_name, last_name) as driver,
                                id
                            FROM users
                            GROUP BY users.id
                        ) AS sub_driver ON sub_driver.id = delivery_config.driver_id
                        GROUP BY delivery.id,delivery_config.id) AS `tmp` WHERE 1=1  AND is_deleted = 0 
ERROR - 2019-12-11 18:07:20 --> Severity: error --> Exception: Too few arguments to function Orders::order_details(), 0 passed in E:\XAMPP\htdocs\mineral_water\system\core\CodeIgniter.php on line 532 and exactly 1 expected E:\XAMPP\htdocs\mineral_water\application\controllers\Orders.php 144
ERROR - 2019-12-11 18:08:31 --> Severity: error --> Exception: Too few arguments to function Orders::order_details(), 0 passed in E:\XAMPP\htdocs\mineral_water\system\core\CodeIgniter.php on line 532 and exactly 1 expected E:\XAMPP\htdocs\mineral_water\application\controllers\Orders.php 144
