<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_page_access(true, null, true);
        $session_data = $this->session->userdata('username');
        $this->data['username'] = $session_data;
        $this->load->model('guide/guide_model');
        $this->load->model('players/players_model');
        $this->load->model('log_model');
        $this->option['max_guide'] = 3;
    }

    public function index() {

        $this->writter();
    }

    public function itemcode() {

        $item_info = get_item_options('230542;4294951423;923857363');
        echo "Item Code : 0;0;0;";
        echo "<pre>";
        print_r($item_info);
        echo "</pre>";
        $item_info = get_item_options("17;1647986;900235492");
        echo "Item Code : 17;1647986;900235492";

        echo "<pre>";
        print_r($item_info);
        echo "</pre>";

        echo "<em>{elapsed_time}</em>";
    }

    public function wearinfo() {
        $this->load->model('admin_model');

        $character_details = $this->admin_model->getCharacterDetails("ConstanTine");
        $character_wear = get_mbody_part('WEAR', $character_details['m_body']);

        $wears = get_wear_item($character_wear);

        $output = array();
        foreach ($wears as $key => $value) {
            if ($value == "0;0;0;")
                $output[$key] = get_item_options($value);
            else
                $output[$key] = $value;
        }
        ksort($output);
        echo "<pre>";
        print_r($output);
        echo "</pre>";
    }

    public function currency($amount) {

        $amount = urlencode($amount);
        $from_Currency = urlencode('USD');
        $to_Currency = urlencode('INR');
        $get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
        $get = explode("<span class=bld>", $get);
        $get = explode("</span>", $get[1]);
        $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
        echo "<pre>Converting $amount $from_Currency to $to_Currency <br>Your Converted amount is :";
        print_r($converted_amount);
        echo "/- Rs Only </pre>";
    }

    public function writter() {

        $this->load->library('form_validation');
        $this->data['title'] = "Writing Pluging For players";
        $this->data['js'] = array("tinymce/tinymce.min.js", "guide/writer.js");
        $this->data['menu'] = "/menu/index";
        $this->data['categories'] = $this->guide_model->get_enabled_category_list();
        $poster = $this->players_model->get_top_chatacter_from_account();
        $this->data['poster'] = $poster['c_id'];
        $count = $this->guide_model->get_player_guide_count();
        $this->data['guide_count'] = $this->option['max_guide'] - $count['count'];
        if ($this->data['guide_count'] <= 0) {
            $this->data['max_count_reached'] = 1;
        }
        if ($_POST && $this->data['guide_count'] > 0) {

            $this->form_validation->set_rules('guide_title', 'Guide Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('category_id', 'Category', 'trim|required|xss_clean');
            $this->form_validation->set_rules('guide_title', 'Category', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                renderPage('test/writter', $this->data);
            } else {
                $data['guide_title'] = $this->input->post('guide_title', true);
                $data['category_id'] = $this->input->post('category_id', true);
                $data['username'] = $this->session->userdata('username');
                $poster = $this->players_model->get_top_chatacter_from_account();
                $data['playername'] = rtrim($poster['c_id']);
                $data['guide_body'] = $this->input->post('guide_body', TRUE);
                $data['guide_link'] = url_title($data['guide_title'], 'dash', TRUE);
                $data['verified'] = "0";
                $this->guide_model->insert_new_game_guide($data);
                $log_data = array(
                    'username' => $this->session->userdata('username'),
                    'page' => current_url(),
                    'action' => "$data[playername] has added new game guide !!",
                    'ip' => $this->session->userdata('ip_address')
                );
                $this->log_model->log('log_player_action', $log_data);
                $this->data['return'] = "Guide has been sent for verification";
            }
        }
        $count = $this->guide_model->get_player_guide_count();
        $this->data['guide_count'] = $this->option['max_guide'] - $count['count'];
        if ($this->data['guide_count'] <= 0) {
            $this->data['max_count_reached'] = 1;
        }
        renderPage('test/writter', $this->data);
    }

    public function email() {

        $this->subject = 'You have sent email successfully #123123' . rand(1, 15);
        $this->message = 'send email please ? ';


        send_email_to(getenv('MAIL_TO'), $this->subject, $this->message);
    }

    public function pages() {
        
        $this->load->library('pagination');
/*example*/
        $config['base_url'] = 'http://example.com/index.php/test/page/';
        $config['total_rows'] = 200;
        $config['per_page'] = 200;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['num_links'] = 3;
        $config['use_page_numbers'] = TRUE;
        
 
                
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['first_link'] = 'First';
        
        $config['last_link'] = 'Last';
        
        $config['next_link'] = '<i class="mdi-navigation-chevron-right"></i>';
        $config['next_tag_open'] = '<li class="waves-effect">';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = '<i class="mdi-navigation-chevron-right"></i>';
        $config['prev_tag_open'] = '<li class="waves-effect">';
        $config['prev_tag_close'] = '</li>';
        
        $config['num_tag_open'] = '<li class="waves-effect">';
        
        $config['num_tag_close'] = '</li>';
        
        $config['cur_tag_open'] = '<li class="active">';
        
        $config['cur_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        echo "<pre>";
        echo $this->pagination->create_links();
        echo "</pre>";
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */