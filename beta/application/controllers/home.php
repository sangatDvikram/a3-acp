<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['js'] = array();
        $this->data['css'] = array();
        $this->data['menu']="/menu/index";
        check_page_access(null, null, true);
    }
    public function index()
    {
        $this->data['title']="Welcome to A3ultimate Beta version";
        renderPage('home/index',$this->data);
    }
    public function materialhome()
    {
        $this->data['title']="Welcome to A3ultimate material version";
        array_push($this->data['css'], "material/home/styles.css");
        renderMaterialPage('home/home',$this->data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */