<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class empty_class extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_page_access(true, null, true);
         $this->data['js'] = array();
        $this->data['css'] = array();
        $this->data['menu']="/menu/index";
        check_page_access(null, null, true);
    }

    public function index() {
        
        $this->data['title'] = "Welcome To Empty Panel";
        
       renderPage('empty/index', $this->data);
       
    }  public function temp() {
       
        $this->data['title'] = "Welcome To Empty Panel";
        
       renderPage('empty/index', $this->data);
       
    }

   

}