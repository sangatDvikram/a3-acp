<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('log_model');
        check_page_access(true, 'BAN', true);
        $this->data['js'] = array('admin.js');
        $this->data['css'] = array('admin.css');
        $this->data['menu'] = "/template/admin_menu";
        $session_data = $this->session->userdata('username');
        $this->data['username'] = $session_data;
        $this->load->library('form_validation');
    }

    public function index() {

        $this->data['title'] = "Welcome To Admin Panel";

        array_push($this->data['js'], "admin/index.js");
        renderPage('admin/index', $this->data);
    }

    /* ---------------------------------------------------------------------------------------------------------------------
     *
     *
     *
     * WEB DATA SECTION
     *
     *
     *
     * --------------------------------------------------------------------------------------------------------------------
     * */

    public function web() {
        $this->data['title'] = "Web Data Panel";
        $this->data['sidemenu'] = "/admin/utilities/side_menu";




        renderPage('admin/utilities/index', $this->data);
    }

    public function maps() {
        $this->data['title'] = "Manage Maps";
        array_push($this->data['css'], "jquery.dataTables.css");
        array_push($this->data['js'], "jquery.dataTables.min.js", "admin/utilities/maps.js");
        $this->data['sidemenu'] = "/admin/utilities/side_menu";
        renderPage('admin/utilities/maps/index', $this->data);
    }

    public function items() {
        $this->data['title'] = "Manage Items";
        array_push($this->data['css'], "jquery.dataTables.css");
        array_push($this->data['js'], "jquery.dataTables.min.js", "admin/utilities/items.js");
        $this->data['sidemenu'] = "/admin/utilities/side_menu";
        renderPage('admin/utilities/items/index', $this->data);
    }

    public function monsters() {
        $this->data['title'] = "Manage Monsters";
        array_push($this->data['css'], "jquery.dataTables.css");
        array_push($this->data['js'], "jquery.dataTables.min.js", "admin/utilities/monster.js");
        $this->data['sidemenu'] = "/admin/utilities/side_menu";
        renderPage('admin/utilities/monsters/index', $this->data);
    }

    public function rebirth() {
        $this->data['title'] = "Manage Rebirth";
        array_push($this->data['css'], "jquery.dataTables.css");
        array_push($this->data['js'], "jquery.dataTables.min.js", "admin/utilities/rebirth.js");
        $this->data['sidemenu'] = "/admin/utilities/side_menu";



        renderPage('admin/utilities/rebirth/index', $this->data);
    }

    public function reset() {
        $this->data['title'] = "Manage Monsters";
        array_push($this->data['css'], "jquery.dataTables.css");
        array_push($this->data['js'], "jquery.dataTables.min.js", "admin/utilities/rebirth.js");
        $this->data['sidemenu'] = "/admin/utilities/side_menu";



        renderPage('admin/utilities/rebirth/index', $this->data);
    }

    public function managecategories() {
        $this->data['title'] = "Manage game guide categories";
        array_push($this->data['css'], "jquery.dataTables.css");
        array_push($this->data['js'], "jquery.dataTables.min.js", "admin/utilities/guide/category.js");
        $this->data['sidemenu'] = "/admin/utilities/side_menu";



        renderPage('admin/utilities/guides/category', $this->data);
    }

    public function manageguide() {
        $this->load->model('guide/guide_model');
        $this->data['title'] = "Manage Game Guides ";
        array_push($this->data['css'], "jquery.dataTables.css");
        $this->data['categories'] = $this->guide_model->get_enabled_category_list();
        array_push($this->data['js'], "jquery.dataTables.min.js", "tinymce/tinymce.min.js", "admin/utilities/guide/guide.js");
        $this->data['sidemenu'] = "/admin/utilities/side_menu";



        renderPage('admin/utilities/guides/guide', $this->data);
    }

    public function guidesettings() {

        $this->data['title'] = "Manage Ingame Guides Settings";
        array_push($this->data['css'], "jquery.dataTables.css");
        array_push($this->data['js'], "jquery.dataTables.min.js", "admin/utilities/guide/settings.js");
        $this->data['sidemenu'] = "/admin/utilities/side_menu";



        renderPage('admin/utilities/guides/settings', $this->data);
    }

    /* ---------------------------------------------------------------------------------------------------------------------
     *
     *
     *
     * Tools SECTION
     *
     *
     *
     * --------------------------------------------------------------------------------------------------------------------
     * */

    public function tools() {
        $this->data['title'] = "Web Data Panel";
        $this->data['sidemenu'] = "/admin/tools/side_menu";
        renderPage('admin/tools/index', $this->data);
    }

    public function itemoptions() {
        $this->data['title'] = "Create Item Options";
        array_push($this->data['css'], "jquery.dataTables.css", 'admin/tools/options.css');
        array_push($this->data['js'], "jquery.dataTables.min.js", 'jquery.autocomplete.min.js', "admin/tools/itemoptions.js");
        $this->data['sidemenu'] = "/admin/tools/side_menu";

        // Process Form
        if ($_POST) {
            $character = $this->input->post('character', true);
            $item_code = $this->input->post('item_code', true);
            $post_data = $this->input->post();
            $this->form_validation->set_rules('character', 'Character', 'trim|required|xss_clean');
            $this->form_validation->set_rules('item_code', 'Item Code', 'trim|required|xss_clean');

            if ($this->form_validation->run() != FALSE) {

                $character_details = $this->admin_model->getCharacterDetails($character);
                $character_mbody = get_mbody_part('INVEN', $character_details['m_body']);
                $character_slots = get_slots($character_mbody);
                $item_code = $item_code . ';' . $character_slots['empty'][0];
                if (empty($character_mbody)) {
                    $character_mbody = $item_code;
                } else {
                    $character_mbody = $character_mbody . ";" . $item_code;
                }
                $character_mbody = do_mbody_insert('INVEN', $character_mbody, $character_details['m_body']);
                if (!empty($character_slots['empty'])) {
                    if ($character_details['pnline'] == 0) {
                        $data = array('m_body' => $character_mbody);
                        $this->admin_model->UpadateCharacterDetails($character, $data);


                        create_admin_log("Inserted new item in $character's Inventory!!");

                        $this->data['slots'] = "<div class='card-panel light-green accent-4 result'>Item has been sucessfully inserted in $character at slot " . $character_slots['empty'][0] . "!!</div>";
                    } else {
                        $this->data['slots'] = 'Character is online in game';
                    }
                } else {
                    $this->data['slots'] = 'No Empty Slots Available';
                }
            } else {
                renderPage('admin/tools/items/index', $this->data);
                exit();
            }
        }

        renderPage('admin/tools/items/index', $this->data);
    }

    public function insertitem() {
        $this->data['title'] = "Insert Item In Players inventory";
        array_push($this->data['css'], "jquery.dataTables.css", 'admin/tools/options.css');
        array_push($this->data['js'], "jquery.dataTables.min.js", 'jquery.autocomplete.min.js', "admin/tools/insertitem.js");
        $this->data['sidemenu'] = "/admin/tools/side_menu";

        renderPage('admin/tools/items/insertitem', $this->data);
    }

    /* ---------------------------------------------------------------------------------------------------------------------
     *
     *
     *
     * Players SECTION
     *
     *
     *
     * --------------------------------------------------------------------------------------------------------------------
     * */

    public function players() {
        $this->data['title'] = "Players Panel";
        $this->data['sidemenu'] = "/admin/players/side_menu";
        renderPage('admin/players/index', $this->data);
    }

    public function banplayers() {

        $this->load->model('access_model');
        $this->data['title'] = "Ban Players";
        array_push($this->data['css'], "jquery.dataTables.css", 'admin/players/players.css');
        array_push($this->data['js'], "jquery.dataTables.min.js", 'jquery.autocomplete.min.js', "admin/players/banplayer.js");
        $this->data['sidemenu'] = "/admin/players/side_menu";
        $this->data['status_list'] = $this->access_model->status_list();

        // Process Form
        if (isset($_POST)) {

            $character = $this->input->post('character', true);
            $account = $this->input->post('account', true);
            $status = $this->input->post('status', true);
            $ban_date = $this->input->post('ban_date', true);
            $msg = $this->input->post('msg', true);
            $ban_date = str_replace(',', "", $ban_date);
            $ban_date = strtotime($ban_date);
            $ban_date = date('Y-m-d G:H:s', $ban_date);
            //2015-02-15 18:25:52.727

            $post_data = $this->input->post();

            $this->form_validation->set_rules('character', 'Character Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('account', 'Account Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ban_date', 'Ban Till', 'trim|xss_clean');

            if ($this->form_validation->run() != FALSE) {

                create_admin_log("Changed $character's Account Status!!");
                $data = array('c_status' => $status, 'unban_date' => $ban_date, 'msg' => $msg);
                $this->admin_model->update_character_ban_status($account, $data);
                $this->data['status'] = "$character account status has been sucessfully changed !!";
            }
        }

        renderPage('admin/players/banplayers', $this->data);
    }

    public function playerdetails() {

        $this->data['title'] = "Modify Player Details";
        array_push($this->data['css'], "jquery.dataTables.css", 'admin/players/players.css');
        array_push($this->data['js'], "jquery.dataTables.min.js", 'jquery.autocomplete.min.js', "admin/players/playerdetails.js");
        $this->data['sidemenu'] = "/admin/players/side_menu";
        renderPage('admin/players/playerdetails', $this->data);
    }

    public function playersinventory() {

        $this->data['title'] = "Player Inventory Details";
        array_push($this->data['css'], "jquery.dataTables.css", 'admin/players/players.css');
        array_push($this->data['js'], "jquery.dataTables.min.js", 'jquery.autocomplete.min.js', "admin/players/playersinventory.js");
        $this->data['sidemenu'] = "/admin/players/side_menu";
        renderPage('admin/players/playersinventory', $this->data);
    }

    public function playersaccout() {

        $this->data['title'] = "Player Account Details";
        array_push($this->data['css'], "jquery.dataTables.css", 'admin/players/players.css');
        array_push($this->data['js'], "jquery.dataTables.min.js", 'jquery.autocomplete.min.js', "admin/players/playersaccount.js");
        $this->data['sidemenu'] = "/admin/players/side_menu";
        renderPage('admin/players/playersaccount', $this->data);
    }

    /* ---------------------------------------------------------------------------------------------------------------------
     *
     *
     *
     * maintenance SECTION
     *
     *
     *
     * --------------------------------------------------------------------------------------------------------------------
     * */

    public function maintenance() {
        $this->data['title'] = "Maintenance section";
        // array_push($this->data['css'], "jquery.dataTables.css");
        //  array_push($this->data['js'], "jquery.dataTables.min.js", 'jquery.autocomplete.min.js');
        $this->data['sidemenu'] = "/admin/maintenance/side_menu";
        renderPage('admin/maintenance/index', $this->data);
    }

    public function eshoplog() {

        $this->data['title'] = "Eshop item purchase log";
        array_push($this->data['css'], "jquery.dataTables.css");
        array_push($this->data['js'], "jquery.dataTables.min.js", 'jquery.autocomplete.min.js', "admin/maintenance/eshoplog.js");
        $this->data['sidemenu'] = "/admin/maintenance/side_menu";

        $this->load->model('eshop/eshop_model');
        $total = $this->eshop_model->get_count_of_transaction();
        $this->data['list'] = $this->eshop_model->get_list_of_transaction();
        $this->data['append_manual_sctript_to_footer'] = " var total_transaction=$total; ";
        renderPage('admin/maintenance/eshoplog', $this->data);
    }

    public function gamelog($type) {

        $this->data['title'] = "Game log";
        array_push($this->data['css'], "jquery.dataTables.css");
        array_push($this->data['js'], "jquery.dataTables.min.js", 'jquery.autocomplete.min.js', "admin/maintenance/gamelog.js");
        $this->data['sidemenu'] = "/admin/maintenance/side_menu";
        $this->data['type'] = $type;
        $this->load->model('game/game_model');
        $total = $this->game_model->get_count_of_log($type);
        $this->data['list'] = $this->game_model->get_list_of_log($type);
        $this->data['append_manual_sctript_to_footer'] = " var total_log=$total; var types=$type; ";

        renderPage('admin/maintenance/gamelog', $this->data);
    }

    public function tracker() {
        $this->data['title'] = "Item Tracker";

        $this->data['sidemenu'] = "/admin/maintenance/side_menu";
        $this->load->model('game/game_model');

        $account = $this->input->get("account", TRUE);
        $account = clean_input("/[^a-zA-Z0-9]/", "", $account);
        $character = $this->input->get("character", TRUE);
        $character = clean_input("/[^a-zA-Z]/", "", $character);
        $ic = $this->input->get("ic", TRUE);
        $ic = clean_input("/[^0-9]/", "", $ic);
        $iu = $this->input->get("iu", TRUE);
        $iu = clean_input("/[^0-9]/", "", $iu);

        if ($account != '' || $character != '' || $ic != '' || $iu != '') {

            $total = $this->game_model->get_count_of_tracking_log($ic, $iu, $account, $character);
            $this->data['list'] = $this->game_model->get_list_of_tracking_log($ic, $iu, $account, $character);
        } else {
            $total = $this->game_model->get_count_of_all_log();
            $this->data['list'] = $this->game_model->get_list_of_all_log();
        }

        array_push($this->data['css'], "jquery.dataTables.css");
        array_push($this->data['js'], "jquery.dataTables.min.js", 'jquery.autocomplete.min.js', "admin/maintenance/tracker.js");
        $this->data['append_manual_sctript_to_footer'] = "
                                                            
                
var total_log=$total;
                                                        
                                                         ";
        if ($account != '')
            $this->data['append_manual_sctript_to_footer'] .=" var account='$account';";
        else {
            $this->data['append_manual_sctript_to_footer'] .=" var account='';";
        }
        if ($character != '')
            $this->data['append_manual_sctript_to_footer'] .=" var character='$character';";
        else {
            $this->data['append_manual_sctript_to_footer'] .=" var character='';";
        }
        if ($ic != '')
            $this->data['append_manual_sctript_to_footer'] .=" var ic='$ic';";
        else {
            $this->data['append_manual_sctript_to_footer'] .=" var ic='';";
        }
        if ($iu != '')
            $this->data['append_manual_sctript_to_footer'] .=" var iu='$iu';";
        else {
            $this->data['append_manual_sctript_to_footer'] .=" var iu='';";
        }
        renderPage('admin/maintenance/tracker', $this->data);
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */