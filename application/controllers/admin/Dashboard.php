<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/attribute_model', 'attribute');
        $this->load->model('admin/setting_model', 'setting');
	}



	public function index()
	{
		$data['title'] = __("Dashboard");
		$data['page'] = 'admin/dashboard/index';

        $data['currencies'] = $this->setting->get_currencies();

		$data['clients_count'] = $this->db->count_all('app_clients');
		$data['assets_count'] = $this->db->count_all('app_assets');
		$data['licenses_count'] = $this->db->count_all('app_licenses');
		$data['projects_count'] = $this->db->count_all('app_projects');

		$data['staff'] = $this->staff->get($this->session->staff_id);


		$first_day_last_month = date('Y-m-d', strtotime('first day of last month'));
		$last_day_last_month = date('Y-m-d', strtotime('last day of last month'));

		$first_day_this_month = date('Y-m-d', strtotime('first day of this month'));
		$last_day_this_month = date('Y-m-d', strtotime('last day of this month'));

		$first_day_last_year = date('Y-m-d', strtotime('first day of January last year'));
		$last_day_last_year = date('Y-m-d', strtotime('last day of December last year'));

		$first_day_this_year = date('Y-m-d', strtotime('first day of January this year'));
		$last_day_this_year = date('Y-m-d', strtotime('last day of December this year'));

		$data['last_month_sales'] = sales_between($first_day_last_month, $last_day_last_month, 0);
		$data['this_month_sales'] = sales_between($first_day_this_month, $last_day_this_month, 0);

		$data['last_year_sales'] = sales_between($first_day_last_year, $last_day_last_year, 0);
		$data['this_year_sales'] = sales_between($first_day_this_year, $last_day_this_year, 0);

		if($data['this_month_sales'] == 0) {
			$data['monthly_increase'] = 0;
		} else {
			$data['monthly_increase'] = round((1 - $data['last_month_sales'] / $data['this_month_sales']) * 100, 2);
		}

		if($data['this_year_sales'] == 0) {
			$data['yearly_increase'] = 0;
		} else {
			$data['yearly_increase'] = round((1 - $data['last_year_sales'] / $data['this_year_sales']) * 100, 2);
		}



		$data['last_month_expenses'] = expenses_between($first_day_last_month, $last_day_last_month, 0);
		$data['this_month_expenses'] = expenses_between($first_day_this_month, $last_day_this_month, 0);

		$data['last_year_expenses'] = expenses_between($first_day_last_year, $last_day_last_year, 0);
		$data['this_year_expenses'] = expenses_between($first_day_this_year, $last_day_this_year, 0);

		if($data['this_month_expenses'] == 0) {
			$data['monthly_increase_exp'] = 0;
		} else {
			$data['monthly_increase_exp'] = round((1 - $data['last_month_expenses'] / $data['this_month_expenses']) * 100, 2);
		}

		if($data['this_year_expenses'] == 0) {
			$data['yearly_increase_exp'] = 0;
		} else {
			$data['yearly_increase_exp'] = round((1 - $data['last_year_expenses'] / $data['this_year_expenses']) * 100, 2);
		}



		$data['first_12'] = date('Y-m-d', strtotime('first day of -12 months'));
		$data['last_12'] = date('Y-m-d', strtotime('last day of -12 months'));
		$data['t_12'] = date('M Y', strtotime($data['first_12']));

		$data['first_11'] = date('Y-m-d', strtotime('first day of -11 months'));
		$data['last_11'] = date('Y-m-d', strtotime('last day of -11 months'));
		$data['t_11'] = date('M Y', strtotime($data['first_11']));

		$data['first_10'] = date('Y-m-d', strtotime('first day of -10 months'));
		$data['last_10'] = date('Y-m-d', strtotime('last day of -10 months'));
		$data['t_10'] = date('M Y', strtotime($data['first_10']));

		$data['first_09'] = date('Y-m-d', strtotime('first day of -9 months'));
		$data['last_09'] = date('Y-m-d', strtotime('last day of -9 months'));
		$data['t_09'] = date('M Y', strtotime($data['first_09']));

		$data['first_08'] = date('Y-m-d', strtotime('first day of -8 months'));
		$data['last_08'] = date('Y-m-d', strtotime('last day of -8 months'));
		$data['t_08'] = date('M Y', strtotime($data['first_08']));

		$data['first_07'] = date('Y-m-d', strtotime('first day of -7 months'));
		$data['last_07'] = date('Y-m-d', strtotime('last day of -7 months'));
		$data['t_07'] = date('M Y', strtotime($data['first_07']));

		$data['first_06'] = date('Y-m-d', strtotime('first day of -6 months'));
		$data['last_06'] = date('Y-m-d', strtotime('last day of -6 months'));
		$data['t_06'] = date('M Y', strtotime($data['first_06']));

		$data['first_05'] = date('Y-m-d', strtotime('first day of -5 months'));
		$data['last_05'] = date('Y-m-d', strtotime('last day of -5 months'));
		$data['t_05'] = date('M Y', strtotime($data['first_05']));

		$data['first_04'] = date('Y-m-d', strtotime('first day of -4 months'));
		$data['last_04'] = date('Y-m-d', strtotime('last day of -4 months'));
		$data['t_04'] = date('M Y', strtotime($data['first_04']));

		$data['first_03'] = date('Y-m-d', strtotime('first day of -3 months'));
		$data['last_03'] = date('Y-m-d', strtotime('last day of -3 months'));
		$data['t_03'] = date('M Y', strtotime($data['first_03']));

		$data['first_02'] = date('Y-m-d', strtotime('first day of -2 months'));
		$data['last_02'] = date('Y-m-d', strtotime('last day of -2 months'));
		$data['t_02'] = date('M Y', strtotime($data['first_02']));

		$data['first_01'] = date('Y-m-d', strtotime('first day of -1 months'));
		$data['last_01'] = date('Y-m-d', strtotime('last day of -1 months'));
		$data['t_01'] = date('M Y', strtotime($data['first_01']));

		$data['first_00'] = date('Y-m-d', strtotime('first day of this month'));
		$data['last_00'] = date('Y-m-d', strtotime('last day of this month'));
		$data['t_00'] = date('M Y', strtotime($data['first_00']));


		$data['asset_categories'] = $this->attribute->get_asset_categories();
		$data['license_categories'] = $this->attribute->get_license_categories();
		$data['status_labels'] = $this->attribute->get_status_labels();



		$data['recent_assets'] = $this->db->limit(6)->order_by('id', 'DESC')->get('app_assets')->result_array();
		$data['recent_licenses'] = $this->db->limit(6)->order_by('id', 'DESC')->get('app_licenses')->result_array();
		$data['recent_projects'] = $this->db->limit(6)->order_by('id', 'DESC')->get('app_projects')->result_array();

		$data['assigned_issues'] = $this->db->where('assigned_to', $this->session->staff_id)->where('status', 'To Do')->or_where('status', 'In Progress')->get('app_issues')->result_array();
		$data['assigned_tickets'] = $this->db->where('assigned_to', $this->session->staff_id)->where('status', 'Open')->or_where('status', 'Reopened')->or_where('status', 'In Progress')->get('app_tickets')->result_array();

		$data['upcoming_reminders'] = $this->db->where('assigned_to', $this->session->staff_id)->where('status', 'Upcoming')->get('app_reminders')->result_array();
		$data['sent_proposals'] = $this->db->get_where('app_proposals', array('added_by' => $this->session->staff_id, 'status' => 'Sent'))->result_array();
		$data['upcoming_group_events'] = $this->db->get_where('app_events', array('calendar' => 'Group', 'start_date >=' => date('Y-m-d') . " 00:00:00"))->result_array();
		$data['upcoming_private_events'] = $this->db->get_where('app_events', array('calendar' => 'Private', 'added_by' => $this->session->staff_id, 'start_date >=' => date('Y-m-d') . " 00:00:00"))->result_array();
		$data['upcoming_events'] = array_merge($data['upcoming_group_events'], $data['upcoming_private_events']);
		$data['upcoming_events'] = array_sort_by_column($data['upcoming_events'], 'start_date');



		for ($i = 1; $i <= 12; $i++) {
		    $months[] = date("Y-m%", strtotime( date( 'Y-m-01' )." -$i months"));
		}



		$this->load->view('admin/layout_page', html_escape($data));
	}





}
