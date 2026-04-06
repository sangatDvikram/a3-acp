<?php

if (!function_exists('check_slots')) {

    function get_slots($input) {
        $sr = explode(";", $input);
        $filled = array();
        $source = array_values($sr);
        $count = count($source);
        for ($i = 3; $i < $count; $i +=4) {
            $filled[] = $source[$i];
        }

        $slot_array = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29");

        $emptyInvt = array_diff($slot_array, $filled);
        //reset array
        $emptyInvt = array_values($emptyInvt);

        return array('filled' => $filled, 'empty' => $emptyInvt);
    }

}

if (!function_exists('get_all_inventory_items')) {

    function get_all_inventory_items($character_inventory) {

        $character_slots = get_slots($character_inventory);

        $i = 0;
        foreach ($character_slots['filled'] as $filled) {

            $output[$filled] = get_inventory_slot_item($i, $character_inventory);
            $i++;
        }
        foreach ($character_slots['empty'] as $empty) {
            $output[$empty] = '0;0;0;' . $empty;
        }
        ksort($output);

        return $output;
    }

}

if (!function_exists('get_inventory_slot_item')) {

    function get_inventory_slot_item($slot, $character_inventory) {


        $exploded_inventory = explode(';', $character_inventory);
        $slot = ($slot * 4) + 3;
        $output = $exploded_inventory[$slot - 3] . ";" . $exploded_inventory[$slot - 2] . ';' . $exploded_inventory[$slot - 1] . ";" . $exploded_inventory[$slot];

        return $output;
    }

}

if (!function_exists('character_exist_in_account')) {

    function character_exist_in_account($character) {

        $ci = &get_instance();
        $ci->load->model('players/players_model');
        $character_exist = $ci->players_model->get_current_character_details($character);

        if (count($character_exist) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

if (!function_exists('get_character_info')) {

    function get_character_info($character) {


        $ci = &get_instance();
        $ci->load->model('players/players_model');

        $playerinfo = $ci->players_model->get_perticular_character_details($character);


        if (count($playerinfo) > 0) {

            $numrow = '';
            $reset = $playerinfo["reset"];
            $online = $playerinfo["pnline"];
            $name = $playerinfo["c_id"];
            $level = $playerinfo["c_sheaderc"];
            $grade = $playerinfo["acc_status"];
            $rb = $playerinfo["rb"];
            $char_type = $playerinfo['c_sheaderb'];
            $nation = $playerinfo['Nation'];
            $date = $playerinfo['d_udate'];
            $minuts = $playerinfo["online"];
            $minuts1 = floor($minuts / 60) . "hr " . ($minuts % 60) . "Min";
// Deside Class :) 
            $class = "";
            if ($char_type == '0') {
                $class = "Warrior";
            } else {
                if ($char_type == '1') {
                    $class = "Holy Knight";
                } else {
                    if ($char_type == '2') {
                        $class = "Mage";
                    } else {
                        if ($char_type == '3') {
                            $class = "Archer";
                        }
                    }
                }
            }

//Deside Rank
            if ($reset == '3') {
                $rank = "Emperor";
                $style = '';
            } else {
                if ($level == '166') {
                    $rank = "King";
                    $style = 'background:url(/images/backround17.gif) 0 -5px repeat;z-index:6;Padding:2px;color:#088A08;text-shadow: 1px 1px 3px #000000;zoom:1';
                } else {
                    if ($reset == '1') {
                        $rank = "Viscount";
                        $style = 'background:url(/images/backround7.gif) 0 -5px repeat;z-index:6;Padding:2px;color:#FE2E2E;text-shadow: 1px 1px 3px #FA5858;zoom:1';
                    } else {
                        if ($reset == null || $reset == '0') {
                            $rank = "Ultimate Soldier";
                            $style = '';
                        } else {
                            if ($reset == '-1') {
                                $rank = "Test Character";
                                $style = '';
                            }
                        }
                    }
                }
            }

            if ($grade == "Admin" || $grade == "GM" || $grade == "Admin1") {
                $rank = "Game Master";
                $style = 'background:url(/images/backround21.gif) -25px -17px repeat;z-index:6;Padding:2px;color:#FF8000;text-shadow: 0.1em 0.1em 0.2em #FE9A2E;zoom:1';
            }



            // Online Status

            if ($online == 1) {
                $status = 'Online';
                $statusImage = "<img src='/images/status.png' title='Online'>";
            } else {
                $status = 'Offline';
                $statusImage = "<img src='/images/status-offline.png' title='Offline'>";
            }
            //Nation Status
            $town = '';
            if ($nation == '0') {
                $town = "Temoz";
            } else { 
                if ($nation == '1') {
                    $town = "Quanato";
                } else {
                    if ($nation == '2') {
                        $town = "Town not updated";
                    } else {
                        if ($nation == '3') {
                            $town = "Hatrel";
                        }
                    }
                }
            }


            $townImage = "<img src='/images/town$town.png' alt='$town' title='$town'>";

            $styledName = "<span style='$style' title='$rank'>$name</span>";


            $info = array('Name' => $name, 'StyledName' => $styledName, 'Type' => $class, 'Rb' => $rb, 'Reset' => $reset, 'Nation' => $town, 'NationImage' => $townImage, 'login' => $date, 'Rank' => $rank, 'OnlineTime' => $minuts1, 'OnlineStatus' => $status, 'StatusImage' => $statusImage, 'TypeNum' => $char_type, 'Style' => $style, 'Referred' => $numrow, 'Level' => $level,'Account'=>trim($playerinfo['c_sheadera']));
            return $info;
        } else {
            $info = array('Name' => $character, 'StyledName' => $character, 'Type' => '', 'Rb' => '', 'Reset' => '', 'Nation' => '', 'NationImage' => '', 'login' => '', 'Rank' => '', 'OnlineTime' => '', 'OnlineStatus' => '', 'StatusImage' => '', 'TypeNum' => '99', 'Style' => '', 'Referred' => '', 'Level' => '','Account'=>'');
            return $info;
        }
    }

}

if (!function_exists('get_wear_item')) {

    function get_wear_item($character_wear) {


        $character_wears = array("Necklace" => "0;0;0;", "Helmet" => "0;0;0;", "Rings" => "0;0;0;", "Weapon" => "0;0;0;", "Armor" => "0;0;0;", "Shield" => "0;0;0;", "Gloves" => "0;0;0;", "Pant" => "0;0;0;", "Boots" => "0;0;0;");
        // ksort($character_wears);
        $explode_character_wear = explode(';', $character_wear);

        $wear_array = array_chunk($explode_character_wear, 3);

        $wear_items = array();
        foreach ($wear_array as $wear) {
            $wear_items[] = join(";", $wear);
        }

        foreach ($wear_items as $item) {
            $item_info = get_item_options($item);
            if (array_key_exists($item_info['item_type'], $character_wears)) {
                $character_wears[$item_info['item_type']] = $item;
            }
        }

        return $character_wears;
    }

}

if (!function_exists('get_mbody_part')) {

    //return value of the mbody part
    function get_mbody_part($attrib, $mbody) {
        $temp = explode('\_1', $mbody);
        switch ($attrib) {
            case 'EXP' :
                $EXP = explode('=', $temp[0]);
                return $EXP[1];
                break;

            case 'SKILL' :
                $SKILL = explode('=', $temp[1]);
                return $SKILL[1];
                break;

            case 'PK' :
                $PK = explode('=', $temp[2]);
                return $PK[1];
                break;

            case 'RTM' :
                $RTM = explode('=', $temp[3]);
                return $RTM[1];
                break;

            case 'SINFO' :
                $SINFO = explode('=', $temp[4]);
                return $SINFO[1];
                break;

            case 'WEAR' :
                $WEAR = explode('=', $temp[5]);
                return $WEAR[1];
                break;

            case 'INVEN' :
                $INVEN = explode('=', $temp[6]);
                return $INVEN[1];
                break;

            case 'PETINV' :
                $PETINV = explode('=', $temp[7]);
                return $PETINV[1];
                break;

            case 'CQUEST' :
                $CQUEST = explode('=', $temp[8]);
                return $CQUEST[1];
                break;

            case 'WAR' :
                $WAR = explode('=', $temp[9]);
                return $WAR[1];
                break;

            case 'SQUEST' :
                $SQUEST = explode('=', $temp[10]);
                return $SQUEST[1];
                break;

            case 'FAVOR' :
                $FAVOR = explode('=', $temp[11]);
                return $FAVOR[1];
                break;

            case 'PSKILL' :
                $PSKILL = explode('=', $temp[12]);
                return $PSKILL[1];
                break;

            case 'SKLSLT' :
                $SKLSLT = explode('=', $temp[13]);
                return $SKLSLT[1];
                break;

            case 'CHATOPT' :
                $CHATOPT = explode('=', $temp[14]);
                return $CHATOPT[1];
                break;

            case 'TYR' :
                $TYR = explode('=', $temp[15]);
                return $TYR[1];
                break;

            case 'SKILLEX' :
                $SKILLEX = explode('=', $temp[16]);
                return $SKILLEX[1];
                break;

            case 'SKLSLTEX' :
                $SKLSLTEX = explode('=', $temp[17]);
                return $SKLSLTEX[1];
                break;

            case 'PETACT' :
                $PETACT = explode('=', $temp[18]);
                return $PETACT[1];
                break;

            case 'LORE' :
                $LORE = explode('=', $temp[19]);
                return $LORE[1];
                break;

            case 'LQUEST' :
                $LQUEST = explode('=', $temp[20]);
                return $LQUEST[1];
                break;

            case 'RESRV0' :
                $RESRV0 = explode('=', $temp[21]);
                return $RESRV0[1];
                break;

            case 'RESRV1' :
                $RESRV1 = explode('=', $temp[22]);
                return $RESRV1[1];
                break;
        }
    }

}

if (!function_exists('do_mbody_insert')) {


//return the whole  modified string
    function do_mbody_insert($attrib, $newstring, $mbody) {
        $temp = explode('\_1', $mbody);
        switch ($attrib) {
            case 'EXP' :
                $EXP = explode('=', $temp[0]);
                $EXP[1] = $newstring;
                $temp[0] = implode('=', $EXP);
                break;

            case 'SKILL' :
                $SKILL = explode('=', $temp[1]);
                $SKILL[1] = $newstring;
                $temp[1] = implode('=', $SKILL);
                break;

            case 'PK' :
                $PK = explode('=', $temp[2]);
                $PK[1] = $newstring;
                $temp[2] = implode('=', $PK);
                break;

            case 'RTM' :
                $RTM = explode('=', $temp[3]);
                $RTM[1] = $newstring;
                $temp[3] = implode('=', $RTM);
                break;

            case 'SINFO' :
                $SINFO = explode('=', $temp[4]);
                $SINFO[1] = $newstring;
                $temp[4] = implode('=', $SINFO);
                break;

            case 'WEAR' :
                $WEAR = explode('=', $temp[5]);
                $WEAR[1] = $newstring;
                $temp[5] = implode('=', $WEAR);
                break;

            case 'INVEN' :
                $INVEN = explode('=', $temp[6]);
                $INVEN[1] = $newstring;
                $temp[6] = implode('=', $INVEN);
                break;

            case 'PETINV' :
                $PETINV = explode('=', $temp[7]);
                $PETINV[1] = $newstring;
                $temp[7] = implode('=', $PETINV);
                break;

            case 'CQUEST' :
                $CQUEST = explode('=', $temp[8]);
                $CQUEST[1] = $newstring;
                $temp[8] = implode('=', $CQUEST);
                break;

            case 'WAR' :
                $WAR = explode('=', $temp[9]);
                $WAR[1] = $newstring;
                $temp[9] = implode('=', $WAR);
                break;

            case 'SQUEST' :
                $SQUEST = explode('=', $temp[10]);
                $SQUEST[1] = $newstring;
                $temp[10] = implode('=', $SQUEST);
                break;

            case 'FAVOR' :
                $FAVOR = explode('=', $temp[11]);
                $FAVOR[1] = $newstring;
                $temp[11] = implode('=', $FAVOR);
                break;

            case 'PSKILL' :
                $PSKILL = explode('=', $temp[12]);
                $PSKILL[1] = $newstring;
                $temp[12] = implode('=', $PSKILL);
                break;

            case 'SKLSLT' :
                $SKLSLT = explode('=', $temp[13]);
                $SKLSLT[1] = $newstring;
                $temp[13] = implode('=', $SKLSLT);
                break;

            case 'CHATOPT' :
                $CHATOPT = explode('=', $temp[14]);
                $CHATOPT[1] = $newstring;
                $temp[14] = implode('=', $CHATOPT);
                break;

            case 'TYR' :
                $TYR = explode('=', $temp[15]);
                $TYR[1] = $newstring;
                $temp[15] = implode('=', $TYR);
                break;

            case 'SKILLEX' :
                $SKILLEX = explode('=', $temp[16]);
                $SKILLEX[1] = $newstring;
                $temp[16] = implode('=', $SKILLEX);
                break;

            case 'SKLSLTEX' :
                $SKLSLTEX = explode('=', $temp[17]);
                $SKLSLTEX[1] = $newstring;
                $temp[17] = implode('=', $SKLSLTEX);
                break;

            case 'PETACT' :
                $PETACT = explode('=', $temp[18]);
                $PETACT[1] = $newstring;
                $temp[18] = implode('=', $PETACT);
                break;

            case 'LORE' :
                $LORE = explode('=', $temp[19]);
                $LORE[1] = $newstring;
                $temp[19] = implode('=', $LORE);
                break;

            case 'LQUEST' :
                $LQUEST = explode('=', $temp[20]);
                $LQUEST[1] = $newstring;
                $temp[20] = implode('=', $LQUEST);
                break;

            case 'RESRV0' :
                $RESRV0 = explode('=', $temp[21]);
                $RESRV0[1] = $newstring;
                $temp[21] = implode('=', $RESRV0);
                break;

            case 'RESRV1' :
                $RESRV1 = explode('=', $temp[22]);
                $RESRV1[1] = $newstring;
                $temp[22] = implode('=', $RESRV1);
                break;
        }
        return implode('\_1', $temp);
    }

}