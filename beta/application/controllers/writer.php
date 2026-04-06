<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Writer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_page_access(true, null, true);
        $session_data = $this->session->userdata('username');
        $this->data['username'] = $session_data;
        $this->load->model('guide/guide_model');
        $this->load->model('players/players_model');
        $this->load->model('log_model');
        $this->option['max_guide'] = 3;
        $this->data['menu'] = "/menu/index";
        $this->data['css'] = array('writer.css');
        $this->load->library('form_validation');
    }

    public function index() {

        $this->create();
    }

    public function create() {


        $this->data['title'] = "Writing Pluging For players";
        $this->data['js'] = array("tinymce/tinymce.min.js", "guide/writer.js");
        
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
            $this->form_validation->set_rules('guide_body', 'Guide Body', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                renderPage('writer/writer', $this->data);
                return false;
            } else {
                $data['guide_title'] = $this->input->post('guide_title', true);
                $data['guide_title'] = clean_input("/[^a-zA-Z0-9\s]/", "", $data['guide_title']);
                $data['category_id'] = $this->input->post('category_id', true);
                $data['category_id'] = clean_input("/[^0-9]/", "", $data['category_id']);
                $data['username'] = $this->session->userdata('username');
                $poster = $this->players_model->get_top_chatacter_from_account();
                $data['playername'] = rtrim($poster['c_id']);
                $data['playername'] = clean_input("/[^a-zA-Z0-9]{1,}/", "", $data['playername']);
                $data['guide_body'] = $this->input->post('guide_body', TRUE);
                $data['guide_link'] = url_title($data['guide_title'], 'dash', TRUE);
                $data['verified'] = "0";
                $this->guide_model->insert_new_game_guide($data);

                create_player_log("$data[playername] has added new game guide !!");

                $this->data['return'] = "Guide has been sent for verification. <br> Take a look <b><a href = '" . site_url('ingameguide') . "/$data[guide_link]'>here</a></b>";
            }
        }
        $count = $this->guide_model->get_player_guide_count();
        $this->data['guide_count'] = $this->option['max_guide'] - $count['count'];
        if ($this->data['guide_count'] <= 0) {
            $this->data['max_count_reached'] = 1;
        }
        renderPage('writer/writer', $this->data);
    }

    public function edit($link = null) {
        $this->data['title'] = "Edit Submited Game Guide";
        $this->data['js'] = array("tinymce/tinymce.min.js", "guide/edit.js", "jquery.dataTables.min.js");
        array_push($this->data['css'], "jquery.dataTables.css");
        


        if ($_POST) {

            $this->form_validation->set_rules('guide_title', 'Guide Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('category_id', 'Category', 'trim|required|xss_clean');
            $this->form_validation->set_rules('guide_body', 'Guide Body', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                renderPage('writer/edit', $this->data);
                return false;
            } else {
                $data['guide_title'] = $this->input->post('guide_title', true);
                $data['guide_title'] = clean_input("/[^a-zA-Z0-9\s]/", "", $data['guide_title']);
                $data['category_id'] = $this->input->post('category_id', true);
                $data['category_id'] = clean_input("/[^0-9]/", "", $data['category_id']);
                $data['username'] = $this->session->userdata('username');
                $poster = $this->players_model->get_top_chatacter_from_account();
                $data['playername'] = rtrim($poster['c_id']);
                $data['playername'] = clean_input("/[^a-zA-Z0-9]{1,}/", "", $data['playername']);
                $data['guide_body'] = $this->input->post('guide_body', TRUE);
                $data['guide_link'] = url_title($data['guide_title'], 'dash', TRUE);
                $where = array('guide_link' => $link, 'username' => $this->data['username']);
                $this->guide_model->update_game_guide_where($where, $data);
                create_player_log("$data[playername] updated game guide <a href='" . site_url('ingameguide') . "/$data[guide_link]'>here</a>!!");

                $this->data['return'] = "Guide has edited successfully";
            }
        }

        if (isset($link)) {
            $this->data['editor'] = 1;
            $data = $this->guide_model->get_game_guide_details_with_category($link);
            $user = $this->session->userdata('username');
            if ($data['username'] == $user) {
                $this->data['game_guide_data'] = $data;
            }

            renderPage('writer/edit', $this->data);
        } else {
            renderPage('writer/edit', $this->data);
        }
    }

    public function status() {
        
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */