<?php
$ring = '';
$neck = '';
$hel = '';
$wep = '';
$arm = '';
$shld = '';
$glow = '';
$pant = '';
$boot = '';
$pic = array();
$names = array();
$stat = array();
for ($i = 1; $i <= 9; $i++)
{
    $info = wearoption($i, $char);
    $info1 = wearoption(($i + 1), $char);
    $img = $info['Image'];
    $name = trim(clear($info['Name']));
    if ($name != '')
    {
        if ($info['Blessing'] == 'Yes')
        {
            $bless = "<span style='color:#DF3A01'>Blessing : Yes</span><br>";
        } else
        {
            $bless = '';
        }
        if ($info['Additional'] == 'Yes')
        {
            $attk = "<span style='color:#04B404'>Additional Attack : Yes</span><br>";
        } else
        {
            $attk = '';
        }
        if ($info['Blue'] != '0')
        {
            if ($info['Type'] == 'Weapon')
            {
                $blue = "<span style='color:#013ADF'>Ice Attack : $info[Blue].</span><br>";
            } else if ($info['Type'] == 'Armor')
            {
                $blue = "<span style='color:#013ADF'>Ice Defence : $info[Blue].</span><br>";
            } else if ($info['Type'] == 'Shield')
            {
                $blue = "<span style='color:#013ADF'>Ice Defence : $info[Blue].</span><br>";
            } else if ($info['Type'] == 'Boots')
            {
                $blue = "<span style='color:#013ADF'>Increase in Critical Hit Evasation : $info[Blue].</span><br>";
            } else if ($info['Type'] == 'Pant')
            {
                $blue = "<span style='color:#013ADF'>Increase in Accuracy : $info[Blue].</span><br>";
            } else if ($info['Type'] == 'Gloves')
            {
                $blue = "<span style='color:#013ADF'>Increased in Skill Duration : " . ($info['Blue'] * 5) . ".</span><br>";
            } else if ($info['Type'] == 'Helmet')
            {
                $blue = "<span style='color:#013ADF'>MP Absorbtion : $info[Blue].</span><br>";
            } else
            {
                $blue = "<span style='color:#013ADF'>Blue option : $info[Blue].</span><br>";
            }

        } else
        {
            $blue = '';
        }
        if ($info['Red'] != '0')
        {
            if ($info['Type'] == 'Weapon')
            {
                $red = "<span style='color:#DF0101'>Fire Attack : $info[Red].</span><br>";
            } else if ($info['Type'] == 'Armor')
            {
                $red = "<span style='color:#DF0101'>Fire Defence : $info[Red].</span><br>";
            } else if ($info['Type'] == 'Shield')
            {
                $red = "<span style='color:#DF0101'>Fire Defence : $info[Red].</span><br>";
            } else if ($info['Type'] == 'Boots')
            {
                $red = "<span style='color:#DF0101'>Wz Acquistion: " . ($info['Red'] * 5) . ".</span><br>";
            } else if ($info['Type'] == 'Pant')
            {
                $red = "<span style='color:#DF0101'>Increase in Evasion : $info[Red].</span><br>";
            } else if ($info['Type'] == 'Gloves')
            {
                $red = "<span style='color:#DF0101'>Increased in Basic Attack Damage : $info[Red].</span><br>";
            } else if ($info['Type'] == 'Helmet')
            {
                $red = "<span style='color:#DF0101'>HP Absorbtion : $info[Red].</span><br>";
            } else
            {
                $red = "<span style='color:#DF0101'>Red option : $info[Red].</span><br>";
            }

        } else
        {
            $red = '';
        }
        if ($info['Grey'] != '0')
        {
            if ($info['Type'] == 'Weapon')
            {
                $grey = "<span style='color:#848484'>Lightining Attack : $info[Grey].</span><br>";
            } else if ($info['Type'] == 'Armor')
            {
                $grey = "<span style='color:#848484'>Lightining Defence : $info[Grey].</span><br>";
            } else if ($info['Type'] == 'Shield')
            {
                $grey = "<span style='color:#848484'>Lightining Defence : $info[Grey].</span><br>";
            } else if ($info['Type'] == 'Boots')
            {
                $grey = "<span style='color:#848484'>Increase in Critical Hit Rate : $info[Grey].</span><br>";
            } else if ($info['Type'] == 'Pant')
            {
                $grey = "<span style='color:#848484'>Increase in Magic Evasion : $info[Grey].</span><br>";
            } else if ($info['Type'] == 'Gloves')
            {
                $grey = "<span style='color:#848484'>Increased in Skills Attack Damage : $info[Grey].</span><br>";
            } else if ($info['Type'] == 'Helmet')
            {
                $grey = "<span style='color:#848484'>HP/MP Consumption: $info[Grey].</span><br>";
            } else
            {
                $grey = "<span style='color:#848484'>Grey option : $info[Grey].</span><br>";
            }

        } else
        {
            $grey = '';
        }
        if ($info['Level'] != '0')
        {
            $level = "<span style='color:#3A01DF' >Level : $info[Level].</span><br>";
        } else
        {
            $level = '';
        }
        if ($info['Mount'] != '0%')
        {
            $mount = "<span style='color:#DF0174'>Mounting : $info[Mount].</span><br>";
        } else
        {
            $mount = '';
        }
        $message = " $level $bless $blue $red $grey $mount $attk ";
        if ($info['Type'] == 'Rings')
        {
            $pic['Ring'] = $img;
            $names['Ring'] = $name;
            $stat['Ring'] = $message;
        }
        if ($info['Type'] == 'Necklace')
        {
            $pic['Necklace'] = $img;
            $names['Necklace'] = $name;
            $stat['Necklace'] = $message;
        }

        if ($info['Type'] == 'Armor')
        {

            $pic['Armor'] = $img;
            $names['Armor'] = $name;
            $stat['Armor'] = $message;
        }
        if ($info['Type'] == 'Shield')
        {
            $pic['Shield'] = $img;
            $names['Shield'] = $name;
            $stat['Shield'] = $message;
        }

        if ($info['Type'] == 'Weapon' && $info1['Type'] == 'Weapon')
        {
            $pic['Shield'] = $img;
            $names['Shield'] = $name;
            $stat['Shield'] = $message;
        }

        if ($info['Type'] == 'Weapon')
        {
            $pic['Weapon'] = $img;
            $names['Weapon'] = $name;
            $stat['Weapon'] = $message;
        }

        if ($info['Type'] == 'Boots')
        {
            $pic['Boots'] = $img;
            $names['Boots'] = $name;
            $stat['Boots'] = $message;
        }
        if ($info['Type'] == 'Pant')
        {
            $pic['Pant'] = $img;
            $names['Pant'] = $name;
            $stat['Pant'] = $message;
        }
        if ($info['Type'] == 'Gloves')
        {
            $pic['Gloves'] = $img;
            $names['Gloves'] = $name;
            $stat['Gloves'] = $message;
        }
        if ($info['Type'] == 'Helmet')
        {
            $pic['Helmet'] = $img;
            $names['Helmet'] = $name;
            $stat['Helmet'] = $message;
        }

    }

}


?>