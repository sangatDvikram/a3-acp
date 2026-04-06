<?php

require(APPPATH . 'libraries/REST_Controller.php');

class Game extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('game/game_model');
        $this->load->model('players/players_model');
    }

    function getGameShouts_post() {
        $start = $this->post('start', true);
        $start = clean_input("/[^0-9]/", "", $start);
        $output = array('shouts' => "", 'last' => '', 'total_fetch' => 0);


        if (!isset($start)) {
            $data = $this->game_model->get_shout_list();
        } else {
            $output['last'] = $start;
            $data = $this->game_model->get_shout_list($start);
        }



        $last = 0;
        if (count($data) > 0) {
            foreach ($data as $item) {
                if ($item['type'] != "")
                    $arguments = array('player' => "[" . $item['type'] . "]" . $item['charname'], 'message' => htmlentities($item['message']), 'date' => $item['date']);
                else
                    $arguments = array('player' => $item['charname'], 'message' => htmlentities($item['message']), 'date' => $item['date']);

                $output['shouts'][] = $arguments;
                if ($last == 0)
                    $output['last'] = $item['sr'];
                $last++;
            }
        }
        $output['total_fetch'] = $last;

        if (count($output['shouts']) > 1) {

            $output['shouts'] = array_reverse($output['shouts']);

            //$output['shouts']=count($output['shouts']);
        }

        //$output['shouts']=count($output['shouts']);
        // $output['shouts'] = array_reverse($output['shouts']);

        $this->response($output);
    }

    function sendGameShout_post() {
        check_page_access(true);
        $cost = 3;
        $shout_text = $this->post('shout_text', true);
        $shout_text = urldecode($shout_text);
        $shout_text = trim($shout_text, '"');
        $shout_text = clean_input('/[^a-zA-Z0-9:\.\/\]\|\[\#\@\;&\s\,\!"\?+-\>\<\)\(\😂\*\_]/', "", $shout_text);
        $shout_text = html_entity_decode($shout_text);
        $output = array("error" => "", 'message' => "");

        if (isset($shout_text) && $shout_text == "")
            $output['error'][] = "Enter some shout first";
        // Lets start the processing only when we know we have logged in user :) 
        if ($this->session->userdata('logged_in')) {
            //Set The username
            $username = $this->session->userdata('username');
            //Get Top Most character of the account
            $poster = $this->players_model->get_top_chatacter_from_account();
            //Get account details :) 
            $account = $this->players_model->get_account_details($username);
            //Reduce coins.
            $new_coins = ($account['coins'] - $cost);

            //Lets check eshop coins :D 
            if (!($new_coins > 0)) {
                // So sad you dont have enought coins :D sorry.
                $output['error'][] = "You dont have enough coins sorry.";
            }
            // We dont have any character to post shout by 
            if (!(count($poster) > 0)) {
                // So sad you dont have enought coins :D sorry.
                $output['error'][] = "You dont have any character in this account.";
            }

            if (empty($output['error'])) {


                $data = array('coins' => $new_coins);

                //Update Account :) 
                $update_account = $this->players_model->update_account_details($username, $data);

                //Send Shout
                $send_shout = $this->game_model->send_game_shout($poster['c_id'], $shout_text);

                $output['message'][] = "Ingame shout sent successfully.";

                $output['message'][] = "You now have $new_coins E Coins.";
            } else {
                $output['error'][] = "Sending shout is not successfull";
                $output['error'] = array_reverse($output['error']);
            }
        } else {
            $output['error'][] = "You must be login to send the ingame shout. Please refresh the page.";
        }



        $this->response($output);
    }

    function getCharChatWith_post() {
        check_page_access(true);

        $char = $this->session->userdata('chatcharacter');

        $this->char = $char;

        $with = $this->post('with', true);
        $with = clean_input("/[^a-zA-Z0-9]/", "", $with);

        $output = array('chat' => "", 'start' => 0, 'last' => 0, 'date' => '');

        $start = $this->post('start', true);
        $start = clean_input("/[^0-9]/", "", $start);
        $date = $this->post('date', true);
        $date = clean_input("/[^A-Za-z0-9\,\s]/", "", $start);

        $chat_top = '<div class="chat-more center tooltipped hide-on-med-and-down" data-position="bottom" data-delay="50" data-tooltip="Click me to load more." id="chat-more" >

                            <a  class=" " >
                                <i class="mdi-hardware-keyboard-arrow-down small"></i>

                            </a>


                        </div>
                        <div class="chat-more center hide-on-large-only" title="Click me to load more." id="chat-more" >

                            <a  class=" " >
                                <i class="mdi-hardware-keyboard-arrow-down small"></i>

                            </a>


                        </div>';

        if (isset($start) && $start > 0) {
            $data = $this->game_model->get_char_chat_with_using_limits($char, $with, $start);
            $chats = $this->generate_chats($data, $date);
            $output['chat'].=$chats['chat'];
            $output['date'] = $chats['date'];
            $output['start'] = $chats['start'];
            $output['last'] = $chats['last'];
        } else {

            $data = $this->game_model->get_char_chat_with($char, $with);
            $counts = count($data);
            if ($counts > 10) {
                $output['chat'].=$chat_top;
            }
            $output['chat'].='<div class="chat-messages" id="chat-messages">';
            $chats = $this->generate_chats($data);
            $output['start'] = $chats['start'];
            $output['last'] = $chats['last'];
            $output['date'] = $chats['date'];
            $output['chat'].=$chats['chat'];
            $output['chat'].='</div>';
        }


        $this->game_model->make_all_seen($char, $with);

        $this->response($output);
    }

    function getSearchedChar_post() {
        check_page_access(true);

        $char = $this->session->userdata('chatcharacter');

        $search = $this->post('search', true);
        $search = clean_input("/[^a-zA-Z0-9]/", "", $search);

        $data = $this->game_model->get_char_chat_list_like($char, $search);

        $character_list = "";
        foreach ($data as $characters) {

            $character = get_character_info($characters['from_character']);

            $character_list.='   <div class= "row character" id="' . trim($characters['from_character']) . '">';
            $character_list.='  <div class=" col s2  character-image ">';

            if ($characters['from_character'] == "Notice") {
                $character_list.='      <img src="' . base_url() . 'assects/images/characters/robo.png" alt="archer" title="' . $characters['from_character'] . '" align="right" class="circle right" > ';
            } else {

                $character_list.='      <img src="' . base_url() . 'assects/images/characters/' . $character['TypeNum'] . '.png" alt="archer" title="' . $characters['from_character'] . '" align="right" class="circle right" > ';
            }
            $character_list.=' </div>';
            $character_list.=' <div class=" col s10  chat-info">';
            $character_list.='    <div class="character-name">' . $character['StatusImage'] . $character['StyledName'] . '';
            $character_list.=' <div class="meta right">';

            $time = strtotime($characters['chat_date']);

            $newformat = "";

            if ($time >= strtotime("today")) {
                $newformat = date('h:i a', $time);
            } else if ($time >= strtotime("yesterday")) {
                $newformat = "Yesterday";
            } else {
                $newformat = date('d/m/Y', $time);
            }

            $character_list.= $newformat;
            $character_list.='</div>
                                 </div> 
                                 <div class="character-message truncate">';
            $character_list.=$characters['message'];
            $character_list.= '</div> 

                             </div>
                            </div>';
        }

        $output['list'] = $character_list;
        $this->response($output);
    }

    function generate_chats($data, $date = null) {
        $output = array('chat' => "", 'start' => 0, 'last' => 0, 'date' => "", 'olddate' => "");
        if ($date == "") {
            $old_date = date("F j, Y", time());
        } else {
            $old_date = $date;
        }
        $output['olddate'] = $old_date;
        $data = array_reverse($data);
        foreach ($data as $chats) {
            $date = strtotime($chats['date']);
            $time = date("h:i A", $date);
            $chat_date = date("F j, Y", $date);
            if ($output['start'] == 0) {
                $output['start'] = $chats['sr'];
            }
            $output['last'] = ($chats['sr'] > $output['last']) ? $chats['sr'] : $output['last'];

            // Date Calculation
            if ($old_date != $chat_date) {
                $output['chat'].="
                    <div class='center' style='margin-bottom: 5px;'>
                    <span class='chat-date z-depth-1 center'>
                                " . strtoupper($chat_date)
                        . "</span>  
                     </div>
                        ";
                $old_date = $chat_date;
            }

            if ($chats['from_character'] == $this->char) {
                $output['chat'].="<div class='row' id='$chats[sr]'>
                            
                            <div class='col offset-s3 s9 '>
                               <div class='text-to right '>
                                  <div class='chat-text'>$chats[message]  <div class='meta-time right'>$time</div></div>
                                     
                                </div>
                                
                            </div>
                            
                        </div>";
                $output['chat'].="";
            } else if ($chats['to_character'] == $this->char) {
                $output['chat'].="";

                $output['chat'].="<div class='row'  id='$chats[sr]'>
                            
                             <div class='col s9' >
                               <div class='text-from white left '>
                                  <div class='chat-text'>$chats[message]  <div class='meta-time right'>$time</div></div>
                                     
                                </div>
                                
                            </div>
                            <div class='col offset-s2 s1'></div>
                        </div>";
                $output['chat'].="";
            }
        }
        $output['date'] = $old_date;
        return $output;
    }

    function startChatSession_post() {
        check_page_access(true);
        $chatting_with_name = $this->post('chatting_with', true);
        $chatting_with_name = clean_input("/[^a-zA-Z0-9]/", "", $chatting_with_name);
        $this->session->set_userdata('chatting_with', $chatting_with_name);
    }

    function destroyChatSession_post() {
        check_page_access(true);
        $array_items = array('chatcharacter' => '', 'chatting_with' => '');
        $this->session->unset_userdata($array_items);
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header('Pragma: no-cache');
        //$this->session->unset_userdata('chatting_with');
        $this->response($output = "Session destroid");
    }

    function getcharacterChatlist_post() {
        check_page_access(true);
        $char = $this->session->userdata('chatcharacter');

        $output = array('list' => "", 'start' => 0, 'last' => 0);

        if (character_exist_in_account($char)) {

            $from = $this->game_model->get_char_chat_list($char);

            $output['list'] = "";

            foreach ($from as $characters) {

                if ($output['last'] == 0) {
                    $output['last'] = $characters['sr'];
                }
                $output['start'] = $characters['sr'];

                $unseen = $this->game_model->get_unseen_count($characters['from_character'], $char);
                $character = get_character_info($characters['from_character']);

                $output['list'].= "<div class= 'row character chat-character' id='" . trim($characters['from_character']) . "'>
                    <div class=' col s2 l2 m1 character-image ' style='padding-right:0;'>";

                if ($characters['from_character'] == "Notice") {
                    $output['list'].= "   <img src='" . base_url() . "assects/images/characters/robo.png' alt='archer' title='$characters[from_character]' align='right' class='circle right char-image' >";
                } else {
                    $output['list'].="   <img src='" . base_url() . "assects/images/characters/" . $character['TypeNum'] . ".png' alt='archer' title=' $characters[from_character]' align='right' class='circle right char-image' >";
                }
                $output['list'].="</div>
                    <div class=' col s10 l10 m11 chat-info'>
                        <div class='character-name'> $character[StatusImage] $character[StyledName]
                            <div class='meta right'>";

                $time = strtotime($characters['chat_date']);

                $newformat = "";

                if ($time >= strtotime("today"))
                    $newformat = date('h:i a', $time);
                else if ($time >= strtotime("yesterday"))
                    $newformat = "Yesterday";
                else {
                    $newformat = date('d/m/Y', $time);
                }



                $output['list'].=" $newformat</div>
                        </div> 
                        <div class='character-message truncate'>
                             " . substr($characters['message'], 0, 30);
                if ($unseen['unseen'] > 0)
                    $output['list'].="<span class='right'> $unseen[unseen] </span>";
                $output['list'].="
                        </div> 

                    </div>
                </div>";
            }







            $this->response($output);
        } else {

            $this->response("");
        }
    }

    public function sendGameWisper_post() {

        check_page_access(true);
        $char = $this->session->userdata('chatcharacter');
        $with = $this->post('to', true);
        $with = clean_input("/[^a-zA-Z0-9]/", "", $with);

        $message = $this->post('message', true);
        $message = str_replace("'", "", $message);
        $message = clean_input("/[^a-zA-Z0-9\W]/", "", $message);

        $from_info = get_character_info($with);

        $send_chat = $this->game_model->send_chat_message($from_info['Account'], $with, $message);

        $output['id'] = $send_chat;
        $output['success'] = "Chat Sent";
        $time = date("h:i A", time());
        $output['chat'] = "";
        $output['chat'].="<div class='row'  id='$send_chat'>
                            
                              <div class='col offset-s3 s9 '>
                               <div class='text-to right '>
                                  <div class='chat-text'>$message <div class='meta-time right'>$time</div></div>
                                     
                                 </div>
                                
                            </div>
                        </div>";
        $output['chat'].="";

        $this->response($output);
    }

    public function updateChat_post() {

        check_page_access(true);
        $char = $this->session->userdata('chatcharacter');
        $this->char = $char;
        $with = $this->post('with', true);
        $with = clean_input("/[^a-zA-Z0-9]/", "", $with);

        $last = $this->post('last', true);
        $last = clean_input("/[^0-9\.]/", "", $last);
        $last = $last;
        $date = $this->post('date', true);

        $data = $this->game_model->get_last_chat($char, $with, $last);

        if (count($data) > 0) {
            $chat = $this->generate_chats($data, $date);
            $output['last'] = $chat['last'];
            $output['start'] = $chat['start'];
            $output['chat'] = $chat['chat'];
            $output['date'] = $chat['date'];
            $output['olddate'] = $chat['olddate'];

            $output['new'] = count($data);
        } else {
            $output['new'] = 0;
        }
        $this->response($output);
    }

    public function gamelogs_post() {


        check_page_access(true, "BAN");

        $start = $this->post('start', true);
        $length = $this->post('length', true);
        $search = $this->post('search', true);
        $type = $this->post('type', true);

        $data['result'] = $this->game_model->generate_list_of_log($type, $search['value'], $start, $length);
        $total = $this->game_model->get_count_of_log($type);
        $output = array();
        $output['recordsTotal'] = $total;
        $output['recordsFiltered'] = $total;
        $i = 1;
        foreach ($data['result'] as $result) {

            //$iteminfo=  item_info($data);


            $item = "<img src='$result[image]' width='32px'><br> Name : $result[item_name]<br> Item code:<br><b>$result[code];$result[item_unique]</b>";



            if ($type == 208 || $type == 210 || $type == 233 || $type == 234) {

                $arguments = array($i, $result['actor_name'], $result['actor_account'], $item, $result['actor_location'], $result['actor_ip_address'], $result['receiver_name'], $result['receiver_account'], $result['receiver_ip_address'], $result['item_option'], $result['date']);
            } else {
                $arguments = array($i, $result['actor_name'], $result['actor_account'], $item, $result['actor_location'], $result['actor_ip_address'], $result['item_option'], $result['date']);
            }
            $output['data'][] = $arguments;
            $i++;
        }

        $this->response($output);
    }

    public function tracklogs_post() {


        check_page_access(true, "BAN");

        $start = $this->post('start', true);
        $length = $this->post('length', true);
        $search = $this->post('search', true);

        $account = $this->post('account', true);
        $character = $this->post('character', true);
        $ic = $this->post('ic', true);
        $iu = $this->post('iu', true);

        $data['result'] = $this->game_model-> generate_list_of_tracking_log($ic, $iu, $account, $character, $search['value'], $start, $length);
        $total = $this->game_model->get_count_of_tracking_log($ic, $iu, $account, $character);
        $output = array();
        $output['recordsTotal'] = $total;
        $output['recordsFiltered'] = $total;
        $i = 1;
        foreach ($data['result'] as $result) {

            //$iteminfo=  item_info($data);


            $item = "<img src='$result[image]' width='32px'><br> Name : $result[item_name]<br> Item code:<br><b>$result[code];$result[item_unique]</b>";

            $type = "";
            switch ($result['action_type']) {
                case 201:
                    $type = "Item Pick up";
                    break;
                case 202:
                    $type = "Item Pick up";
                    break;
                case 204:
                    $type = "Item droped on ground";
                    break;
                case 205:
                    $type = "MOR used";
                    break;
                case 206:
                    $type = "Bought item at NPC";
                    break;
                case 207:
                    $type = "Sold item at NPC";
                    break;
                case 208:
                    $type = "Drop item on player";
                    break;
                case 210:
                    $type = "Traded item";
                    break;
                case 212:
                    $type = "Used for sloting";
                    break;
                case 213:
                    $type = "Done sloting";
                    break;
                case 214:
                    $type = "Used for crafting";
                    break;
                case 215:
                    $type = "Done crafting";
                    break;
                case 216:
                    $type = "Bought Shue at NPC";
                    break;
                case 217:
                    $type = "Sold Shue at NPC";
                    break;
                case 218:
                    $type = "Trade Shue";
                    break;
                case 231:
                    $type = "Sold Shue to player";
                    break;
                case 232:
                    $type = "Bought Shue from player";
                    break;
                case 233:
                    $type = "Sold Item as shop";
                    break;
                case 234:
                    $type = "Bought item as shop";
                    break;

                default: $type = "Unknown - $result[action_type]";
                    break;
            }


            $arguments = array($i, $result['actor_name'], $result['actor_account'], $item, $type, $result['actor_location'], $result['actor_ip_address'], $result['receiver_name'], $result['receiver_account'], $result['receiver_ip_address'], $result['item_option'], $result['date']);

            $output['data'][] = $arguments;
            $i++;
        }

        $this->response($output);
    }

}
