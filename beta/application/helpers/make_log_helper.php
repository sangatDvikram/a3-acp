<?php
if ( ! function_exists('create_admin_log')) {

    /**
     * 
     * @param string $message Add your personalised message 
     */
    function create_admin_log($message){

        $ci = &get_instance();
        $ci->load->model('log_model');
        $log_data = array(
            'username' => $ci->session->userdata('username'),
            'page' => current_url(),
            'action' => $message,
            'ip' => $ci->session->userdata('ip_address')
        );
        $ci->log_model->log('log_admin_action', $log_data);
    }
}

if ( ! function_exists('create_player_log')) {

    /**
     * 
     * @param string $message Add your personalised message 
     */
    function create_player_log($message){

        $ci = &get_instance();
        $ci->load->model('log_model');
        $log_data = array(
            'username' => $ci->session->userdata('username'),
            'page' => current_url(),
            'action' => $message,
            'ip' => $ci->session->userdata('ip_address')
        );
        $ci->log_model->log('log_player_action', $log_data);
    }
}