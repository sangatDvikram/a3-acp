<?php

if (!function_exists('clean_input')) {

    function clean_input($match_pattern, $replace_string, $source_string) {

            $ci = &get_instance();
            
        $formated_string = preg_replace($match_pattern, $replace_string, $source_string);

        if ($formated_string != $source_string) {
               log_message("error","Possible sql injection detected ['$source_string'] has been formated to ['$formated_string'] on page ".  current_url()."  by ip -> ".$ci->session->userdata('ip_address'),true);
        }
        
        return $formated_string;
    }

}