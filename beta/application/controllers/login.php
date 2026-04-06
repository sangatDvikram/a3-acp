<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('log_model');
        $this->data['js'] = array('login.js');
        $this->data['css'] = array('login.css');
    }

    public function index() {

        $this->data['title'] = "Login To New ACP";
        $this->data['plain_footer'] = '  ';

        //This method will have the credentials validation
        $redirect = $this->session->flashdata('need_redirect');
        // echo $redirect;
        if ($this->input->get('need_login') || $this->input->get('need_access')) {
            $this->data['session'] = "May Be You Dont Have Proper Access to it now !!";
        }
        if ($redirect != '') {
            $this->data['session'] = "May Be You Dont Have Proper Access to it now !!";
            // $redirect = urldecode($this->input->get('redirect', true));
            $this->session->set_flashdata('need_redirect', $redirect);
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

        if ($this->form_validation->run() == FALSE) {
            $this->session->keep_flashdata('need_redirect');
            renderPage('login/index', $this->data);
        } else {

            if ($this->session->flashdata('need_redirect')) {
                redirect(urldecode($this->session->flashdata('need_redirect')));
                return true;
            }

            $grade = $this->session->userdata('grade');

            //Go to private area
            if ($grade == "BAN")
                redirect('admin');
            else
                redirect('guides');
        }
    }

    function check_database($password) {
        //Field validation succeeded.  Validate against database
        $this->load->model('access_model');

        $remove[] = "'";
        $remove[] = '"';
        $remove[] = "-"; // just as another example


        $username = $this->input->post('username', TRUE);
        $username = clean_input("/[^a-zA-Z0-9]/", "", $username);


        $password = $this->input->post('password', TRUE);
        $password = clean_input("/[^a-zA-Z0-9\!\@\#\$%\*\_\.]/", "", $password);

        //query the database
        $result = $this->login_model->login_user($username, $password);
        //Process Your Data Here
        $unban_date = (!isset($result['unban_date'])) ? "" : "<br> Account will automatically unban on $result[unban_date] hrs";

        if ($result) {
            //Get Status from the Database
            $status = $this->access_model->status_info($result['c_status']);
            //is as verifed accout.
            if ($result['verified'] == 1) {

                //Check User Account Status
                if ($status['allow'] == 'TRUE') {
                    $this->login_log($username, $password, 1);
                    $this->session->set_userdata('grade', $result['acc_status']);
                    $this->session->set_userdata('username', $username);
                    $this->session->set_userdata('logged_in', TRUE);
                    $this->session->set_userdata('type', 'player');
                    return TRUE;
                } else {
                    $this->login_log($username, $password, 0);
                    $this->form_validation->set_message('check_database', "$result[msg] $unban_date ");

                    return false;
                }
            } else {
                $this->login_log($username, $password, 0);
                $this->form_validation->set_message('check_database', 'Your Account is not verified!!');
                return false;
            }
        }
        // False Login Attempt
        else {
            // Keep Track of false login log.

            $this->login_log($username, $password, 0);

            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

    function login_log($username, $password, $success = 0) {
        $data = array(
            'ip' => $this->session->userdata('ip_address'),
            'username' => $username,
            'password' => $password,
            'success' => $success,
        );
        $this->log_model->log('login_attempts', $data);
    }

    function logout() {
        // $this->session->unset_userdata('logged_in_user');
        //session_destroy();
        $need_login = $this->session->flashdata('need_login');
        $need_access = $this->session->flashdata('need_access');
        $need_redirect = $this->session->flashdata('need_redirect');


        if ($need_login && $need_redirect) {
            $this->session->set_flashdata('need_redirect', $need_redirect);
            redirect('login?redirect=' . $need_redirect . '');
        } elseif ($need_login) {
            //$this->session->set_userdata('message',"May be you dont have access to this section yet.");
            redirect('login?need_login=1');
        } elseif ($need_access) {
            //$this->session->set_userdata('message',"May be you dont have access to this section yet.");
            redirect('login?need_access=1');
        } else {
            $this->session->sess_destroy();
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
            header('Pragma: no-cache');
            redirect('guides');
        }



        //
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */