<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Mailer
{
	function __construct()
	{
		$this->CI =& get_instance();

        $this->CI->load->library('email');
        $this->CI->load->helper('string');
		$this->CI->load->library('user_agent');

		$this->CI->load->model('admin/proposal_model', 'proposal_model');
		$this->CI->load->model('admin/proforma_model', 'proforma_model');
		$this->CI->load->model('admin/invoice_model', 'invoice_model');


		$smtp_config = Array(
			'protocol' => 'smtp',
			'smtp_host' => get_setting('email_smtp_host'),
			'smtp_port' => get_setting('email_smtp_port'),
			'smtp_user' => get_setting('email_smtp_user'),
			'smtp_pass' => get_setting('email_smtp_pass'),
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'newline' => "\r\n",
			'crlf' => "\r\n",
		);

		$email_smtp_crypto = get_setting('email_smtp_crypto');
		if($email_smtp_crypto == "tls") $smtp_config['smtp_crypto'] = "tls";
		if($email_smtp_crypto == "ssl") $smtp_config['smtp_crypto'] = "ssl";

		$this->CI->load->library('email');

		if(get_setting('email_smtp') == "1") {
			$this->CI->email->initialize($smtp_config);
		} else {
			$this->CI->email->initialize(
				[
					'protocol' => 'mail',
					'mailtype'  => 'html',
					'charset'   => 'utf-8',
					'newline' => "\r\n",
					'crlf' => "\r\n",
				]

			);
		}

	}


    public function send($template_name, $data=array(), $attachments = array(), $deliver=TRUE)
	{

		$priority = 2;

        $staff_id = 0;
        $user_id = 0;
		$client_id = 0;

        $email_address = '';
        $subject = 'Test email';
        $body = '<p>This is a test email message.</p>';

		if($template_name != "Quick Notification") {
			$template = $this->CI->db->get_where('core_email_templates', array('name' => $template_name))->row_array();
		} else {
			$template['subject'] = $data['subject'];
			$template['body'] = $data['body'];
		}


		if(isset($data['staff_id'])) {
			$staff = $this->CI->db->get_where('core_staff', array('id' => $data['staff_id']))->row_array();

			if($staff) {
				$email_address = $staff['email'];
				$staff_id = $staff['id'];
			}


		}

        if(isset($data['user_id'])) {
            $user = $this->CI->db->get_where('core_users', array('id' => $data['user_id']))->row_array();

			if($user) {
				$email_address = $user['email'];
	            $user_id = $user['id'];
			}


        }

		if(isset($data['entity_id'])) {
			$entity = $this->CI->db->get_where('app_entities', array('id' => $data['entity_id']))->row_array();
		}



		if(isset($data['client_id'])) {
			$client = $this->CI->db->get_where('app_clients', array('id' => $data['client_id']))->row_array();

			if($client) {
				$client_id = $client['id'];
			}


			if(empty($user) && $staff_id == 0) {
				$email_address = $client['email'];
			}
		}


		if(isset($data['proposal_id'])) {
			$proposal = $this->CI->db->get_where('app_proposals', array('id' => $data['proposal_id']))->row_array();

			array_push($attachments, '/filestore/temp/' . $this->CI->proposal_model->pdf('save', $proposal['id']));
		}


		if(isset($data['invoice_id'])) {
			$invoice = $this->CI->db->get_where('app_invoices', array('id' => $data['invoice_id']))->row_array();

			array_push($attachments, '/filestore/temp/' . $this->CI->invoice_model->pdf('save', $invoice['id']));
		}


		if(isset($data['proforma_id'])) {
			$proforma = $this->CI->db->get_where('app_proformas', array('id' => $data['proforma_id']))->row_array();

			array_push($attachments, '/filestore/temp/' . $this->CI->proforma_model->pdf('save', $proforma['id']));
		}


		if(isset($data['recurring_id'])) {
			$recurring = $this->CI->db->get_where('app_recurring', array('id' => $data['recurring_id']))->row_array();
			$client = $this->CI->db->get_where('app_clients', array('id' => $recurring['client_id']))->row_array();
		}


		if(isset($data['reminder_id'])) {
			$reminder = $this->CI->db->get_where('app_reminders', array('id' => $data['reminder_id']))->row_array();
		}


		if(isset($data['event_id'])) {
			$event = $this->CI->db->get_where('app_event', array('id' => $data['event_id']))->row_array();
		}


		if(isset($data['task_id'])) {
			$task = $this->CI->db->get_where('app_issues', array('id' => $data['task_id']))->row_array();
		}

        if(isset($data['issue_id'])) {
			$task = $this->CI->db->get_where('app_issues', array('id' => $data['task_id']))->row_array();
		}

		if(isset($data['domain_id'])) {
			$domain = $this->CI->db->get_where('app_domains', array('id' => $data['domain_id']))->row_array();
		}

		if(isset($data['ticket_id'])) {
			$ticket = $this->CI->db->get_where('app_tickets', array('id' => $data['ticket_id']))->row_array();
			$first_reply = $this->CI->db->order_by("created_at", "desc")->limit(1)->get_where('app_ticket_replies', array('ticket_id' => $ticket['id']))->row_array();
			$reply_files = $this->CI->db->get_where('app_ticket_reply_files', array('reply_id' => $first_reply['id']))->result_array();
		}

		if(isset($data['reply_id'])) {
			$reply = $this->CI->db->get_where('app_ticket_replies', array('id' => $data['reply_id']))->row_array();
			$reply_files = $this->CI->db->get_where('app_ticket_reply_files', array('reply_id' => $data['reply_id']))->result_array();
		}

		// overwrite email address
        if(isset($data['email_address'])) {
            $email_address = $data['email_address'];
        }

		// overwrite subject
		if(isset($data['subject'])) {
			$template['subject'] = $data['subject'];
		}

		// overwrite body
		if(isset($data['body'])) {
			$template['body'] = $data['body'];
		}



        switch ($template_name) {


            ### 1
			case 'User | Welcome email':
				$priority = 2;

				if(isset($data['password'])) {
					$password = $data['password'];
				} else {
					$password = __('Password you have set.');
				}

				$search = array('{name}', '{email}', '{password}', '{url}', '{app_name}');
				$replace = array($user['name'], $user['email'], $password, base_url(), get_setting('app_name'));

				$subject = str_replace($search, $replace, $template['subject']);
                $body = str_replace($search, $replace, $template['body']);
			break;


            ### 2
            case 'User | Password reset':
                $priority = 1;

                $search = array('{name}', '{email}', '{password_reset_key}', '{url}');
                $replace = array($user['name'], $user['email'], $user['password_reset_key'], base_url('auth/reset_password/'.$user['password_reset_key']));

                $subject = str_replace($search, $replace, $template['subject']);
                $body = str_replace($search, $replace, $template['body']);
            break;


            ### 3
            case 'User | Password reset confirmation':
                $priority = 2;

                $search = array('{name}', '{email}', '{url}');
                $replace = array($user['name'], $user['email'], base_url('auth/sign_in'));

                $subject = str_replace($search, $replace, $template['subject']);
                $body = str_replace($search, $replace, $template['body']);
            break;

            
            ### 4
			case 'Staff | Password reset':
                $priority = 1;

                $search = array('{name}', '{email}', '{password_reset_key}', '{url}');
                $replace = array($staff['name'], $staff['email'], $staff['password_reset_key'], base_url('admin/auth/reset_password/'.$staff['password_reset_key']));

                $subject = str_replace($search, $replace, $template['subject']);
                $body = str_replace($search, $replace, $template['body']);
            break;


            ### 5
            case 'Staff | Password reset confirmation':
                $priority = 2;

                $search = array('{name}', '{email}', '{url}');
                $replace = array($staff['name'], $staff['email'], base_url('admin/auth/sign_in'));

                $subject = str_replace($search, $replace, $template['subject']);
                $body = str_replace($search, $replace, $template['body']);
            break;


            ### 6
			case 'Staff | Reminder alert':
				$priority = 2;

				$search = array('{name}', '{email}', '{reminder}');
				$replace = array($staff['name'], $staff['email'], $reminder['description']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 7
			case 'Staff | Issue due date reminder':
				$priority = 2;

				$search = array('{name}', '{email}', '{issue}', '{due_date}');
				$replace = array($staff['name'], $staff['email'], $task['name'], date_display($task['due_date']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 8
			case 'Staff | Issue overdue':
				$priority = 2;

				$search = array('{name}', '{email}', '{issue}', '{due_date}');
				$replace = array($staff['name'], $staff['email'], $task['name'], date_display($task['due_date']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 9
			case 'Staff | Issue assigned':
				$priority = 2;

				$search = array('{name}', '{email}', '{issue}', '{due_date}');
				$replace = array($staff['name'], $staff['email'], $task['name'], date_display($task['due_date']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 10
			case 'Staff | New ticket':
				$priority = 2;

				$search = array('{ticket}', '{subject}', '{message}', '{name}');
				$replace = array($ticket['ticket'], $ticket['subject'], $first_reply['message'], $staff['name']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);

				foreach ($reply_files as $reply_file) {
					array_push($attachments, '/filestore/main/tickets/' . $reply_file['file']);
				}
			break;


            ### 11
			case 'Staff | New ticket reply':
				$priority = 2;

				$search = array('{ticket}', '{subject}', '{message}', '{name}');
				$replace = array($ticket['ticket'], $ticket['subject'], $reply['message'], $staff['name']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);

				foreach ($reply_files as $reply_file) {
					array_push($attachments, '/filestore/main/tickets/' . $reply_file['file']);
				}
			break;


            ### 12
			case 'Staff | Ticket assigned':
				$priority = 2;

				$search = array('{ticket}', '{subject}', '{message}', '{name}');
				$replace = array($ticket['ticket'], $ticket['subject'], $first_reply['message'], $staff['name']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);

				foreach ($reply_files as $reply_file) {
					array_push($attachments, '/filestore/main/tickets/' . $reply_file['file']);
				}
			break;


            ### 13
			case 'Staff | New recurring document':
				$priority = 2;

				$search = array('{type}', '{reccurence_name}', '{client}', '{name}');
				$replace = array(__($recurring['type']), $recurring['name'], $client['name'], $staff['name']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);

			break;


            ### 14
			case 'Client | New Invoice':
				$priority = 2;

				$search = array('{name}', '{email}', '{client_name}', '{invoice_no}', '{invoice_total}', '{due_date}');
				$replace = array($client['name'], $client['email'], $client['name'], $invoice['number'], format_currency($invoice['total'], $invoice['currency_id']), date_display($invoice['due_date']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 15
			case 'Client | Invoice Reminder':
				$priority = 2;

				$search = array('{name}', '{email}', '{client_name}', '{invoice_no}', '{invoice_total}', '{due_date}');
				$replace = array($client['name'], $client['email'], $client['name'], $invoice['number'], format_currency($invoice['total'], $invoice['currency_id']), date_display($invoice['due_date']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 16
			case 'Client | Invoice Overdue':
				$priority = 2;

				$search = array('{name}', '{email}', '{client_name}', '{invoice_no}', '{invoice_total}', '{due_date}');
				$replace = array($client['name'], $client['email'], $client['name'], $invoice['number'], format_currency($invoice['total'], $invoice['currency_id']), date_display($invoice['due_date']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 17
			case 'Client | New Proposal':
				$priority = 2;

				$search = array('{name}', '{email}', '{client_name}', '{proposal_no}', '{proposal_total}', '{due_date}');
				$replace = array($client['name'], $client['email'], $client['name'], $proposal['number'], format_currency($proposal['total'], $proposal['currency_id']), date_display($proposal['valid_until']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 18
			case 'Client | New Proforma':
				$priority = 2;

				$search = array('{name}', '{email}', '{client_name}', '{proforma_no}', '{profroma_total}', '{due_date}');
				$replace = array($client['name'], $client['email'], $client['name'], $proforma['number'], format_currency($proforma['total'], $proforma['currency_id']), date_display($proforma['due_date']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 19
			case 'User | New ticket':
				$priority = 2;

				if(!isset($user['name'])) { $user['name'] = $email_address; }

				$search = array('{ticket}', '{subject}', '{message}', '{email}', '{name}');
				$replace = array($ticket['ticket'], $ticket['subject'], $first_reply['message'], $email_address, $user['name']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);

				foreach ($reply_files as $reply_file) {
					array_push($attachments, '/filestore/main/tickets/' . $reply_file['file']);
				}

				$cc = $ticket['cc'];
			break;


            ### 20
			case 'User | New ticket reply':
				$priority = 2;

				if(!isset($user['name'])) { $user['name'] = $email_address; }

				$search = array('{ticket}', '{subject}', '{message}', '{email}', '{name}');
				$replace = array($ticket['ticket'], $ticket['subject'], $reply['message'], $email_address, $user['name']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);

				foreach ($reply_files as $reply_file) {
					array_push($attachments, '/filestore/main/tickets/' . $reply_file['file']);
				}
				$cc = $ticket['cc'];
			break;


            ### 21
			case 'User | Ticket auto close':
				$priority = 2;

				if(!isset($user['name'])) { $user['name'] = $email_address; }

				$search = array('{ticket}', '{subject}', '{message}', '{email}', '{name}');
				$replace = array($ticket['ticket'], $ticket['subject'], $reply['message'], $email_address, $user['name']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);

				$cc = $ticket['cc'];
			break;


            ### 22
			case 'Staff | Domain expiry':
				$priority = 2;

				$search = array('{name}', '{email}', '{domain}', '{exp_date}', '{days}');
				$replace = array($staff['name'], $staff['email'], $domain['domain'], date_display($domain['exp_date']), $data['days']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 23
			case 'Staff | Domain expired':
				$priority = 2;

				$search = array('{name}', '{email}', '{domain}', '{exp_date}');
				$replace = array($staff['name'], $staff['email'], $domain['domain'], date_display($domain['exp_date']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 24
            case 'Client | Domain expiry':
				$priority = 2;

				$search = array('{name}', '{email}', '{domain}', '{exp_date}', '{days}');
				$replace = array($client['name'], $client['email'], $domain['domain'], date_display($domain['exp_date']), $data['days']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 25
			case 'Client | Domain expired':
				$priority = 2;

				$search = array('{name}', '{email}', '{domain}', '{exp_date}');
				$replace = array($client['name'], $client['email'], $domain['domain'], date_display($domain['exp_date']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;


            ### 26
			case 'Staff | New Issue':
				$priority = 2;

				$search = array('{name}', '{email}', '{issue}', '{due_date}');
				$replace = array($staff['name'], $staff['email'], $task['name'], date_display($task['due_date']));

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;





            ### 27
			case 'Client | Reminder alert':
				$priority = 2;

				$search = array('{name}', '{email}', '{reminder}');
				$replace = array($client['name'], $client['email'], $reminder['description']);

				$subject = str_replace($search, $replace, $template['subject']);
				$body = str_replace($search, $replace, $template['body']);
			break;






        }

		// start header generation
		ob_start();
        if(file_exists(FCPATH . 'application/views/email/header.custom.php')) {
            include FCPATH . 'application/views/email/header.custom.php';
        } else {
            include FCPATH . 'application/views/email/header.php';
        }


		$header = ob_get_contents();
		ob_end_clean();
		// end header generation


		// start footer generation
		ob_start();
        if(file_exists(FCPATH . 'application/views/email/footer.custom.php')) {
            include FCPATH . 'application/views/email/footer.custom.php';
        } else {
            include FCPATH . 'application/views/email/footer.php';
        }

		$footer = ob_get_contents();
		ob_end_clean();
		// end footer generation


		$email_data = array(
			'staff_id' => $staff_id,
			'user_id' => $user_id,
			'client_id' => $client_id,
			'sent' => 'No',
			'priority' => $priority,
			'email_address' => $email_address,
			'subject' => $subject,
			'body' => $header . $body . $footer,
			'attachments' => serialize($attachments),
			'errors' => '',
			'created_at' => date('Y-m-d H:i:s'),
		);



		$data = $this->CI->security->xss_clean($email_data);
        $this->CI->db->insert('core_emails', $email_data);
        $email_id = $this->CI->db->insert_id();

        if($deliver) {
            self::deliver($email_id);
            return TRUE;
        } else {
            return TRUE;
        }


    }


    public function deliver($email_id)
    {
        $email = $this->CI->db->get_where('core_emails', array('id' => $email_id))->row_array();

        $this->CI->email->clear(TRUE);

        $this->CI->email->from( get_setting('email_from_address'), get_setting('email_from_name') );


        $this->CI->email->to($email['email_address']);
        $this->CI->email->subject($email['subject']);
        $this->CI->email->message($email['body']);

        $attachments = unserialize($email['attachments']);
        foreach ($attachments as $attachment) {
            $this->CI->email->attach(FCPATH . $attachment);
        }


        if($this->CI->email->send()) {
            $this->CI->db->where('id', $email_id);
            $this->CI->db->update('core_emails', ["sent" => 'Yes', 'errors' => '']);
            return TRUE;
        } else {
            $this->CI->db->where('id', $email_id);
            $this->CI->db->update('core_emails', ["sent" => 'No', "errors" => json_encode( $this->CI->email->print_debugger(array('headers')) )]);
            return FALSE;
        }

    }



}
