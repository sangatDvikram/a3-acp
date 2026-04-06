<?php

require(APPPATH . 'libraries/REST_Controller.php');

class Login extends REST_Controller {
 
    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('log_model');
    }

    function loginplayers_post() {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

        $output = array('error' => '', 'success' => '0');

        if ($this->form_validation->run() == FALSE) {
            // Login Failed
            $output['error'] = validation_errors();

            $output['error'] = str_replace("<br>", "-", $output['error']);
        } else {
            // Login Sucess
            $output['success'] = '1';
        }

        $this->response($output);
    }

    function check_database($password) {

        //Field validation succeeded.  Validate against database
        $this->load->model('access_model');

        $username = $this->input->post('username', TRUE);
        $username = clean_input("/[^a-zA-Z0-9]/", "", $username);

        $password = $this->input->post('password', TRUE);
        $password = clean_input("/[^a-zA-Z0-9\!\@\#\$%\*\_\.]/", "", $password);

        //query the database
        $result = $this->login_model->login_user($username, $password);
        //Process Your Data Here
        $unban_date = (!isset($result['unban_date'])) ? "" : "Account will automatically unban on $result[unban_date] hrs";

        if ($result) {
            //Get Status from the Database
            $status = $this->access_model->status_info($result['c_status']);
            //is as verifed accout.
            if ($result['verified'] == 1) {

                //Check User Account Status
                if ($status['allow'] == 'TRUE') {
                    $this->loginlog($username, $password, 1);
                    $this->session->set_userdata('grade', $result['acc_status']);
                    $this->session->set_userdata('username', $username);
                    $this->session->set_userdata('logged_in', TRUE);
                    $this->session->set_userdata('type', 'player');
                    return TRUE;
                } else {
                    $this->loginlog($username, $password, 0);
                    $this->form_validation->set_message('check_database', "$result[msg] $unban_date ");

                    return false;
                }
            } else {
                $this->loginlog($username, $password, 0);
                $this->form_validation->set_message('check_database', 'Your Account is not verified!!');
                return false;
            }
        }
        // False Login Attempt
        else {
            // Keep Track of false login log.

            $this->loginlog($username, $password, 0);

            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

    function loginlog($username, $password, $success = 0) {
        $data = array(
            'ip' => $this->session->userdata('ip_address'),
            'username' => $username,
            'password' => $password,
            'success' => $success,
        );
        $this->log_model->log('login_attempts', $data);
    }

    function logout_post() {
        $this->session->sess_destroy();
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        header('Pragma: no-cache');

        $output=array('success'=>1);

        $this->response($output);
    }

}
