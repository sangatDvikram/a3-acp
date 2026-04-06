<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function payment_success($formated = null) {
        if (!$formated) {
            $this->load->view('/email_templates/payment_success');
        } else {
            $this->load->view('/email_templates/payment_success_formated');
        }
    }

    public function payment_receive($formated = null) {
        if (!$formated) {
            $this->load->view('/email_templates/payment_information');
        } else {
            $this->load->view('/email_templates/payment_information_formated');
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */