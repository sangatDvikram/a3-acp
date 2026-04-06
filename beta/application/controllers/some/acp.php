<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acp extends CI_Controller {

   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }
    public function index()
    {
        $status=$this->session->userdata('logged_in');
        if($status=='1')
       {
            $session_data = $this->session->userdata('username');
            $data['username'] = $session_data;
            $data['title']="Welcome To ACP Panal";
            $data['css']=array('admin.css');
            renderPage('admin/index',$data);
       }
       else
       {
         //If no session, redirect to login page
        //print_r($status);    
         redirect('login', 'refresh');
       }
        
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */