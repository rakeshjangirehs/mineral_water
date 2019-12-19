<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-19 18:36:55 --> Query error: Column 'is_deleted' in where clause is ambiguous - Invalid query: SELECT 
					`leads`.*,(CASE WHEN `is_converted`=1 THEN 'Yes' ELSE 'No' END) AS `conversion_status`,CONCAT(users.first_name,IFNULL(users.last_name,'')) AS created_by_emp
				FROM `leads`				
				 left JOIN users ON users.id = leads.created_by
		 WHERE 1=1  AND is_deleted = 0 
ERROR - 2019-12-19 18:37:18 --> Query error: Column 'is_deleted' in where clause is ambiguous - Invalid query: SELECT 
					`leads`.*,(CASE WHEN `is_converted`=1 THEN 'Yes' ELSE 'No' END) AS `conversion_status`,CONCAT(users.first_name,IFNULL(users.last_name,'')) AS created_by_emp
				FROM `leads`				
				 left JOIN users ON users.id = leads.created_by
		 WHERE 1=1  AND is_deleted = 0 
ERROR - 2019-12-19 18:37:25 --> Query error: Column 'is_deleted' in where clause is ambiguous - Invalid query: SELECT 
					`leads`.*,(CASE WHEN `is_converted`=1 THEN 'Yes' ELSE 'No' END) AS `conversion_status`,CONCAT(users.first_name,IFNULL(users.last_name,'')) AS created_by_emp
				FROM `leads`				
				 left JOIN users ON users.id = leads.created_by
		 WHERE 1=1  AND is_deleted = 0 
ERROR - 2019-12-19 18:40:08 --> Query error: Column 'email' in where clause is ambiguous - Invalid query: SELECT 
					`leads`.*,(CASE WHEN `is_converted`=1 THEN 'Yes' ELSE 'No' END) AS `conversion_status`,CONCAT(users.first_name,IFNULL(users.last_name,'')) AS created_by_emp
				FROM `leads`				
				 left JOIN users ON users.id = leads.created_by
		 WHERE 1=1  AND leads.is_deleted = 0 AND ( company_name LIKE '%r%' OR contact_person_name LIKE '%r%' OR email LIKE '%r%' OR phone_1 LIKE '%r%' OR (CASE WHEN `is_converted`=1 THEN 'Yes' ELSE 'No' END) LIKE '%r%' OR CONCAT(users.first_name,IFNULL(users.last_name,'')) LIKE '%r%'  ) ORDER BY CONCAT(users.first_name,IFNULL(users.last_name,'')) desc
ERROR - 2019-12-19 18:40:15 --> Query error: Column 'email' in where clause is ambiguous - Invalid query: SELECT 
					`leads`.*,(CASE WHEN `is_converted`=1 THEN 'Yes' ELSE 'No' END) AS `conversion_status`,CONCAT(users.first_name,IFNULL(users.last_name,'')) AS created_by_emp
				FROM `leads`				
				 left JOIN users ON users.id = leads.created_by
		 WHERE 1=1  AND leads.is_deleted = 0 AND ( company_name LIKE '%rs%' OR contact_person_name LIKE '%rs%' OR email LIKE '%rs%' OR phone_1 LIKE '%rs%' OR (CASE WHEN `is_converted`=1 THEN 'Yes' ELSE 'No' END) LIKE '%rs%' OR CONCAT(users.first_name,IFNULL(users.last_name,'')) LIKE '%rs%'  ) ORDER BY CONCAT(users.first_name,IFNULL(users.last_name,'')) desc
ERROR - 2019-12-19 18:40:48 --> Query error: Unknown column 'leads.is_converted' in 'where clause' - Invalid query: SELECT 
					`leads`.*,(CASE WHEN `is_converted`=1 THEN 'Yes' ELSE 'No' END) AS `conversion_status`,CONCAT(users.first_name,IFNULL(users.last_name,'')) AS created_by_emp
				FROM `leads`				
				 left JOIN users ON users.id = leads.created_by
		 WHERE 1=1  AND leads.is_deleted = 0 AND ( leads.company_name LIKE '%r%' OR leads.contact_person_name LIKE '%r%' OR leads.email LIKE '%r%' OR leads.phone_1 LIKE '%r%' OR (CASE WHEN `leads.is_converted`=1 THEN 'Yes' ELSE 'No' END) LIKE '%r%' OR CONCAT(users.first_name,IFNULL(users.last_name,'')) LIKE '%r%'  ) ORDER BY leads.company_name asc
