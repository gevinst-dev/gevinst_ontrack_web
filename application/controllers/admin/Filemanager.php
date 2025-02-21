<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filemanager extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('filemanager');
	}



	public function index()
	{
		$data['title'] = __("File Manager");
		$data['page'] = 'admin/filemanager';

        $this->load->helper('url');
        $data['connector'] = site_url() . 'admin/filemanager/connector';



		$this->load->view('admin/layout_page', html_escape($data));
	}





    public function connector()
    {
        $this->load->helper('url');

        $opts = array(
            'roots' => array(
                array( 
                    'alias' => 'Files',
                    'driver'        => 'LocalFileSystem',
                    'path'          => FCPATH . '/filestore/manager',
                    'URL'           => base_url('filestore/manager'),
                    'accessControl' => array($this, 'elfinderAccess'),// disable and hide dot starting files (OPTIONAL)
                ) 
            ),
        );
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
    }
    
    public function elfinderAccess($attr, $path, $data, $volume, $isDir, $relpath)
    {
        $basename = basename($path);
        return $basename[0] === '.'                  // if file/folder begins with '.' (dot)
                 && strlen($relpath) !== 1           // but with out volume root
            ? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
            :  null;                                 // else elFinder decide it itself
    }


}
