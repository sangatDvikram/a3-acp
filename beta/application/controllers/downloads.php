<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class downloads extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_page_access(true, null, true);
         $this->data['js'] = array();
        $this->data['css'] = array();
        $this->data['menu']="/menu/index";
        check_page_access(null, null, true);
    }

    public function index() {
        
        $this->data['title'] = "Welcome To Download Panel";
        $this->data['whatever'] = "Welcome To Download Panel";
        
       renderPage('downloads/index', $this->data);
       
    }  public function temp() {
       
        $this->data['title'] = "Welcome To Download Panel";
        
       renderPage('downloads/index', $this->data);
       
    }

   

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */