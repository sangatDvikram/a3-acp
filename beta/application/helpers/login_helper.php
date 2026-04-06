<?php

if (!function_exists('validate_login_status')) {

    function validate_login_status($input = null) {

        $ci = &get_instance();
        //$ci->load->model('crafting_model');

        $login = $ci->session->userdata('logged_in');
        $grade = $ci->session->userdata('grade');
        if ($input == null) {
            if ($login)
                return TRUE;
        }
        else {
            if (isset($input) && $input == $grade && $login) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

}

if (!function_exists('check_page_access')) {

    function check_page_access($need_login=false,$user_grade=null,$need_redirect=false) {

        $ci = &get_instance();
        //$ci->load->model('crafting_model');

        $login = $ci->session->userdata('logged_in');
        $grade = $ci->session->userdata('grade');
        if($need_redirect){
            $ci->session->set_flashdata('need_redirect', urlencode(current_url()));
        }
        if ($need_login&&!$login) {  
            $ci->session->set_flashdata('need_login', '1');
            redirect('login/logout');
        }
        if(isset($user_grade)&&$grade!=$user_grade){
            $ci->session->set_flashdata('need_access', '1');
            redirect('login/logout');
        }
    }

}