<?php
if ( ! function_exists('send_email_to')) {

    function send_email_to($to,$subject,$message){

        $ci = &get_instance();
        
        $ci->load->library('email');
        
        $ci->email->from('notify@a3ultimate.com', 'Team Ultimate');
        $ci->email->to($to);
        $ci->email->cc('notify@a3ultimate.com');
        //$this->email->bcc('them@their-example.com');
        //log_message("error","Mail Sent With Boby : ".$message,true);
        $ci->email->subject($subject);
        $ci->email->message($message);
 
        $ci->email->send();

    }
}