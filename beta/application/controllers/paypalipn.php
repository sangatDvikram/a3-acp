<?php

// codeigniter/controllers/example.php

/* This is an example controller showing how to use the PayPal_IPN library. This is a
 * simple example: it does not send any notification emails or similar, it simply
 * logs the order to the database.
 * 
 * This file is copyright (c) 2011 Alexander Dean, alex@keplarllp.com
 * 
 * This file is part of codeigniter-paypal-ipn
 * 
 * codeigniter-paypal-ipn is free software: you can redistribute it and/or modify it under the
 * terms of the GNU Affero General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 * 
 * codeigniter-paypal-ipn is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 * PURPOSE. See the GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * codeigniter-paypal-ipn. If not, see <http://www.gnu.org/licenses/>.
 */

class Paypalipn extends CI_Controller {

    // To handle the IPN post made by PayPal (uses the Paypal_Lib library).
    public function ipn() {
        $this->load->library('PayPal_IPN'); // Load the library
        $this->load->model('payment/payment_model');
        $this->load->model('players/players_model');
        // Try to get the IPN data.
        if ($this->paypal_ipn->validateIPN()) {
            // Succeeded, now let's extract the order
            $this->paypal_ipn->extractOrder();

            // And we save the order now (persist and extract are separate because you might only want to persist the order in certain circumstances).
            $this->paypal_ipn->saveOrder();

            // Now let's check what the payment status is and act accordingly
            if ($this->paypal_ipn->orderStatus == PayPal_IPN::PAID) {
                // Prepare the variables to populate the email template:
                $data = $this->paypal_ipn->order;


                $only_one = $this->payment_model->check_transaction_id($data['txn_id']);
                // Check that transaction is available only once as ipn can be caalled multiplle times
                $account_details = $this->players_model->get_account_details($data['custom']);

                

                    $data['old_coins']=$account_details['pcoins'];
                    
                    $rate = 62.223;
                    $gross_coins = round($data['mc_gross'] * $rate);
                    $percentage = round($data['mc_gross'] * $rate) / 100;
                    $extra_coins = round($percentage * 30);
                    $total = $extra_coins + $gross_coins + $account_details['pcoins']+1;
                    $transaction_coins = $gross_coins + $extra_coins+1;
                    
                    
                    $data['gross_coins']=$gross_coins;
                    $data['extra_coins']=$extra_coins;
                    $data['total_coins']=$total;
                    $data['buyed_coins']=$transaction_coins;
                    
                    $account_data = array('pcoins' => $total);

                    $this->players_model->update_account_details($data['custom'], $account_data);
                    //log_message("error","Paypal has been used",true);
                   
                    create_player_log("$data[custom] bought $data[buyed_coins] premium coins through paypal  !!");
                    
                    
                    
                    
                    $emailBody = $this->load->view('/email_templates/payment_success_formated', $data, TRUE); // You'll have to create your own 
                    //Send Mail to player
                    $mail_to = $data['payer_email'];
                    $mail_subject = $transaction_coins ." Premium Coins Bought Successfully";
                    $mail_body = " you have got $transaction_coins new coins and your total pcoins are $total";
                    send_email_to($mail_to, $mail_subject, $emailBody);

                    //Send Mail to ADMIN
                    $emailBodys = $this->load->view('/email_templates/payment_information_formated', $data, TRUE); // You'll have to create your own 
                    $mail_to = getenv('PAYPAL_ADMIN_EMAIL');
                    $mail_subject = $data['first_name'] . ' ' . $data['last_name'] . " Bought $data[buyed_coins] Premium Coins";
                    $mail_body = $data['first_name'] . ' ' . $data['last_name'] . " bouth premium coins at <b>$$data[mc_gross]</b> have got $transaction_coins new coins and your total pcoins are $total";
                    
                    send_email_to($mail_to, $mail_subject, $emailBodys); 
                    
                
            }
        } else { // Just redirect to the root URL
            $this->load->helper('url');
            redirect('', 'refresh');
        }
    }

}
