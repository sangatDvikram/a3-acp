<?php

require(APPPATH . 'libraries/REST_Controller.php');

class eshop extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('eshop/eshop_model');

        check_page_access(true);
        $this->load->library('encrypt');
    }

    function getcategorylist_post() {
        $category = $this->post('category', true);
        $category = urldecode($category);
        $category = clean_input("/[^a-zA-Z\s]/", '', $category);
        $data = $this->eshop_model->get_category_list($category);

        $output = $this->generate_chat($data);

        $this->response($output);
    }

    function topitemlist_post() {

        $data = $this->eshop_model->get_top_eshop_items();

        $output = $this->generate_chat($data);

        $this->response($output);
    }

    public function searchitem_get() {
        $name = $this->get('query', true);
        $name = clean_input("/[^a-zA-Z0-9\s]/", '', $name);

        if (isset($name)) {
            $data = $this->eshop_model->search_item($name);
            $output['query'] = 'Unit';
            foreach ($data as $value) {
                $output['suggestions'][] = array("value" => rtrim($value['item_name']), "data" => $value['item_code']);
            }
            $this->response($output);
        } else {
            $this->response(array());
        }
    }

    public function search_post() {
        $name = $this->post('name', true);
        $name = clean_input("/[^a-zA-Z0-9\s]/", '', $name);
        $data = $this->eshop_model->search_item_by_name($name);
        $output = $this->generate_chat($data);
        $this->response($output);
    }

    public function generate_chat($data) {
        $output = '<div class="row">';
        $i = 1;
        foreach ($data as $item) {

            $output.='<div class="col s12 m3">
          <div class="card">
            <div class="card-image waves-effect waves-block waves-light center">
                 <img class="activator" src="' . $item['image'] . '" style="width:32px;padding-top:5px" title="click for more info">
            </div>
            <div class="card-content">
              <span class="card-title activator grey-text text-darken-4" style="font-size:17.5px;"><b>' . $item['name'] . '</b><i class="mdi-navigation-more-vert right" title="click for more info"></i></span>
              <p>
Class :  ' . $item['class'] . '<br>
Type : ' . $item['type'] . ' <br>';


            if ($item['eshop_coins_price'] > '0' && $item['eshop_coins_price'] < '99999') {

                if ($item['eshop_coins_price'] == 0)
                    $item['eshop_coins_price'] = 'FREE';
                if($item['Deshop_coins_price'] != $item['eshop_coins_price'])
                {
                    $disc = round(100-(($item['eshop_coins_price']/$item['Deshop_coins_price'])*100));

                    $output.= "Coins : <span class='indigo-text'><strike>" . $item['Deshop_coins_price'] . "</strike> <small><span class='red-text'>" . $disc ."% off</span><br> </small> </span> Now:<b> <span class='indigo-text'> &nbsp;" . number_format($item['eshop_coins_price']) . "</b></span><br>";
                }
                else
                    $output.= "Coins : <span class='indigo-text'><b>" . $item['eshop_coins_price'] . " </b></span> <br>";
            }
            if ($item['premium_coins_price'] > '0' && $item['premium_coins_price'] < '99999') {

                if ($item['premium_coins_price'] == 0)
                    $item['premium_coins_price'] = 'FREE';
                if($item['Dpremium_coins_price'] != $item['premium_coins_price'])
                {
                    $disc = round(100-(($item['premium_coins_price']/$item['Dpremium_coins_price'])*100));
                    
                    $output.= "Premium Coins : <span class='orange-text'><strike> " . $item['Dpremium_coins_price'] . "</strike> <small><span class='red-text'>" . $disc ."% off</span><br> </small> </span> Now:<b> <span class='orange-text'> &nbsp;" . number_format($item['premium_coins_price']) . "</b></span><br>";
                }
                else
                    $output.= "Premium Coins : <span class='orange-text'><b> " . $item['premium_coins_price'] . " </b></span> <br>";
            }
            if($item['reward_coins_price'] == 1)
            {
                 $output.= "Santa Reward Coins : <span class='red-text'><b> " . $item['reward_coins_price'] . " </b></span> <br>";
            }


            $item_code = $item['itemid'] . ";" . $item['typeid'] . ";" . $item['uniqueid'];
            $item_info = get_item_options($item_code);
            $data = item_option_format($item_info);
            $link = $item_info['link'];
            $encrypted_string = $this->encrypt->encode($item['sr_no']);
            $output.='</p></div>
               <div class="card-reveal"> 
          <span class="card-title activator grey-text text-darken-4" style="font-size:17.5px;"><i class="mdi-navigation-close right" title="Click to close" ></i></span>
              <p>
' . $data['data'] . '
        </p>
        </div>
            <div class="card-action">
              <a href="' . site_url('eshop/buy') . '?item=' . $encrypted_string . '" class="green-text">Buy</a>
              <a href="' . site_url('guides/items') . '?item=' . $link . '" class="right blue-text">Info</a>
            </div>
          </div>
        </div>';
            if ($i % 4 == 0)
                $output.= "</div><div class='row'>";
            $i++;
        }
        $output.="</div>";

        return $output;
    }

    public function generateEshopInfo_post() {

        $this->load->model('players/players_model');

        $item = $this->post('item', true);
        $item = str_replace(' ', '+', $item);
        $item = clean_input("/[^a-zA-Z0-9+\/=\s\s+]/", '', $item);
        $sr_no = (int) $this->encrypt->decode($item);
        $item_info = $this->eshop_model->get_item_info($sr_no);
        $item_info = $item_info[0];
        if (is_integer($sr_no) && $sr_no > 0) {

            $coins = $this->eshop_model->get_account_coins_info();
            $coins_output = "<h5 class='center'>Coins</h5>
                <div class='divider'></div>
                <br><div class = 'card-panel blue lighten-3 ' >Total Premium Coins:  " . number_format($coins['pcoins'], 2) . "  <br>  Total Eshop Coins:  " . number_format($coins['coins'], 2) . "  <br>  \n Total Gold Coins: " . number_format($coins['gold'], 2) . "  <br>  \n Total Santa Reward Coins: " . number_format($coins['reward'],2). " </div> ";

            $characters = $this->players_model->get_current_account_characters();

            $characters_output = "
                <h5 class='center'>Character</h5>
                <div class='divider'></div>
                <br><label>Select Character</label>
                <select name='character' class='browser-default' id='character' required><option value='' disabled selected>Choose your option</option>";

            foreach ($characters as $value) {
                $characters_output.='<option value="' . $this->encrypt->encode(trim($value['c_id'])) . '">' . trim($value['c_id']) . '</option>';
            }
            $characters_output.="</select>";

            $form = "<form id='character-form'>";
            $form.=$characters_output;
            $form.='
                <br>
                <h5 class="center">Buying options</h5>
                <div class="divider"></div>
                <br>
                <div class="center">
                ';
            if (($coins['pcoins'] - $item_info['premium_coins_price']) >= 0) {
                $form.='<button class="btn blue waves-effect waves-light submit-buttons black-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Buy item using Premium Coins" type="submit" name="action1" value="premium" title="buy items using premium coins">Premium
                <i class="mdi-content-send right"></i>
                </button>&nbsp;&nbsp;';
            }
            if (($coins['coins'] - $item_info['eshop_coins_price']) >= 0) {
                $form.='<button class="btn green waves-effect waves-light submit-buttons black-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Buy item using Eshop Coins" type="submit" name="action12" value="eshop" title="buy items using eshop coins">Eshop
                <i class="mdi-content-send right"></i>
                </button>&nbsp;&nbsp;';
            }
            if (($coins['gold'] - $item_info['gold_coins_price']) >= 0) {
                $form.='<button class="btn orange waves-effect waves-light submit-buttons black-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Buy item using Gold Coins" type="submit" name="action13" value="gold" title="buy items using gold coins">Gold
                <i class="mdi-content-send right"></i>
                </button>&nbsp;&nbsp;';
            }
            if(($coins['reward'] - $item_info['reward_coins_price']) >=0)
            {
            	$form.='<button class="btn yellow waves-effect waves-light submit-buttons black-text tooltipped" style="margin-top: 5px" data-position="bottom" data-delay="50" data-tooltip="Buy item using Reward Coins" type="submit" name="action14" value="reward" title="buy items using reward coins">Santa Reward Point
                <i class="mdi-content-send right"></i>
                </button>';
            }
            $form.='</div></form>';


            $output = $coins_output . $form;

            $this->response($output);
        } else {
            $this->response('');
        }
    }

    public function makePayment_post() {

        $this->load->model('players/players_model');

        $type_array = array("premium", "eshop", 'gold', 'reward');

        $character = $this->post('character', true);
        $character = str_replace(' ', '+', $character);
        $character = clean_input("/[^a-zA-Z0-9+\/=\s\s+]/", '', $character);
        $character = $this->encrypt->decode($character);

        $item = $this->post('item', true);
        $item = str_replace(' ', '+', $item);
        $item = clean_input("/[^a-zA-Z0-9+\/=\s\s+]/", '', $item);
        $item = (int) $this->encrypt->decode($item);

        $type = $this->post('type', true);
        $type = clean_input("/[^a-z]/", '', $type);

        if (character_exist_in_account($character) && is_integer($item) && $item > 0 && in_array($type, $type_array)) {

            $character_info = $this->players_model->get_character_details($character);
            $account_info = $this->players_model->get_account_details($this->session->userdata('username'));
            $item_info = $this->eshop_model->get_item_info($item);
            $item_info = $item_info[0];

            $character_mbody_inventory = get_mbody_part('INVEN', $character_info['m_body']);
            $character_slots = get_slots($character_mbody_inventory);
     


            $oldcoins = 0;
            $newcoins = 0;
            $amount = 0;
            $transaction_type = "";
            $transaction_column = "";
            switch ($type) {
                case 'premium':
                    $oldcoins = $account_info['pcoins'];
                    $amount = $item_info['premium_coins_price'];
                    $newcoins = $oldcoins - $item_info['premium_coins_price'];
                    $transaction_type = 'pcoins';
                    $transaction_column = 'premium_coins_buys';
                    break;
                case 'eshop':
                    $oldcoins = $account_info['coins'];
                    $amount = $item_info['eshop_coins_price'];
                    $newcoins = $oldcoins - $item_info['eshop_coins_price'];
                    $transaction_type = 'coins';
                    $transaction_column = 'eshop_coins_buys';
                    break;
                case 'gold':
                    $oldcoins = $account_info['gold'];
                    $amount = $item_info['gold_coins_price'];
                    $newcoins = $oldcoins - $item_info['gold_coins_price'];
                    $transaction_type = 'gold';
                    $transaction_column = 'gold_coins_buys';
                    break;
                case 'reward':
                    $ipcheck = $this->eshop_model->get_ip_from_log($this->session->userdata('ip_address'));
		          	if(empty($ipcheck))
		          	{
		          		$ipflag=0;
		          	}
		          	else
		          	{
		          		$ipflag=1;
		          	}
                	if($ipflag==0)
                	{
	                	$oldcoins = $account_info['reward'];
	                	$amount = $item_info['reward_coins_price'];
	                	$newcoins = $oldcoins - $item_info['reward_coins_price'];
	                	$transaction_type='reward';
	                	$transaction_column='reward_coins_buys';
                	}
                	break;

                default:
                    break;
            }

            if($ipflag==1)
            {
            	$this->error[] = "Cannot make purchase of multiple Items from 1 IP.";
            }
            if ($newcoins < 0) {
                $this->error[] = "You don't have enough coins to buy this item!";
            }

            if (empty($character_slots['empty'])) {
                $this->error[] = "You dont have any inventory slot available!";
            }

            if ($character_info['pnline'] == 1) {
                $this->error[] = "Please make sure you are offline in game!";
            }

            if (empty($this->error)) {

                $item_code = $item_info['itemid'] . ';' . $item_info['typeid'] . ';' . $item_info['uniqueid'] . ';' . $character_slots['empty'][0];

                if (empty($character_mbody_inventory)) {
                    $character_mbody_inventory = $item_code;
                } else {
                    $character_mbody_inventory = $character_mbody_inventory . ";" . $item_code;
                }

                $character_mbody = do_mbody_insert('INVEN', $character_mbody_inventory, $character_info['m_body']);
                $transaction_id='transaction-' . random_string('alnum', 20);
                $item_id= 'item-' . random_string('alnum', 20);
                $data_array = array(
                    'sr_no' => $item,
                    'account' => $this->session->userdata('username'),
                    'session_ip' => $this->session->userdata('ip_address'),
                    'character' => $character,
                    'm_body' => $character_mbody,
                    'transaction_type' => $transaction_type,
                    'transaction_column' => $transaction_column,
                    'old_coins' => $oldcoins,
                    'new_coins' => $newcoins,
                    'amount' => $amount,
                    'first_part' => $item_info['itemid'],
                    'second_part' => $item_info['typeid'],
                    'unique_part' => $item_info['uniqueid'] + 1,
                    'slot_part' => $character_slots['empty'][0],
                    'transaction_id' => $transaction_id,
                    'item_id' =>$item_id
                );

                $transaction = $this->eshop_model->make_payment($data_array);
                if ($transaction) {
                    create_player_log("$character bought $item_info[name] in $amount $type coins.");
                    $output['status'] = 'success';
                    $output['message'][] = 'Item bought successfully.';
                    $output['message'][] = 'Item is added to slot ' . $character_slots['empty'][0] . '.';
                    
                    $email=array(
                        "player_email"=>$account_info['c_headerb'],
                        "player_id"=>$account_info['c_id'],
                        "character"=>$character,
                        "item_id"=>$item_id,
                        "amount"=>$amount,
                        "newcoins"=>$newcoins,
                        "oldcoins"=>$oldcoins,
                        "date"=>date("d-m-Y h:i:sa", time()),
                        "item"=>$item_info['name'],
                        "item_image"=>$item_info['image'],
                        "transaction_id"=>$transaction_id,
                        "transaction_type"=>$type,
                        "slot"=>$character_slots['empty'][0]
                        );
                        $this->sendMails($email);
                    
                } else {

                    $output['status'] = 'error';
                    $this->error[] = "Error : Item not purchased";

                    $this->error = array_reverse($this->error);

                    $output['message'] = $this->error;
                }
            } else {

                $output['status'] = 'error';
                $output['message'] = $this->error;
            }
        } else {

            $output['status'] = 'error';
            $this->error[] = "Error : Try Again Later. ";
            $output['message'] = $this->error;
        }
        
        
        
        
        $this->response($output);
    }

    public function checkclass($character_class, $item_class) {
        switch ($item_class) {
            case "Warrior" :
                if ($character_class != 0) {
                    $this->error[] = "Error : Looks like you got too smart here!";
                    return false;
                }


            case "Warrior Skill" :
                if ($character_class != 0) {
                    $this->error[] = "Error : Looks like you got too smart here. Character you forwarded is of other class bitch!";
                    return false;
                }


            case "Archer":
                if ($character_class != 3) {
                    $this->error[] = "Error : Looks like you got too smart here. Character you forwarded is of other class bitch!";
                    return false;
                }


            case "Archer Skill" :
                if ($character_class != 3) {
                    $this->error[] = "Error : Looks like you got too smart here. Character you forwarded is of other class bitch!";
                    return false;
                }


            case "Holy Knight" :
                if ($character_class != 1) {
                    $this->error[] = "Error : Looks like you got too smart here. Character you forwarded is of other class bitch!";
                    return false;
                }


            case "Holy Knight Skill" :
                if ($character_class != 1) {
                    $this->error[] = "Error : Looks like you got too smart here. Character you forwarded is of other class bitch!";
                    return false;
                }


            case "Mage" :
                if ($character_class != 2) {
                    $this->error[] = "Error : Looks like you got too smart here. Character you forwarded is of other class bitch!";
                    return false;
                }


            case "Mage Skill" :
                if ($character_class != 2) {
                    $this->error[] = "Error : Looks like you got too smart here. Character you forwarded is of other class bitch!";
                    return false;
                }
            default : return true;
        }
        return true;
    }

    public function sendMails($data) {
        
        $emailBody = $this->load->view('/email_templates/eshop_item_bought_success_formated', $data, TRUE);
        //Send Mail to player
        $mail_to = $data['player_email'];
        $mail_subject = $data['item'] . " Bought Successfully";
        
       // send_email_to($mail_to, $mail_subject, $emailBody);
        
    }
    
    /* ---------------------------------------------------------------------------------------------------------------------
     *
     *
     *
     * GENERATE LOG SECTION
     *
     *
     *
     * --------------------------------------------------------------------------------------------------------------------
     * */
    public function transactionlogs_post() {
        
        
        check_page_access(true,"BAN");
        
        $start=  $this->post('start',true);
        $length= $this->post('length',true);
        $search= $this->post('search',true);
        
        $data['result']=$this->eshop_model->generate_list_of_transaction($search['value'],$start,$length);
        $total=  $this->eshop_model->get_count_of_transaction();
         $output = array();
        $output['recordsTotal'] = $total;
        $output['recordsFiltered'] = $total;
        $i=1;
        foreach ($data['result'] as $result) {
            
            //$iteminfo=  item_info($data);
            
            
            $item="<img src='$result[image]' width='32px'><br> Name : $result[name]";
            
            $arguments = array($i, $result['character_name'], $result['account_id'], $item,$result['transaction_type'].' coins',$result['item_amount'],$result['old_balance'],$result['new_balance'],$result['date']);
            $output['data'][] = $arguments;
            $i++;
        }

        $this->response($output);
    }
}
