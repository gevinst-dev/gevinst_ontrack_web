<?php
class Database {

	function create_database($data)
	{
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');
		if(mysqli_connect_errno())
			return false;
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);
		$mysqli->close();
		return true;
	}

	function create_tables($data)
	{
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
		if(mysqli_connect_errno())
			return false;
		$query = file_get_contents('assets/database.sql');
		$mysqli->multi_query($query);

        $mysqli->close();


        sleep(5);

        $mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);

        $email = $data['email'];
        $password = password_hash($data['admin_password'], PASSWORD_BCRYPT);



        $staff_query = "INSERT INTO `core_staff` (`id`, `role_id`, `language_id`, `ticket_notif`, `status`, `email`, `name`, `body_class`, `d_finance_overview`, `d_monthly_financials`, `d_assets_category`, `d_assets_status`, `d_license_category`, `d_license_status`, `d_recent_assets`, `d_recent_licenses`, `d_recent_projects`, `d_assigned_tickets`, `d_assigned_issues`, `d_upcoming_reminders`, `d_upcoming_events`, `d_sent_proposals`, `d_exchange_rates`, `password`, `password_reset_key`, `calendars`, `color`, `created_at`, `updated_at`) VALUES
        (1, 1, 1, 1, 'Active', '".$email."', 'Admin', 'day', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '".$password."', '', 'a:2:{i:0;i:0;i:1;s:1:\"1\";}', 'cccccc', '2018-11-01 00:00:00', '2022-08-27 21:19:51');
        ";

        $mysqli->multi_query($staff_query);


		$mysqli->close();
		

		return true;
	}
}
