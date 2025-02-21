<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use PhpImap\Exceptions\ConnectionException;
use PhpImap\Mailbox;


class Cron extends CI_Controller {


	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set(get_setting('timezone'));
		define('DATE_FORMAT', get_setting('date_format'));


		$this->load->model('admin/setting_model', 'setting');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/invoice_model', 'invoice');
		$this->load->model('admin/staff_model', 'staff');

		$this->load->model('admin/ticket_model', 'ticket');
		$this->load->model('admin/user_model', 'user');
	}


    /**
     * Main cron
     */
	public function index() {
		$cron_lastrun = get_setting('cron_lastrun');
		$cron_daily_lastrun = get_setting('cron_daily_lastrun');
		$cron_daily_run_at = get_setting('cron_daily_run_at');


		if( $cron_daily_lastrun != date('Y-m-d') &&  $cron_daily_run_at == date('H') ) {
			$this->daily();
			update_setting('cron_daily_lastrun', date('Y-m-d'));
		}


		$this->frequently();
		update_setting('cron_lastrun', date('Y-m-d H:i:s'));
	}


    /**
     * Run frequent tasks
     */
	public function frequently()
	{

		$this->reminders_notifications();
		$this->pull_tickets();

	}


    /**
     * Run daily tasks
     */
	public function daily()
	{
		$this->update_exchange_rates();
		$this->domains_notifications();
		$this->tasks_due_date_notifications();
		$this->tasks_overdue_notifications();
		$this->generate_recurring_documents();
		$this->generate_recurring_expenses();
        

	}



	/**
     * Send domain expiration notifications
     */
	public function domains_notifications()
	{
		$domains = $this->db->get('app_domains')->result_array();

		foreach($domains as $domain) {

			$notify = unserialize($domain['notify']);

			if($domain['notify_0'] == "1") {
				if($domain['exp_date'] == date('Y-m-d')) {

					foreach($notify as $item) {
						$this->mailer->send("Staff | Domain expired", [ 'domain_id' => $domain['id'], "staff_id" => $item ]);
					}

					if($domain['notify_client'] == "1") {
						$this->mailer->send("Client | Domain expired", [ 'domain_id' => $domain['id'], "client_id" => $domain['client_id'] ]);
					}


				}
			}


			if($domain['notify_30'] == "1") {

				$date=date_create($domain['exp_date']);
				date_sub($date,date_interval_create_from_date_string("30 days"));
				$days_ago = date_format($date, "Y-m-d");

				if(date('Y-m-d') == $days_ago) {

					foreach($notify as $item) {
						$this->mailer->send("Staff | Domain expiry", [ 'domain_id' => $domain['id'], "staff_id" => $item, 'days' => '30' ]);
					}

					if($domain['notify_client'] == "1") {
						$this->mailer->send("Client | Domain expiry", [ 'domain_id' => $domain['id'], "client_id" => $domain['client_id'], 'days' => '30' ]);
					}


				}
			}

			if($domain['notify_14'] == "1") {

				$date=date_create($domain['exp_date']);
				date_sub($date,date_interval_create_from_date_string("14 days"));
				$days_ago = date_format($date, "Y-m-d");

				if(date('Y-m-d') == $days_ago) {

					foreach($notify as $item) {
						$this->mailer->send("Staff | Domain expiry", [ 'domain_id' => $domain['id'], "staff_id" => $item, 'days' => '14' ]);
					}

					if($domain['notify_client'] == "1") {
						$this->mailer->send("Client | Domain expiry", [ 'domain_id' => $domain['id'], "client_id" => $domain['client_id'], 'days' => '14' ]);
					}


				}
			}

			if($domain['notify_7'] == "1") {

				$date=date_create($domain['exp_date']);
				date_sub($date,date_interval_create_from_date_string("7 days"));
				$days_ago = date_format($date, "Y-m-d");

				if(date('Y-m-d') == $days_ago) {

					foreach($notify as $item) {
						$this->mailer->send("Staff | Domain expiry", [ 'domain_id' => $domain['id'], "staff_id" => $item, 'days' => '7' ]);
					}

					if($domain['notify_client'] == "1") {
						$this->mailer->send("Client | Domain expiry", [ 'domain_id' => $domain['id'], "client_id" => $domain['client_id'], 'days' => '7' ]);
					}


				}
			}

			if($domain['notify_3'] == "1") {

				$date=date_create($domain['exp_date']);
				date_sub($date,date_interval_create_from_date_string("3 days"));
				$days_ago = date_format($date, "Y-m-d");

				if(date('Y-m-d') == $days_ago) {

					foreach($notify as $item) {
						$this->mailer->send("Staff | Domain expiry", [ 'domain_id' => $domain['id'], "staff_id" => $item, 'days' => '3' ]);
					}

					if($domain['notify_client'] == "1") {
						$this->mailer->send("Client | Domain expiry", [ 'domain_id' => $domain['id'], "client_id" => $domain['client_id'], 'days' => '3' ]);
					}


				}
			}



		}

	}




	/**
     * Send reminders notifications
     */
	public function reminders_notifications()
	{
		$reminders = $this->db->get_where('app_reminders', [ 'status' => 'Upcoming', 'datetime <' => date('Y-m-d H:i:s') ] )->result_array();

		foreach($reminders as $reminder) {

			$this->mailer->send("Staff | Reminder alert", [ 'reminder_id' => $reminder['id'], "staff_id" => $reminder['assigned_to'], 'client_id' => $reminder['client_id'] ]);

            if($reminder['notify_client'] == '1' && $reminder['client_id'] != '0') {
                $this->mailer->send("Client | Reminder alert", [ 'reminder_id' => $reminder['id'], 'client_id' => $reminder['client_id'] ]);
            }

			$this->db->where('id', $reminder['id']);
			$this->db->update('app_reminders', ['status' => 'Reminded']);
		}

	}




	/**
     * Send task due date notifications
     */
	public function tasks_due_date_notifications()
	{
		$tasks = $this->db->get_where('app_issues', [ 'status !=' => 'Done', 'first_reminder' => 0, 'due_date !=' => '', 'due_date <' => date("Y-m-d", strtotime("-3 days")) ] )->result_array();

		foreach($tasks as $task) {

			if($task['added_by'] == $task['assigned_to']) {
				$this->mailer->send("Staff | Issue due date reminder", [ 'task_id' => $task['id'], "staff_id" => $task['assigned_to'] ]);

			} else {
				// send the notification to the one who added the task
				if($task['added_by'] != "0") {
					$this->mailer->send("Staff | Issue due date reminder", [ 'task_id' => $task['id'], "staff_id" => $task['added_by'] ]);
				}

				if($task['assigned_to'] != "0") {
					$this->mailer->send("Staff | Issue due date reminder", [ 'task_id' => $task['id'], "staff_id" => $task['assigned_to'] ]);
				}
			}


			$this->db->where('id', $task['id']);
			$this->db->update('app_issues', ['first_reminder' => '1']);
		}

	}

    


	/**
	 * Send task overdue notifications
	 */
	public function tasks_overdue_notifications()
	{
		$tasks = $this->db->get_where('app_issues', [ 'status !=' => 'Done', 'overdue_reminder' => 0, 'due_date !=' => '', 'due_date <' => date("Y-m-d") ] )->result_array();

		foreach($tasks as $task) {

			if($task['added_by'] == $task['assigned_to']) {
				$this->mailer->send("Staff | Issue overdue", [ 'task_id' => $task['id'], "staff_id" => $task['assigned_to'] ]);

			} else {
				// send the notification to the one who added the task
				if($task['added_by'] != "0") {
					$this->mailer->send("Staff | Issue overdue", [ 'task_id' => $task['id'], "staff_id" => $task['added_by'] ]);
				}

				if($task['assigned_to'] != "0") {
					$this->mailer->send("Staff | Issue overdue", [ 'task_id' => $task['id'], "staff_id" => $task['assigned_to'] ]);
				}
			}



			$this->db->where('id', $task['id']);
			$this->db->update('app_issues', ['overdue_reminder' => '1']);
		}

	}





	/**
	 * Generate recurring documents
	 */
	public function generate_recurring_documents() #### OK
	{
		$recurring = $this->db->get_where('app_recurring', [ 'status' => 'Active', 'next_date' => date("Y-m-d") ] )->result_array();


		foreach($recurring as $recurrence) {

			$items = $this->db->get_where('app_recurring_items', ['recurring_id' => $recurrence['id']])->result_array();
			$client = $this->client->get($recurrence['client_id']);


			$main_currency = $this->setting->get_currency($recurrence['currency_id']);
			$main_exrate = exrate_latest($recurrence['currency_id']);

			$default_currency_id = get_setting('default_currency');
			if($default_currency_id == $recurrence['currency_id']) $main_exrate = 1;

			$due_date = "";
			if(is_numeric($recurrence['due_days'])) $due_date = date("Y-m-d", strtotime("+".$recurrence['due_days']." days"));

			$public_notes = "";


			if($recurrence['type'] == 'Invoice') {

				$invoice_data = array(
                    'entity_id' => $recurrence['entity_id'],
					'language_id' => $recurrence['language_id'],
					'client_id' => $recurrence['client_id'],
					'proposal_id' => 0,
					'recurring_id' => $recurrence['id'],
					'added_by' => $recurrence['added_by'],
                    'issued_by' => $recurrence['added_by'],
					'currency_id' => $recurrence['currency_id'],

                    'rate' => $main_exrate,
                    'number' => next_document_number('invoice', $recurrence['entity_id']),
                    'date' => date("Y-m-d"),
                    'due_date' => $due_date,
                    'value' => 0,
                    'tax' => 0,
                    'total' => 0,
                    'unpaid' => 0,
					'paid' => 0,
                    'status' => "Valid",
					'public_notes' => $public_notes,
                    'client_data' => serialize($client),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$this->db->insert('app_invoices', $invoice_data);
				$invoice_id = $this->db->insert_id();

				increase_document_number("invoice", $recurrence['entity_id']);

				foreach($items as $item) {
					$ex_description = "";

					if($recurrence['currency_id'] != $item['currency_id']) {

						$c_currency = $this->setting->get_currency($item['currency_id']);
						$c_exrate = exrate_latest($c_currency['id']);

						$b_currency = $this->setting->get_currency($recurrence['currency_id']);
						$b_exrate = exrate_latest($b_currency['id']);


						$parity = $c_exrate / $b_exrate;

						$price = $item['price']*$parity;
						$value = $item['value']*$parity;
						$tax = $item['tax']*$parity;
						$total = $item['total']*$parity;

						$ex_description = "";
						if(!empty($item['description'])) { $ex_description .= " | "; }

						$ex_description .=  $item['value'] . $c_currency['code'] .  ' @ ' . round($parity,4) . $b_currency['code'];


					} else {
						$price = $item['price'];
						$value = $item['value'];
						$tax = $item['tax'];
						$total = $item['total'];

						$ex_description = "";
					}


					$db_item = array(
						'invoice_id' => $invoice_id,
						'item_id' => $item['item_id'],
						'type' => $item['type'],
						'name' => $item['name'],
						'description' => $item['description'] . $ex_description,
						'qty' => $item['qty'],
						'taxrate' => $item['taxrate'],
						'price' => round($price,4),
						'value' => round($value,2),
						'tax' => round($tax,2),
						'total' => round($total,2),
					);


					$this->db->insert('app_invoice_items', $db_item);


				}

				recalculate_invoice_total($invoice_id);

				$notify_data = [
					'invoice_id'=> $invoice_id,
					'client_id' => $recurrence['client_id'],
					'recurring_id' => $recurrence['id']
				];

				notify_active_admins('Staff | New recurring document', $notify_data);
				if($recurrence['send_email'] == 1) $this->mailer->send("Client | New Invoice", $notify_data);


			}




			if($recurrence['type'] == 'Proforma') {


				$proforma_data = array(
                    'entity_id' => $recurrence['entity_id'],
                    'language_id' => $recurrence['language_id'],
					'client_id' => $recurrence['client_id'],
					'proposal_id' => 0,
					'recurring_id' => $recurrence['id'],

					'added_by' => $recurrence['added_by'],
                    'issued_by' => $recurrence['added_by'],
					'currency_id' => $recurrence['currency_id'],
                    'rate' => $main_exrate,
                    'number' => next_document_number('proforma', $recurrence['entity_id']),
                    'date' => date("Y-m-d"),
                    'due_date' => $due_date,
                    'value' => 0,
                    'tax' => 0,
                    'total' => 0,
					'paid' => 0,
                    'unpaid' => 0,
                    'status' => "Valid",
                    'client_data' => serialize($client),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$this->db->insert('app_proformas', $proforma_data);
				$proforma_id = $this->db->insert_id();

				increase_document_number("proforma", $recurrence['entity_id']);

				foreach($items as $item) {

					if($recurrence['currency_id'] != $item['currency_id']) {

						$c_currency = $this->setting->get_currency($item['currency_id']);
						$c_exrate = exrate_latest($c_currency['id']);

						$b_currency = $this->setting->get_currency($recurrence['currency_id']);
						$b_exrate = exrate_latest($b_currency['id']);


						$parity = $c_exrate / $b_exrate;

						$price = $item['price']*$parity;
						$value = $item['value']*$parity;
						$tax = $item['tax']*$parity;
						$total = $item['total']*$parity;

						$ex_description = "";
						if(!empty($item['description'])) { $ex_description .= " | "; }

						$ex_description .=  $item['value'] . $c_currency['code'] .  ' @ ' . round($parity,4) . $b_currency['code'];


					} else {
						$price = $item['price'];
						$value = $item['value'];
						$tax = $item['tax'];
						$total = $item['total'];

						$ex_description = "";
					}

					$db_item = array(
						'proforma_id' => $proforma_id,
						'item_id' => $item['item_id'],
						'type' => $item['type'],
						'name' => $item['name'],
						'description' => $item['description'] . $ex_description,
						'qty' => $item['qty'],
						'taxrate' => $item['taxrate'],
						'price' => round($price,4),
						'value' => round($value,2),
						'tax' => round($tax,2),
						'total' => round($total,2),
					);


					$this->db->insert('app_proforma_items', $db_item);


				}

				recalculate_proforma_total($proforma_id);

				$notify_data = [
					'proforma_id'=> $proforma_id,
					'client_id' => $recurrence['client_id'],
					'recurring_id' => $recurrence['id']
				];

				notify_active_admins('Staff | New recurring document', $notify_data);
				if($recurrence['send_email'] == 1) $this->mailer->send("Client | New Profroma", $notify_data);


			}



			// update next date
			if($recurrence['frequency'] == "Monthly") $next_date = date("Y-m-d", strtotime("+1 month"));
			if($recurrence['frequency'] == "Weekly") $next_date = date("Y-m-d", strtotime("+1 week"));
			if($recurrence['frequency'] == "Daily") $next_date = date("Y-m-d", strtotime("+1 day"));
			if($recurrence['frequency'] == "At 2 Weeks") $next_date = date("Y-m-d", strtotime("+2 weeks"));
			if($recurrence['frequency'] == "At 2 Months") $next_date = date("Y-m-d", strtotime("+2 months"));
			if($recurrence['frequency'] == "At 3 Months") $next_date = date("Y-m-d", strtotime("+3 months"));
			if($recurrence['frequency'] == "At 6 Months") $next_date = date("Y-m-d", strtotime("+6 months"));
			if($recurrence['frequency'] == "Yearly") $next_date = date("Y-m-d", strtotime("+1 year"));

			$this->db->where('id', $recurrence['id']);
			$this->db->update('app_recurring', ['next_date' => $next_date, 'emissions' => $recurrence['emissions'] + 1 ]);
		}


	}


	/**
	 * Generate recurring expenses
	 */
	public function generate_recurring_expenses()
	{


		$recurring = $this->db->get_where('app_recurring_expenses', [ 'status' => 'Active', 'next_date' => date("Y-m-d") ] )->result_array();


		foreach($recurring as $recurrence) {

			$exrate = exrate_latest($recurrence['currency_id']);

			$db_data = array(
				'entity_id' => $recurrence['entity_id'],
				'supplier_id' => $recurrence['supplier_id'],
				'project_id' => $recurrence['project_id'],
				'category_id' => $recurrence['category_id'],
				'currency_id' => $recurrence['currency_id'],
				'value' => $recurrence['value'],
				'tax' => $recurrence['tax'],
				'total' => $recurrence['total'],
				'paid' => 0,
				'rate' => $exrate,
				'description' => $recurrence['description'],
				'date' => date('Y-m-d'),
				'status' => "Valid",

				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$this->db->insert('app_expenses', $db_data);


			// update next date
			if($recurrence['frequency'] == "Monthly") $next_date = date("Y-m-d", strtotime("+1 month"));
			if($recurrence['frequency'] == "Weekly") $next_date = date("Y-m-d", strtotime("+1 week"));
			if($recurrence['frequency'] == "Daily") $next_date = date("Y-m-d", strtotime("+1 day"));
			if($recurrence['frequency'] == "At 2 Weeks") $next_date = date("Y-m-d", strtotime("+2 weeks"));
			if($recurrence['frequency'] == "At 2 Months") $next_date = date("Y-m-d", strtotime("+2 months"));
			if($recurrence['frequency'] == "At 3 Months") $next_date = date("Y-m-d", strtotime("+3 months"));
			if($recurrence['frequency'] == "At 6 Months") $next_date = date("Y-m-d", strtotime("+6 months"));
			if($recurrence['frequency'] == "Yearly") $next_date = date("Y-m-d", strtotime("+1 year"));

			$this->db->where('id', $recurrence['id']);
			$this->db->update('app_recurring_expenses', ['next_date' => $next_date, 'emissions' => $recurrence['emissions'] + 1 ]);
		}



	}





	/**
	 * Pull tickets from mailbox
	 */
    public function pull_tickets()
	{

        $staff = $this->staff->get_all();
        $tickets = $this->ticket->get_existing();

		$mail_ids = [];

        $purifier = new HTMLPurifier();

		if(get_setting('imap_server') != "" && get_setting('imap_user') != "" && get_setting('imap_pass') != "") {

			$mailbox = new Mailbox(
				'{'.get_setting('imap_server').':'.get_setting('imap_port').'/imap'.get_setting('imap_encryption').'}INBOX', // IMAP server and mailbox folder
				get_setting('imap_user'), // Username for the before configured mailbox
				get_setting('imap_pass'), // Password for the before configured username
				FCPATH . '/filestore/main/tickets/', // Directory, where attachments will be saved (optional)
				'US-ASCII' // Server encoding (optional)
			);



			try {
				$mail_ids = $mailbox->searchMailbox('UNSEEN');
			} catch(ConnectionException $ex) {

			}

			foreach ($mail_ids as $mail_id) {
				

				$email = $mailbox->getMail(
					$mail_id, // ID of the email, you want to get
					false // Do NOT mark emails as seen (optional)
				);

				// extract main data
				$from_name = (isset($email->fromName)) ? $email->fromName : $email->fromAddress;
				$from_email = $email->fromAddress;
				$subject = $email->subject;
				$email_importance = $email->importance;
				$email_priority = $email->priority;
				$priority = "Normal";
				if (strpos($email_priority, '1') !== false) $priority = "High";
				if (strpos($email_priority, '2') !== false) $priority = "High";
				if (strpos($email_priority, '4') !== false) $priority = "Low";
				if (strpos($email_priority, '5') !== false) $priority = "Low";

				if ($email->textHtml) {
					$message = $purifier->purify($email->textHtml);
				} else {
					$message = nl2br($email->textPlain);
				}

				$cc_array = [];
				foreach ($email->cc as $key => $value) {
					array_push($cc_array, $key);
				}

				if(empty($cc_array)) {
					$cc = "";
				} else {
					$cc = implode(',', $cc_array);
				}




				// check if email from staff
				$email_from_staff = FALSE;
				$staff_id = 0;
				foreach ($staff as $item) {
					if(stripos($from_email, $item['email']) !== false) { $email_from_staff = TRUE; $staff_id = $item['id']; }
				}

				// check if existing ticket
				$existing_ticket = FALSE;
				$existing_ticket_id = 0;
				foreach ($tickets as $ticket) {
					if(stripos($subject, $ticket['ticket']) !== false) { $existing_ticket = TRUE; $existing_ticket_id = $ticket['id']; }
				}

				if($existing_ticket == TRUE) {
					$existing_ticket_data = $this->ticket->get($existing_ticket_id);
				}


				// discover
				$user_id = 0;
				$client_id = 0;

				$user_db = $this->db->get_where('core_users', array('email' => $from_email))->row_array();
				if($user_db) {
					$user_id = $user_db['id'];
					$client_id = $user_db['client_id'];
				}


				// email coming from staff
				if($email_from_staff) {


					if($existing_ticket) {
						$db_reply_data = array(
							'ticket_id' => $existing_ticket_id,
							'staff_id' => $staff_id,
							'message' => $message,
							'created_at' => date('Y-m-d H:i:s'),
						);
						$db_reply_data = $this->security->xss_clean($db_reply_data);
						$this->db->insert('app_ticket_replies', $db_reply_data);
						$reply_id = $this->db->insert_id();

                        $this->db->where('id', $existing_ticket_id);
                        $this->db->update('app_tickets', ['status' => 'Answered']);


					} else {

						$db_data = array(
							'ticket' => random_ticket(8),
							'user_id' => 0,
							'assigned_to' => 0,
							'email' => $from_email,
							'cc' => $cc,
							'status' => 'Open',
							'priority' => $priority,
							'subject' => $subject,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
						);
						$db_data = $this->security->xss_clean($db_data);
						$this->db->insert('app_tickets', $db_data);
						$ticket_id = $this->db->insert_id();


						$db_reply_data = array(
							'ticket_id' => $ticket_id,
							'staff_id' => $staff_id,
							'message' => $message,
							'created_at' => date('Y-m-d H:i:s'),
						);
						$db_reply_data = $this->security->xss_clean($db_reply_data);
						$this->db->insert('app_ticket_replies', $db_reply_data);
						$reply_id = $this->db->insert_id();

					}


				// email from user or non staff email address
				} else {

					if($existing_ticket) {

						$db_reply_data = array(
							'ticket_id' => $existing_ticket_id,
							'staff_id' => 0,
							'user_id' => $user_id,
							'message' => $message,
							'created_at' => date('Y-m-d H:i:s'),
						);
						$db_reply_data = $this->security->xss_clean($db_reply_data);
						$this->db->insert('app_ticket_replies', $db_reply_data);
						$reply_id = $this->db->insert_id();


                        $this->db->where('id', $existing_ticket_id);
                        $this->db->update('app_tickets', ['status' => 'Reopened']);


					} else {
						$db_data = array(
							'ticket' => random_ticket(8),
							'user_id' => $user_id,
							'client_id' => $client_id,
							'assigned_to' => 0,
							'email' => $from_email,
							'cc' => $cc,
							'status' => 'Open',
							'priority' => $priority,
							'subject' => $subject,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
						);
						$db_data = $this->security->xss_clean($db_data);
						$this->db->insert('app_tickets', $db_data);
						$ticket_id = $this->db->insert_id();


						$db_reply_data = array(
							'ticket_id' => $ticket_id,
							'staff_id' => 0,
							'user_id' => $user_id,
							'message' => $message,
							'created_at' => date('Y-m-d H:i:s'),
						);
						$db_reply_data = $this->security->xss_clean($db_reply_data);
						$this->db->insert('app_ticket_replies', $db_reply_data);
						$reply_id = $this->db->insert_id();

					}





				}



				if ($email->hasAttachments()) {

					$attachments = $email->getAttachments();

					foreach ($attachments as $attachment) {



						$db_file_data = array(
							'reply_id' => $reply_id,
							'file' => basename($attachment->filePath),
							'name' => $attachment->name,
							'created_at' => date('Y-m-d H:i:s'),
						);
						$this->db->insert('app_ticket_reply_files', $db_file_data);

						
					}

				}

				if($existing_ticket_id != 0) {
					$final_ticket_id = $existing_ticket_id;
				} else {
					$final_ticket_id = $ticket_id;
				}
				$staff_notifiable = $this->staff->get_all_notifiable();


				if($email_from_staff) {

					if($existing_ticket) {

						$this->mailer->send("User | New ticket reply", [ "email_address" => $existing_ticket_data['email'], 'ticket_id' => $final_ticket_id, 'reply_id' => $reply_id, 'user_id' => $user_id ]);

					} else {

						foreach ($staff_notifiable as $item) {
							$this->mailer->send("Staff | New ticket", [ "staff_id" => $item['id'], 'ticket_id' => $final_ticket_id ]);
						}

						$this->mailer->send("User | New ticket", [ "email_address" => $from_email, 'ticket_id' => $final_ticket_id, 'user_id' => $user_id  ]);

					}

				} else {

					if($existing_ticket) {

						foreach ($staff_notifiable as $item) {
							$this->mailer->send("Staff | New ticket reply", [ "staff_id" => $item['id'], 'ticket_id' => $final_ticket_id, 'reply_id' => $reply_id ]);
						}

					} else {

						foreach ($staff_notifiable as $item) {
							$this->mailer->send("Staff | New ticket", [ "staff_id" => $item['id'], 'ticket_id' => $final_ticket_id ]);
						}

						$this->mailer->send("User | New ticket", [ "email_address" => $from_email, 'ticket_id' => $final_ticket_id, 'user_id' => $user_id  ]);
					}

				}



				$mailbox->markMailAsRead($mail_id);

			}


			$mailbox->disconnect();
		}


	}


    /**
	 * Entry point for manual exchange rates update
	 */
    public function currencies_manual_update()
	{
        $this->update_exchange_rates();

        redirect(base_url('admin/setup/settings/currencies'));

    }


	/**
     * Update exchange rates
     */
	public function update_exchange_rates()
	{

        $currencies = $this->setting->get_currencies();
        $default_currency = $this->setting->get_currency(get_setting('default_currency'));
        $exchange_rates_provider = get_setting('exchange_rates_provider');
        $exchange_rates_provider_key = get_setting('exchange_rates_provider_key');

        if($exchange_rates_provider == 'fixer.io') {

            foreach($currencies as $currency) {

                // skip default currency (base currency)
                if($currency['id'] == $default_currency['id']) continue;

                
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.apilayer.com/fixer/latest?symbols=".$default_currency['code']."&base=".$currency['code'],
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: text/plain",
                    "apikey: ".$exchange_rates_provider_key
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET"
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                $response = json_decode($response, true);

                if(isset($response['rates'][$default_currency['code']])) {
                    $db_data = ['rate' => $response['rates'][$default_currency['code']] ];
                    $this->db->where('id', $currency['id']);
                    $this->db->update('app_currencies', $db_data);
                }


            }

            update_setting('exchange_rates_provider_last_update', date('Y-m-d H:i:s'));

        }

        if($exchange_rates_provider == 'bnro.ro') {

            $arrContextOptions=array(
                "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
                ),
            );

            $xmlDocument = file_get_contents('https://www.bnro.ro/nbrfxrates.xml', false, stream_context_create($arrContextOptions));
            $xml = new SimpleXMLElement($xmlDocument);
            $date = $xml->Header->PublishingDate;

            foreach($xml->Body->Cube->Rate as $line)
            {
                $currency[]=array("name"=>$line["currency"], "value"=>$line, "multiplier"=>$line["multiplier"]);
            }

            foreach($currency as $line)
            {
                if($line["name"]=="EUR")
                {
                    $db_data = ['rate' => $line["value"]];
                    $this->db->where('code', 'EUR');
                    $this->db->update('app_currencies', $db_data);
                }

                if($line["name"]=="USD")
                {
                    $db_data = ['rate' => $line["value"]];
                    $this->db->where('code', 'USD');
                    $this->db->update('app_currencies', $db_data);
                }

                if($line["name"]=="GBP")
                {
                    $db_data = ['rate' => $line["value"]];
                    $this->db->where('code', 'GBP');
                    $this->db->update('app_currencies', $db_data);
                }

            }
            

            update_setting('exchange_rates_provider_last_update', date('Y-m-d H:i:s'));

        }



	}

}
