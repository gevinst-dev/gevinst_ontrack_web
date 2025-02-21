<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Knowledge_base extends Public_Controller {


	public function __construct()
	{
		parent::__construct();

		
        $this->load->model('admin/knowledge_base_model', 'knowledge_base');

        $this->load->library('datatables');
	}



    public function index()
    {
        if(!isset($_GET['query'])) { $_GET['query'] = ""; }
        $_GET['query'] = html_escape($_GET['query']);

        $data['title'] = __("Knowledge Base");
		$data['page'] = 'user/knowledge_base/index';


        if($this->session->user_signed_in) {

            $this->db->where('status', 'Published');
            $this->db->where_in('access', ['Users', 'Public']);
            $data['categories'] = $this->db->get('app_kb_categories')->result_array();
            

            $this->db->where('featured', 1);
            $this->db->where('status', 'Published');
            $this->db->where_in('access', ['Users', 'Public']);
            $data['featured_articles'] = $this->db->get('app_kb_articles')->result_array();
            



        } else {

            $this->db->where('status', 'Published');
            $this->db->where_in('access', ['Public']);
            $data['categories'] = $this->db->get('app_kb_categories')->result_array();


            $this->db->where('featured', 1);
            $this->db->where('status', 'Published');
            $this->db->where_in('access', ['Public']);
            $data['featured_articles'] = $this->db->get('app_kb_articles')->result_array();
            

        }


        log_user('Viewed knowledge base');





		$this->load->view('user/layout_page', $data);

    }


    public function category($id=0)
    {
        if(!isset($_GET['query'])) { $_GET['query'] = ""; }
        $_GET['query'] = html_escape($_GET['query']);

        $data['category'] = $this->knowledge_base->get_category($id);

        $data['title'] = $data['category']['name'] . " - " . __("Knowledge Base");
		$data['page'] = 'user/knowledge_base/category';


        if($this->session->user_signed_in) {

            $this->db->where('category_id', $id);
            $this->db->where('status', 'Published');
            $this->db->where_in('access', ['Users', 'Public']);
            $data['articles'] = $this->db->get('app_kb_articles')->result_array();
            
        } else {

            $this->db->where('category_id', $id);
            $this->db->where('status', 'Published');
            $this->db->where_in('access', ['Public']);
            $data['articles'] = $this->db->get('app_kb_articles')->result_array();
            
        }

        log_user('Viewed knowledge base category ' . $id);

        $this->load->view('user/layout_page', $data);
    }


    public function article($id=0)
    {
        if(!isset($_GET['query'])) { $_GET['query'] = ""; }
        $_GET['query'] = html_escape($_GET['query']);

        $data['article'] = $this->knowledge_base->get_article($id);

        $data['category'] = $this->knowledge_base->get_category($data['article']['category_id']);

        $data['title'] = $data['article']['name'] . " - " . __("Knowledge Base");
		$data['page'] = 'user/knowledge_base/article';

        log_user('Viewed knowledge base article ' . $id);

        $this->load->view('user/layout_page', $data);
    }



    public function search()
    {
    
        if(!isset($_GET['query'])) { $_GET['query'] = ""; }
        $_GET['query'] = html_escape($_GET['query']);

        $data['title'] = __("Search: ") . $_GET['query'] . " - " . __("Knowledge Base");
		$data['page'] = 'user/knowledge_base/search';

        


        if($this->session->user_signed_in) {

            $this->db->group_start();
            $this->db->like('name', $_GET['query']);
            $this->db->or_like('content', $_GET['query']);
            $this->db->group_end();

            $this->db->where('status', 'Published');
            $this->db->where_in('access', ['Users', 'Public']);
            $data['articles'] = $this->db->get('app_kb_articles')->result_array();
            
        } else {

            $this->db->group_start();
            $this->db->like('name', $_GET['query']);
            $this->db->or_like('content', $_GET['query']);
            $this->db->group_end();

            $this->db->where('status', 'Published');
            $this->db->where_in('access', ['Public']);
            $data['articles'] = $this->db->get('app_kb_articles')->result_array();
            
        }


        log_user('Searched knowledge base ' . $_GET['query']);

        $this->load->view('user/layout_page', $data);
    }




}