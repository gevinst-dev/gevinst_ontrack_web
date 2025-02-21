<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends User_Controller {

	public function __construct()
	{
		parent::__construct();

        

		$this->load->model('admin/setting_model', 'setting');
        $this->load->model('admin/customfield_model', 'customfield');
        $this->load->model('admin/attribute_model', 'attribute');
        $this->load->model('admin/user_model', 'user');
        $this->load->model('admin/staff_model', 'staff');

		$this->load->model('admin/asset_model', 'asset');
		$this->load->model('admin/license_model', 'license');
		$this->load->model('admin/domain_model', 'domain');
		$this->load->model('admin/credential_model', 'credential');
        $this->load->model('admin/project_model', 'project');

        $this->load->model('admin/invoice_model', 'invoice');
        $this->load->model('admin/proforma_model', 'proforma');
        $this->load->model('admin/proposal_model', 'proposal');
        $this->load->model('admin/receipt_model', 'receipt');

        $this->load->model('admin/client_model', 'client');

		$this->load->library('datatables');
	}




    public function json_invoices() {
        
        enforce_user_permission('invoices');

		$this->datatables
			->select('app_invoices.id, app_invoices.currency_id, app_invoices.number, app_invoices.date, app_invoices.due_date, app_invoices.value, app_invoices.tax, app_invoices.total, app_invoices.unpaid, app_invoices.status')
			->from('app_invoices')
            ->where('app_invoices.client_id', $this->session->client_id)
            ->where('app_invoices.status !=', "Draft")

			->join('app_clients', 'app_invoices.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('core_staff', 'app_invoices.added_by = core_staff.id', 'LEFT')
            ->select('core_staff.name as agent_name')

            ->join('app_entities', 'app_invoices.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')


			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Canceled").'</span>', '', 'Canceled')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Valid").'</span>', '', 'Valid')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Draft").'</span>', '', 'Draft')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
                    '<button data-modal="billing/view_invoice/$1" data-toggle="tooltip" title="'.__("View Invoice").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.


                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['date'] = date_display($value['date']);
            $results['data'][$key]['due_date'] = date_display($value['due_date']);




            $results['data'][$key]['value'] = format_currency($value['value'], $value['currency_id']);
            $results['data'][$key]['tax'] = format_currency(round($value['tax'],2), $value['currency_id']);
            $results['data'][$key]['total'] = format_currency($value['total'], $value['currency_id']);

            if($value['unpaid'] > 0) {
                $results['data'][$key]['unpaid'] = '<span class="text-danger">' . format_currency($value['unpaid'], $value['currency_id']) . '</span>';
            } else {
                $results['data'][$key]['unpaid'] = format_currency($value['unpaid'], $value['currency_id']);
            }



        }

        echo json_encode($results);

	}




    public function json_proformas() {

        enforce_user_permission('proformas');

		$this->datatables
			->select('app_proformas.id, app_proformas.currency_id, app_proformas.number, app_proformas.date, app_proformas.due_date, app_proformas.value, app_proformas.tax, app_proformas.total, app_proformas.unpaid, app_proformas.status')
			->from('app_proformas')
            ->where('app_proformas.client_id', $this->session->client_id)
            ->where('app_proformas.status !=', "Draft")

			->join('app_clients', 'app_proformas.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('core_staff', 'app_proformas.added_by = core_staff.id', 'LEFT')
            ->select('core_staff.name as agent_name')

            ->join('app_entities', 'app_proformas.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')


			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Canceled").'</span>', '', 'Canceled')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Valid").'</span>', '', 'Valid')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Draft").'</span>', '', 'Draft')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
                    '<button data-modal="billing/view_proforma/$1" data-toggle="tooltip" title="'.__("View Proforma").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.




                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['date'] = date_display($value['date']);
            $results['data'][$key]['due_date'] = date_display($value['due_date']);




            $results['data'][$key]['value'] = format_currency($value['value'], $value['currency_id']);
            $results['data'][$key]['tax'] = format_currency(round($value['tax'],2), $value['currency_id']);
            $results['data'][$key]['total'] = format_currency($value['total'], $value['currency_id']);

            if($value['unpaid'] > 0) {
                $results['data'][$key]['unpaid'] = '<span class="text-danger">' . format_currency($value['unpaid'], $value['currency_id']) . '</span>';
            } else {
                $results['data'][$key]['unpaid'] = format_currency($value['unpaid'], $value['currency_id']);
            }



        }

        echo json_encode($results);

	}






    public function json_proposals() {
      
        enforce_user_permission('proposals');

		$this->datatables
			->select('app_proposals.id, app_proposals.currency_id, app_proposals.number, app_proposals.date, app_proposals.valid_until, app_proposals.total, app_proposals.status')
			->from('app_proposals')
            ->where('app_proposals.client_id', $this->session->client_id)
            ->where('app_proposals.status !=', 'Draft')

			->join('app_clients', 'app_proposals.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('app_entities', 'app_proposals.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')

			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Draft").'</span>', '', 'Draft')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Sent").'</span>', '', 'Sent')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Accepted").'</span>', '', 'Accepted')
            ->edit_column_if('status', '<span class="label label-inverse-info-border">'.__("Canceled").'</span>', '', 'Canceled')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

                    '<button data-modal="billing/view_proposal/$1" data-toggle="tooltip" title="'.__("View Proposal").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
				


                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['date'] = date_display($value['date']);
            $results['data'][$key]['valid_until'] = date_display($value['valid_until']);


            $results['data'][$key]['total'] = format_currency($value['total'], $value['currency_id']);
        }

        echo json_encode($results);

	}



	public function json_receipts() {

        enforce_user_permission('receipts');


		$this->datatables
			->select('app_receipts.id, app_receipts.currency_id, app_receipts.date, app_receipts.amount, app_receipts.reference, app_receipts.status')

			->from('app_receipts')
            ->where('app_receipts.client_id', $this->session->client_id)
            ->where('app_receipts.status', 'Valid')


			->join('app_paymentmethods', 'app_receipts.paymentmethod_id = app_paymentmethods.id', 'LEFT')
			->select('app_paymentmethods.name as paymentmethod_name')

			->join('app_clients', 'app_receipts.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')


			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Canceled").'</span>', '', 'Canceled')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Valid").'</span>', '', 'Valid')

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

            
					'<button data-modal="billing/view_receipt/$1" data-toggle="tooltip" title="'.__("View Receipt").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
					
				'</div>',
				'id'
			);

			$results = $this->datatables->generate('json');
			$results = json_decode($results, TRUE);

			foreach($results['data'] as $key => $value) {
				$results['data'][$key]['date'] = date_display($value['date']);

				$results['data'][$key]['amount'] = format_currency($value['amount'], $value['currency_id']);
			}

			echo json_encode($results);

	}



	public function invoices()
	{
        enforce_user_permission('invoices');

		$data['title'] = __("Invoices");
		$data['page'] = 'user/billing/invoices';

        log_user('Viewed invoices');


		$this->load->view('user/layout_page', html_escape($data));

	}

    public function proformas()
	{
        enforce_user_permission('proformas');

		$data['title'] = __("Proformas");
		$data['page'] = 'user/billing/proformas';

        log_user('Viewed proformas');

		$this->load->view('user/layout_page', html_escape($data));

	}

    public function proposals()
	{
        enforce_user_permission('proposals');

		$data['title'] = __("Proposals");
		$data['page'] = 'user/billing/proposals';

        log_user('Viewed proposals');

		$this->load->view('user/layout_page', html_escape($data));

	}


    public function receipts()
	{
        enforce_user_permission('receipts');

		$data['title'] = __("Receipts");
		$data['page'] = 'user/billing/receipts';

        log_user('Viewed receipts');

		$this->load->view('user/layout_page', html_escape($data));

	}



    public function view_invoice($id=0)
    {
        enforce_user_permission('invoices');

        
        log_user('Viewed invoice ' . $id);

        $data['invoice'] = $this->invoice->get($id);
        $data['invoice_items'] = $this->invoice->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['invoice']['currency_id']);

        if($this->session->client_id != $data['invoice']['client_id']) die('Unauthorized!');

        $data['title'] = __("View Invoice");
        $data['modal'] = 'user/billing/view_invoice';

        $this->load->view('user/layout_modal', html_escape($data));


    }


    public function view_proforma($id=0)
    {
        enforce_user_permission('proformas');

        log_user('Viewed proforma ' . $id);

        $data['proforma'] = $this->proforma->get($id);
        $data['proforma_items'] = $this->proforma->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proforma']['currency_id']);

        if($this->session->client_id != $data['proforma']['client_id']) die('Unauthorized!');

        $data['title'] = __("View Proforma");
        $data['modal'] = 'user/billing/view_proforma';

        $this->load->view('user/layout_modal', html_escape($data));


    }



    public function view_proposal($id=0)
	{
        enforce_user_permission('proposals');

        log_user('Viewed proposal ' . $id);

        $data['proposal'] = $this->proposal->get($id);
        $data['proposal_items'] = $this->proposal->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proposal']['currency_id']);

        if($this->session->client_id != $data['proposal']['client_id']) die('Unauthorized!');

		$data['title'] = __("View Proposal");
		$data['modal'] = 'user/billing/view_proposal';

		$this->load->view('user/layout_modal', html_escape($data));


	}

  
    public function view_receipt($id=0)
	{
        enforce_user_permission('receipts');

        log_user('Viewed receipt ' . $id);

        $data['receipt'] = $this->receipt->get($id);
        $data['currency'] = $this->setting->get_currency($data['receipt']['currency_id']);

        if($this->session->client_id != $data['receipt']['client_id']) die('Unauthorized!');


		$data['title'] = __("View Receipt");
		$data['modal'] = 'user/billing/view_receipt';

		$this->load->view('user/layout_modal', html_escape($data));


	}





    public function invoice_pdf($method='',$ids_string='')
    {
        enforce_user_permission('invoices');

        log_user('Viewed invoice PDF ' . $ids_string);

        if($method == "") {
            $method =  $this->uri->segment(3);


        }

        if($ids_string == "") {
            $ids_string =  $this->uri->segment(4);
        }



        $invoice = $this->invoice->get($ids_string);
        if($this->session->client_id != $invoice['client_id']) die('Unauthorized!');

        $this->invoice->pdf($method, $ids_string);


    }


    public function proforma_pdf($method='',$ids_string='')
    {
        enforce_user_permission('proformas');

        log_user('Viewed proforma PDF ' . $ids_string);

        if($method == "") {
            $method =  $this->uri->segment(3);
        }

        if($ids_string == "") {
            $ids_string =  $this->uri->segment(4);
        }

        $proforma = $this->proforma->get($ids_string);
        if($this->session->client_id != $proforma['client_id']) die('Unauthorized!');

        $this->proforma->pdf($method, $ids_string);

    }



    public function proposal_pdf($method='',$ids_string='')
    {
        enforce_user_permission('proposals');

        log_user('Viewed proposal PDF ' . $ids_string);

        if($method == "") {
            $method =  $this->uri->segment(3);
        }

        if($ids_string == "") {
            $ids_string =  $this->uri->segment(4);
        }

        $proposal = $this->proposal->get($ids_string);
        if($this->session->client_id != $proposal['client_id']) die('Unauthorized!');

        $this->proposal->pdf($method, $ids_string);


    }


    public function receipt_pdf($method='',$ids_string='')
    {
        enforce_user_permission('receipts');

        log_user('Viewed receipt PDF ' . $ids_string);

        if($method == "") {
            $method =  $this->uri->segment(3);
        }

        if($ids_string == "") {
            $ids_string =  $this->uri->segment(4);
        }

        $receipt = $this->receipt->get($ids_string);
        if($this->session->client_id != $receipt['client_id']) die('Unauthorized!');

        $this->receipt->pdf($method, $ids_string);


    }



}