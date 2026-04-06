<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Restore extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['js'] = array('restore/restore.js');
        $this->data['css'] = array();
        //$this->data['menu'] = "/menu/index";
    }

    public function index() {

        $this->data['title'] = "Restore your password";

        renderPage('restore/index', $this->data);
    }

    public function temp() {

        $this->data['title'] = "Welcome To Empty Panel";

        renderPage('empty/index', $this->data);
    }

}
