<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acp extends CI_Controller {

   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }
    public function index()
    {
        echo '<html><head><title>On My Way - A3ultimate.com</title></head><style>html { 
  background: url(http://pakclothstore.com/2.png) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}</style><body></body></html>';
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */