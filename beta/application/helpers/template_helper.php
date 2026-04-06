<?php
if ( ! function_exists('renderPage')) {
    function renderPage($view,$data){
        $ci = &get_instance();
        
        $login=$ci->session->userdata('logged_in');

        if($login)
        	{
        	 $ci->session->set_userdata('type', 'guest'); 
        	}


        $ci->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $ci->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $ci->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $ci->output->set_header("Pragma: no-cache");



        $ci->load->view('/template/header',$data);
        $ci->load->view($view,$data);
        $ci->load->view('/template/footer',$data);


    }
}

if ( ! function_exists('renderMaterialPage')) {
    function renderMaterialPage($view,$data){
        $ci = &get_instance();
        
        $login=$ci->session->userdata('logged_in');

        if($login)
        	{
        	 $ci->session->set_userdata('type', 'guest'); 
        	}


        $ci->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $ci->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $ci->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $ci->output->set_header("Pragma: no-cache");



        $ci->load->view('/template/google-material/material-header',$data);
        $ci->load->view($view,$data);
        $ci->load->view('/template/google-material/material-footer',$data);


    }
}