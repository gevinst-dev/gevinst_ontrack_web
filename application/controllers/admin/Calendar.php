<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/event_model', 'event');
        $this->load->model('admin/reminder_model', 'reminder');

        $this->load->model('admin/client_model', 'client');
		$this->load->model('admin/staff_model', 'staff');
	}



	public function index()
	{
        enforce_permission('calendar-view');

		$data['title'] = __("Calendar");
		$data['page'] = 'admin/calendar/calendar';
		$data['staff'] = $this->staff->get_all_active();
		$data['current_staff'] = $this->staff->get($this->session->staff_id);
		$data['selected_calendars'] = unserialize($data['current_staff']['calendars']);

		$data['events'] = $this->event->get_all();

		$this->load->view('admin/layout_page', html_escape($data));
	}



	public function add()
	{
        enforce_permission('calendar-add');

		$data['staff'] = $this->staff->get_all_active();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('calendar', __('Calendar'), 'trim|required');
			$this->form_validation->set_rules('title', __('Title'), 'trim|required');
			$this->form_validation->set_rules('all_day', __('All Day'), 'trim|required');
			$this->form_validation->set_rules('start_date', __('Start'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

                $start_date = datetime_hi_to_db($this->input->post('start_date'));
				$db_data = array(
                    'client_id' => $this->input->post('client_id'),
					'added_by' => $this->session->staff_id,
					'calendar' => $this->input->post('calendar'),
					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),
					'all_day' => $this->input->post('all_day'),
					'start_date' => $start_date,
					'end_date' => datetime_hi_to_db($this->input->post('end_date')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->event->add($db_data);

				if($result) {

                    if($this->input->post('reminder') == "1") {

                        $db_reminder_data = array(
                            'added_by' => $this->session->staff_id,
                            'assigned_to' => $this->session->staff_id,
                            'client_id' => $this->input->post('client_id'),
                            'notify_client' => $this->input->post('notify_client'),
                            'status' => "Upcoming",
                            'description' => "Reminder for Event: " . $this->input->post('title'),
                            'datetime' => date("Y-m-d H:i:s", strtotime($this->input->post('remind_me'), strtotime($start_date))),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );

                        $db_data = $this->security->xss_clean($db_data);
                        $reminder_id = $this->reminder->add($db_reminder_data);

                        $this->event->edit( ['reminder_id' => $reminder_id], $result);
                        
                    }


                    log_staff('Calendar event added ' . $result);

					$this->session->set_flashdata('toast-success', __("Event has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add event."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Event");
			$data['modal'] = 'admin/calendar/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit($id=0)
	{
        enforce_permission('calendar-edit');

		$data['event'] = $this->event->get($id);
		$data['staff'] = $this->staff->get_all_active();

        $data['client'] = $this->client->get($data['event']['client_id']);
        $data['reminder'] = $this->reminder->get($data['event']['reminder_id']);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('calendar', __('Calendar'), 'trim|required');
			$this->form_validation->set_rules('title', __('Title'), 'trim|required');
			$this->form_validation->set_rules('all_day', __('All Day'), 'trim|required');
			$this->form_validation->set_rules('start_date', __('Start'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
                    'client_id' => $this->input->post('client_id'),
					'calendar' => $this->input->post('calendar'),
					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),
					'all_day' => $this->input->post('all_day'),
					'start_date' => datetime_hi_to_db($this->input->post('start_date')),
					'end_date' => datetime_hi_to_db($this->input->post('end_date')),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->event->edit($db_data, $id);

				if($result) {
                    log_staff('Calendar event edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Event has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update event."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Event");
			$data['modal'] = 'admin/calendar/edit';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


	public function delete($id=0)
	{
        enforce_permission('calendar-delete');

		$data['event'] = $this->event->get($id);

		if($this->input->method() === 'post') {

			$result = $this->event->delete($id);

			if($result) {
                log_staff('Calendar event deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Event has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete event."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Event");
			$data['modal'] = 'admin/calendar/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function toggle_calendars()
	{
		$toggle = $this->uri->segment(4);
		$data['staff'] = $this->staff->get_all_active();
		$data['current_staff'] = $this->staff->get($this->session->staff_id);

		$selected_calendars = unserialize($data['current_staff']['calendars']);

		if($toggle == "none") {
			$db_data = array('calendars' => serialize([]));
			$this->staff->edit($db_data, $this->session->staff_id);
		} else if($toggle == "all") {
			$selected_calendars = [0];
			foreach ($data['staff'] as $item) {
				array_push($selected_calendars, $item['id']);
				$db_data = array('calendars' => serialize($selected_calendars));
				$this->staff->edit($db_data, $this->session->staff_id);
			}
		} else {
			if(in_array($toggle, $selected_calendars)) {
				$selected_calendars = array_diff( $selected_calendars, [$toggle] );
			} else {
				array_push($selected_calendars, $toggle);
			}

			$db_data = array('calendars' => serialize($selected_calendars));
			$this->staff->edit($db_data, $this->session->staff_id);
		}


		redirect($_SERVER['HTTP_REFERER']);
	}


	public function events_json() {

        enforce_permission('calendar-view');
        
		$filter = $this->uri->segment(4);

		$events = [];
		$i = 0;

		if($filter == "0") {
			$db_events = $this->db->get_where('app_events', array('calendar' => 'Group'))->result_array();
		} else {
			$db_events = $this->db->get_where('app_events', array('calendar' => 'Private', 'added_by' => $filter))->result_array();
		}

		foreach($db_events as $db_event) {
			$events[$i]['title'] = $db_event['title'];

            
			$events[$i]['url'] = 'admin/calendar/edit/'.$db_event['id'];

			if($db_event['all_day'] == '0') {
				$events[$i]['start'] = date("Y-m-d H:i:s", strtotime($db_event['start_date']));
				if($db_event['end_date'] != '') {
					$events[$i]['end'] = date("Y-m-d H:i:s", strtotime($db_event['end_date']));
				}
			} else {
				$events[$i]['start'] = date("Y-m-d", strtotime($db_event['start_date']));
				if($db_event['end_date'] != '') {
					$events[$i]['end'] = date("Y-m-d", strtotime($db_event['end_date']));
				}
			}

			$i++;
		}


		echo json_encode($events);

	}

}
