<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Game extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('game/game_model');
        $this->data['js'] = array();
        $this->data['css'] = array();
        $this->load->model('players/players_model');
    }

    public function index() {
        
    }

    public function homepageshout() {
        if ($this->session->userdata('logged_in')) {
            $this->data['poster'] = $this->players_model->get_top_chatacter_from_account();
        }
        $this->data['title'] = "InGame shouts panel ";
        array_push($this->data['css'], "game/homepageshout.css");
        array_push($this->data['js'], "game/homepageshouts.js");
        $this->data['plain_footer'] = '  ';

        renderPage('game/homepageshout', $this->data);
    }

    public function webchat() {

        check_page_access(true, null, true);
        $this->data['title'] = "Home - InGame Chat panel ";
        array_push($this->data['css'], "game/webchat.css");
        array_push($this->data['js'], "history/jquery.history.js","game/webchat.js");
        $this->data['plain_footer'] = '  ';

        if (!empty($_POST)) {


            $character = $this->input->post('character', TRUE);
            $character = clean_input("/[^a-zA-Z0-9]/", "", $character);


            if (character_exist_in_account($character)) {

                $this->session->set_userdata('chatcharacter', $character);
            } else {
                $this->data['chat_error'][] = "Selected character not exist in your account";
            }
        }










        $this->data['charcharacter'] = $this->session->userdata('chatcharacter');
        //When Character Is selected
        if (isset($this->data['charcharacter']) && $this->data['charcharacter'] != '') {
           
            $this->data['append_manual_sctript_to_footer'] = "$(document).ready(function(){
                                                            $('.webchat').fadeIn();
                                                            get_char_chat_list();
                                                           /* $(window).bind('beforeunload', function(event) {
           // return confirm(\"Do you really want to close?\");
            return 'Are you sure you want to leave?';
            event.preventDefault();
        });
window.onbeforeunload = function(e) {
  return 'Webchat will close now.';
};*/
                                                         });
 
";
        } else {
            $this->data['account_characters'] = $this->players_model->get_current_account_characters();

            $this->data['append_manual_sctript_to_footer'] = "$(document).ready(function(){
                                                            $('#modal1').openModal();
                                                         });";
        }
        renderPage('game/webchat', $this->data);
    }

    public function change() {
        check_page_access(true);
        try {
            $array_items = array('chatcharacter' => '', 'chatting_with' => '');
            $this->session->unset_userdata('active');
            $this->session->set_userdata('chatcharacter',NULL);
        } catch (Exception $e) {
            print_r($e);
        }
        redirect('game/webchat');
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */