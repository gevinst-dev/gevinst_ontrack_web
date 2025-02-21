<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();


		$this->load->model('admin/client_model', 'client');

        $this->load->model('admin/predefined_reply_model', 'predefined_reply');


		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}


    public function predefined_reply_content($id=0) {
        $predefined_reply = $this->predefined_reply->get($id);

        if($predefined_reply) {
            echo $predefined_reply['content'];
        }

    }


	public function items_all() {


		if(!empty($this->input->get("q"))) {

			$parts = explode(" ", $this->input->get("q"));

			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('sku', $this->input->get("q"));
			

			foreach ($parts as $part) {
				$this->db->or_like('sku', $part);
			}

		}

		$query = $this->db->select('id,name,sku')->limit(10)->get("app_items");
		$result = $query->result_array();

		$json = []; $i = 0;
		foreach($result as $item) {
		
			$json[$i]['id'] = $item['id'];
			if($item['sku'] != "") {
				$json[$i]['text'] = $item['name'] . " (" . $item['sku'] . ")";
			} else {
				$json[$i]['text'] = $item['name'];
			}
			$i++;
		}

		echo json_encode($json);
	}


	public function items_all_autocomplete() {
		
		if(!empty($this->input->get("q"))) {

			$parts = explode(" ", $this->input->get("q"));

			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('sku', $this->input->get("q"));
			

			foreach ($parts as $part) {
				$this->db->or_like('sku', $part);
			}

		}

		$query = $this->db->select('id,name,sku')->limit(10)->get("app_items");
		$result = $query->result_array();

		$json = []; $i = 0;
		foreach($result as $item) {
		
			$json[$i]['id'] = $item['id'];
			if($item['sku'] != "") {
				$json[$i]['value'] = $item['name'] . " (" . $item['sku'] . ")";
			} else {
				$json[$i]['value'] = $item['name'];
			}
			$i++;
		}

		echo json_encode($json);
	}

	public function client_overcredit($id) {
		$client = $this->db->get_where('app_clients', ['id' => $id])->row_array();


		if($client['credit_limit'] > 0) {
			$unpaid = client_total_unpaid($id);

			if($unpaid >= $client['credit_limit']) {
				echo 1;
			} else {
				echo 0;
			}

		} else {
			echo 0;
		}

	}

	public function clients_leads_all() {

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('company_taxid', $this->input->get("q"));
		}

		$query = $this->db->select('id,name,type,company_taxid')->limit(10)->get("app_clients");
		$result = $query->result_array();

		$json = []; $i = 0;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['name'] . " - " . __($item['type']) . " (" . $item['company_taxid'] . ")";


			$i++;
		}

		echo json_encode($json);
	}





	public function clients_all() {

		$this->db->where('type', 'Client');
		if(!empty($this->input->get("q"))) {
			$this->db->group_start();
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('company_taxid', $this->input->get("q"));
			$this->db->group_end();
		}

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('company_taxid', $this->input->get("q"));
		}

		$query = $this->db->select('id,name,company_taxid')->limit(10)->get("app_clients");
		$result = $query->result_array();

		$json = []; $i = 0;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['name'] . " (" . $item['company_taxid'] . ")";
			$i++;
		}

		echo json_encode($json);
	}

	public function leads_all() {

		$this->db->where('type', 'Lead');
		if(!empty($this->input->get("q"))) {
			$this->db->group_start();
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('company_taxid', $this->input->get("q"));
			$this->db->group_end();
		}

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('company_taxid', $this->input->get("q"));
		}

		$query = $this->db->select('id,name,company_taxid')->limit(10)->get("app_clients");
		$result = $query->result_array();

		$json = []; $i = 0;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['name'] . " (" . $item['company_taxid'] . ")";
			$i++;
		}

		echo json_encode($json);
	}

	public function suppliers_all() {

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('company_taxid', $this->input->get("q"));
		}

		$query = $this->db->select('id,name,company_taxid')->limit(30)->get("app_suppliers");
		$result = $query->result_array();

		$json = []; $i = 0;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['name'] . " (" . $item['company_taxid'] . ")";
			$i++;
		}

		echo json_encode($json);
	}


	public function users_all() {

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('email', $this->input->get("q"));
		}

		$query = $this->db->select('id,name,email')->limit(30)->get("core_users");
		$result = $query->result_array();

		$json = []; $i = 0;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['name'] . " " . $item['email'];
			$i++;
		}

		echo json_encode($json);
	}



	public function clients_all_none() {

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('company_taxid', $this->input->get("q"));
		}

		$query = $this->db->select('id,name,company_taxid')->limit(10)->get("app_clients");
		$result = $query->result_array();

		$json[0]['id'] = "0";
		$json[0]['text'] = __("- None -");
		$i = 1;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['name'] . " (" . $item['company_taxid'] . ")";
			$i++;
		}

		echo json_encode($json);
	}


	public function users_all_none() {

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('email', $this->input->get("q"));
		}

		$query = $this->db->select('id,name,email')->limit(10)->get("core_users");
		$result = $query->result_array();

		$json[0]['id'] = "0";
		$json[0]['text'] = __("- None -");
		$i = 1;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['name'] . " " . $item['email'];
			$i++;
		}

		echo json_encode($json);
	}



	public function suppliers_all_none() {

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('company_taxid', $this->input->get("q"));
		}

		$query = $this->db->select('id,name,company_taxid')->limit(30)->get("app_suppliers");
		$result = $query->result_array();

		$json[0]['id'] = "0";
		$json[0]['text'] = __("- None -");
		$i = 1;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['name'] . " (" . $item['company_taxid'] . ")";
			$i++;
		}

		echo json_encode($json);
	}


	public function assets_all_none() {

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('tag', $this->input->get("q"));
		}

		$query = $this->db->select('id,name,tag')->limit(30)->get("app_assets");
		$result = $query->result_array();

		$json[0]['id'] = "0";
		$json[0]['text'] = __("- None -");
		$i = 1;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['tag'] . " " . $item['name'];
			$i++;
		}

		echo json_encode($json);
	}


	public function licenses_all_none() {

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));
			$this->db->or_like('tag', $this->input->get("q"));
		}

		$query = $this->db->select('id,name,tag')->limit(30)->get("app_licenses");
		$result = $query->result_array();

		$json[0]['id'] = "0";
		$json[0]['text'] = __("- None -");
		$i = 1;

		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['tag'] . " " . $item['name'];
			$i++;
		}

		echo json_encode($json);
	}


	public function projects_all_none() {

		if(!empty($this->input->get("q"))) {
			$this->db->like('name', $this->input->get("q"));

		}

		$query = $this->db->select('id,name')->limit(30)->get("app_projects");
		$result = $query->result_array();

		$json[0]['id'] = "0";
		$json[0]['text'] = __("- None -");
		$i = 1;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['name'];
			$i++;
		}

		echo json_encode($json);
	}



	public function unpaid_invoices($id=0) {
		$result = $this->db->order_by("date", "asc")->get_where('app_invoices', array('client_id' => $_GET['client_id'], 'unpaid >' => 0))->result_array();

		$json = [];
		$i = 0;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['number'] . " | " . date_display($item['date']) . " (" . format_currency($item['unpaid'], $item['currency_id']) . " ".__('Unpaid').")";
			$i++;
		}

		echo json_encode($json);
	}


	public function unpaid_invoices_edit($id=0) {
		$transaction = $this->db->get_where('app_transactions', array('id' => $_GET['transaction_id']))->row_array();

		$result = $this->db->order_by("date", "asc")->get_where('app_invoices', array('client_id' => $_GET['client_id'], 'unpaid >' => 0))->result_array();

		$json = [];
		$i = 0;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['number'] . " | " . date_display($item['date']);
			$i++;
		}

		if($transaction['client_id'] == $_GET['client_id']) {
			if($transaction['tagged_invoices'] != "") {
				if($transaction['tagged_invoices'] != "N;") {
					$tagged_invoices = unserialize($transaction['tagged_invoices']);
					foreach($tagged_invoices as $tagged_invoice) {
						$invoice = $this->db->get_where('app_invoices', array('id' => $tagged_invoice))->row_array();
						$json[$i]['id'] = $invoice['id'];
						$json[$i]['text'] = $invoice['number'] . " | " . date_display($invoice['date']);
						$i++;
					}
				}
			}
		}

		$json = array_map("unserialize", array_unique(array_map("serialize", $json)));

		echo json_encode($json);
	}



	public function unpaid_purchases($id=0) {
		$result = $this->db->order_by("date", "asc")->get_where('app_purchases', array('supplier_id' => $_GET['supplier_id'], 'unpaid >' => 0))->result_array();

		$json = [];
		$i = 0;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['number'] . " | " . date_display($item['date']) . " (" . format_currency($item['unpaid'], $item['currency_id']) . " ".__('Unpaid').")";
			$i++;
		}

		echo json_encode($json);
	}



	public function unpaid_purchases_edit($id=0) {
		$transaction = $this->db->get_where('app_transactions', array('id' => $_GET['transaction_id']))->row_array();

		$result = $this->db->order_by("date", "asc")->get_where('app_purchases', array('supplier_id' => $_GET['supplier_id'], 'unpaid >' => 0))->result_array();

		$json = [];
		$i = 0;
		foreach($result as $item) {
			$json[$i]['id'] = $item['id'];
			$json[$i]['text'] = $item['number'] . " | " . date_display($item['date']);
			$i++;
		}

		if($transaction['supplier_id'] == $_GET['supplier_id']) {
			if($transaction['tagged_invoices'] != "") {
				if($transaction['tagged_invoices'] != "N;") {
					$tagged_invoices = unserialize($transaction['tagged_invoices']);
					foreach($tagged_invoices as $tagged_invoice) {
						$invoice = $this->db->get_where('app_purchases', array('id' => $tagged_invoice))->row_array();
						$json[$i]['id'] = $invoice['id'];
						$json[$i]['text'] = $invoice['number'] . " | " . date_display($invoice['date']);
						$i++;
					}
				}
			}
		}

		$json = array_map("unserialize", array_unique(array_map("serialize", $json)));

		echo json_encode($json);
	}

}
