<?php

if (!function_exists('get_item_options')) {

    function get_item_options($item) {

        $item_parts = explode(';', $item);

        $player_items = array('Warrior', 'HK', 'Archer', 'Mage', 'Rings', 'Necklace');

        // If item is not Storage box
        $output = array('first_option' => $item_parts[0], 'second_option' => $item_parts[1]);

        if ($item_parts[0] != 17) {

            $first_part_options = first_part_options_decode($item_parts[0]);



            $item_information = item_info("" . $first_part_options['item'] . "");



            $item_information = (is_array($item_information)) ? $item_information[0] : "";

            if ($item_information['item_type'] == 'Weapon') {
                $second_part_options = second_part_options_decode($item_parts[1], $item_information['item_class'] . $item_information['item_weapon_type']);
            } else {
                $second_part_options = second_part_options_decode($item_parts[1], $item_information['item_type']);
            }
            if ($second_part_options['remaining'] == '481') {
                $item_information['item_type'] = 'Shield';
            }
           
            $options_type = option_types($item_information['item_type']);

            $output['item_options_type'] = (in_array($item_information['item_class'], $player_items)) ? "Player" : "Normal";
            $output = array_merge($output, $first_part_options);
            $output = array_merge($output, $second_part_options);
            $output = array_merge($output, $item_information);
            $output = array_merge($output, $options_type);
             if ($item_information['item_type'] == "Gloves") {
                $output['blue']=$output['blue']*5;
            }
            return $output;
        } else {
            $storage_box_first_part_options = item_info("" . $item_parts[0] . "");

            $storage_box_second_part_options = storage_box_options_decode($item_parts[1]);

            $storage_box_item_information = item_info("" . $storage_box_second_part_options['storage_box_item'] . "");

            foreach ($storage_box_item_information[0] as $k => $v) {
                $storage_box_item_information[0]['storage_box_' . $k] = $v;
                unset($storage_box_item_information[0][$k]);
            }

            $output['item_options_type'] = "17";
            $output = array_merge($output, $storage_box_first_part_options[0]);
            $output = array_merge($output, $storage_box_second_part_options);
            $output = array_merge($output, $storage_box_item_information[0]);
            // $output=array_merge($output,$options_type);
            return $output;
        }
    }

}






if (!function_exists('second_part_options_decode')) {

    function second_part_options_decode($options, $wep_type) {

        $type["Armor"] = 4129;
        $type["Boots"] = 7201;
        $type["Gloves"] = 6177;
        $type['Helmet'] = 3105;
        $type['Pant'] = 5153;
        $type['Shield'] = 481;
        $type['WarriorSword'] = 2145;
        $type['WarriorSpear'] = 2273;
        $type['WarriorAxe'] = 2209;
        $type['HKSword'] = 1377;
        $type['HKMace'] = 1441;
        $type['MageEle'] = 2337;
        $type['MageNon-Ele'] = 2721;
        $type['ArcherBow'] = 1569;
        $type['ArcherxBow'] = 1633;

        $grey_mod = fmod($options, 67108864);
        $grey_minus_main = $options - $grey_mod;
        $grey = $grey_minus_main / 67108864;

        $red_mod = fmod($grey_mod, 1048576);
        $red_minus_gery = $grey_mod - $red_mod;
        $red = $red_minus_gery / 1048576;

        $blue_mod = fmod($red_mod, 16384);
        $blue_minus_red = $red_mod - $blue_mod;
        $blue = $blue_minus_red / 16384;

        $something_mod = fmod($blue_mod, 32);
        $remaining = $blue_mod - $something_mod;
        $remaining = $remaining + 1;
        $unidentified = fmod($remaining, 3);


        $Level_mod = fmod($something_mod, 16);
        $level_minus_somthing = $something_mod - $Level_mod;
        $new = $level_minus_somthing / 16;

        $something_minus_level = $something_mod - $Level_mod;


        $add = $something_minus_level / 16;
        if (in_array($wep_type, $type))
            $unidentified = (($remaining - $type[$wep_type]) == 0) ? 'No' : 'Yes';
        else
            $unidentified = 'No';
        $Additional = ($add == 1) ? 'Yes' : 'No';

        /* return  array('Main'=>$options,'grey_mod' =>$grey_mod ,'grey_minus_main'=>$grey_minus_main,'grey'=>$grey,'red_mod'=>$red_mod,'red_minus_gery'=>$red_minus_gery,'red'=>$red,'blue_mod'=>$blue_mod,'blue_minus_red'=>$blue_minus_red,'blue'=>$blue,'something_mod'=>$something_mod,'remaining'=>$remaining,'unidentified'=>$unidentified,'Level_mod'=>$Level_mod,'level_minus_somthing'=>$level_minus_somthing,'new'=>$new,'something_minus_level'=>$something_minus_level,'add'=>$add,'Additional'=>$Additional ); */
        return array('additional' => $Additional, 'blue' => $blue, 'red' => $red, 'grey' => $grey, 'level' => $Level_mod, 'unidentified' => $unidentified, 'remaining' => $remaining);
    }

}

if (!function_exists('storage_box_options_decode')) {

    function storage_box_options_decode($options) {

        $item = fmod($options, 16384);
        $bb = $options - $item;
        $count = $bb / 16384;
        return array('storage_box_item' => $item, 'storage_box_item_count' => $count);
    }

}

if (!function_exists('first_part_options_decode')) {

    function first_part_options_decode($options) {

        $options = (int) $options;
        $mount = fmod($options, 65536);
        $bb = $options - $mount;
        $mcount = $bb / 65536;
        $item = fmod($mount, 32768);
        $bb = $mount - $item;
        $adatt = $bb / 32768;
        $mcount = ($mcount * 10) . "%";
        $ad1 = ($adatt == 1) ? 'Yes' : 'No';
        return array('mounting' => $mcount, 'blessings' => $ad1, 'item' => $item);
    }

}
if (!function_exists('option_types')) {

    function option_types($typ) {


        if ($typ == 'Weapon') {
            $grey_type = "<span style=\"color:#848484\">Fire Attack :  </span> ";
        } else if ($typ == 'Armor') {
            $grey_type = "<span style=\"color:#848484\">Fire Defence :  </span> ";
        } else if ($typ == 'Boots') {
            $grey_type = "<span style=\"color:#848484\">Increase in Critical Hit Rate :  </span> ";
        } else if ($typ == 'Pant') {
            $grey_type = "<span style=\"color:#848484\">Increase in Magic Evasion :  </span> ";
        } else if ($typ == 'Gloves') {
            $grey_type = "<span style=\"color:#848484\">Increased in Skills Attack Damage :  </span> ";
        } else if ($typ == 'Helmet') {
            $grey_type = "<span style=\"color:#848484\">HP/MP Consumption:  </span> ";
        } else {
            $grey_type = "<span style=\"color:#848484\">Grey option :  </span> ";
        }



        if ($typ == 'Weapon') {
            $red_type = "<span style=\"color:#DF0101\">Fire Attack :  </span> ";
        } else if ($typ == 'Armor') {
            $red_type = "<span style=\"color:#DF0101\">Fire Defence :  </span> ";
        } else if ($typ == 'Boots') {
            $red_type = "<span style=\"color:#DF0101\">Wz Acquistion: </span> ";
        } else if ($typ == 'Pant') {
            $red_type = "<span style=\"color:#DF0101\">Increase in Evasion :  </span> ";
        } else if ($typ == 'Gloves') {
            $red_type = "<span style=\"color:#DF0101\">Increased in Basic Attack Damage :  </span> ";
        } else if ($typ == 'Helmet') {
            $red_type = "<span style=\"color:#DF0101\">HP Absorbtion :  </span> ";
        } else {
            $red_type = "<span style=\"color:#DF0101\">Red option :  </span> ";
        }


        if ($typ == 'Weapon') {
            $blue_type = "<span style=\"color:#013ADF\">Ice Attack :  </span> ";
        } else if ($typ == 'Armor') {
            $blue_type = "<span style=\"color:#013ADF\">Ice Defence :  </span> ";
        } else if ($typ == 'Boots') {
            $blue_type = "<span style=\"color:#013ADF\">Increase in Critical Hit Evasation :  </span> ";
        } else if ($typ == 'Pant') {
            $blue_type = "<span style=\"color:#013ADF\">Increase in Accuracy :  </span> ";
        } else if ($typ == 'Gloves') {
            $blue_type = "<span style=\"color:#013ADF\">Increased in Skill Duration : </span> ";
        } else if ($typ == 'Helmet') {
            $blue_type = "<span style=\"color:#013ADF\">MP Absorbtion :  </span> ";
        } else {
            $blue_type = "<span style=\"color:#013ADF\">Blue option :  </span> ";
        }

        return array("blue_type" => $blue_type, "red_type" => $red_type, "grey_type" => $grey_type);
    }

}

if (!function_exists('item_option_format')) {

    /**
     * 
     * @param type item_info
     * @return type array of image formated with tooltipped and link to item in  crafting guide and formated data
     */
    function item_option_format($item_info) {

        $item_data = "";
        $item_data.="Item Name : <b>" . $item_info['item_name'] . "</b><br>";
        $item_data.="Class : <b>" . $item_info['item_class'] . "</b><br>";
        $item_data.="Type : <b>" . $item_info['item_type'] . "</b><br>";
        $item_data.="Info : <b>" . $item_info['item_info'] . "</b><br>";
        if ($item_info['item_options_type'] == 'Player') {
            
            $item_data.="Level : " . $item_info['level'] . "<br>";
            if ($item_info['blessings'] == 'Yes')
                $item_data.="Blessing : " . $item_info['blessings'] . "<br>";
            if ($item_info['blue'] > 0)
                $item_data.=" $item_info[blue_type] " . $item_info['blue'] . "<br>";
            if ($item_info['red'] > 0)
                $item_data.=" $item_info[red_type] " . $item_info['red'] . "<br>";
            if ($item_info['grey'] > 0)
                $item_data.=" $item_info[grey_type]  " . $item_info['grey'] . "<br>";
            if ($item_info['mounting'] != '0%')
                $item_data.="Mounting : " . $item_info['mounting'] . "<br>";
            if ($item_info['additional'] == 'Yes')
                $item_data.="Additional : " . $item_info['additional'] . "<br>";
            if ($item_info['unidentified'] == 'Yes')
                $item_data.="Unidentified : " . $item_info['unidentified'] . "<br>";
        }
        if ($item_info['item_options_type'] == "17") {
            $item_data.="Storage Box Item Name : <b>" . $item_info['storage_box_item_name'] . "</b><br>";
            $item_data.="Storage Box Item Count : " . $item_info['storage_box_item_count'] . "<br>";
        }

        $image = '<a href="' . site_url('guides/items') . '?item=' . $item_info['link'] . '">' . "<img src='" . $item_info['image'] . "' class='responsive-img tooltipped player-item'  data-position='bottom' data-delay='50' data-tooltip='$item_info[item_name]' style='cursor:pointer' data-info='$item_data'></a>";

        return array('image' => $image, 'data' => $item_data);
    }

}

