<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payment extends CI_Controller {

    var $payment=array(
        'paypal'=>array(
            "sandbox_paypal_url"=>'https://www.sandbox.paypal.com/cgi-bin/webscr',
            "paypal_url"=>'https://www.paypal.com/cgi-bin/webscr',
            "sandbox"=>false,
            "paypal_id"=>getenv('PAYPAL_EMAIL')
        )
    );
    
    

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->data['js']=array('payment.js');
        $this->data['menu'] = "/menu/index";
        check_page_access(true, null, true);
    }
    public function index()
    {
        $this->load->helper('string');
        if($this->payment['paypal']['sandbox'])
        $this->data['checkout_url']=$this->payment['paypal']['sandbox_paypal_url'];
        else
        $this->data['checkout_url']=$this->payment['paypal']['paypal_url'];
        
        $this->data['paypal_id']=$this->payment['paypal']['paypal_id'];
        
        $this->data['transaction_id']= substr(random_string('sha1', 8),0,15);
        
        $this->data['title']="Payment Getway for Eshop";
         $data=  $this->input->get();
        if(isset($data))
            {
            
             if(isset($data['cancle']))
                 {
                 $this->data['errors']='<div class="card-panel red lighten-1 center-align flow-text">Payment has been cancled!!</div>';
                 }
            }
        
        renderPage('payment/index',$this->data);
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */