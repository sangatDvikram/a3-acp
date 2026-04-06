<?php
require(APPPATH.'libraries/REST_Controller.php');

class Crafting extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('crafting_model');
    }
    function monster_post()
    {



        $name=$this->post('name',true);
        $name = clean_input("/[^a-zA-Z-0-9\s]/", "", $name);
        $monster_list = $this->crafting_model->monster_list($name,'name',false);
        // $data['result']=array('data'=>"Success this is FAKE now Die Killer Die !!! HA HA HA",'error'=>'Yes');

        // $data = array('returned: '. $this->get('id'));
        $this->response($monster_list);
    }
    function monsterFormated_get()
    {



        $name=$this->get('name',true);
        $name = clean_input("/[^a-zA-Z-\s]/", "", $name);

        $monster_list = $this->crafting_model->monster_list($name,'link',true);
        /* $data='';

          foreach ($monster_list as $monsters)
                                     {
                                        $data.= '<div class="col s6 m4" >
                                             <div class="card-panel grey lighten-2 monsters" style="cursor:pointer" id="'.$monsters['monster_code'].'" data-href="'.site_url('guides/maps').'?monster='.$monsters['link'].'">
                                                 <div class="row valign-wrapper" >
                                                     <div class="col s3">';

                                     $data.= '<img src="http://root.a3ultimate.com/allitems/Blank.jpg" alt="" class=" responsive-img"> ';

                                     $data.= '</div><div class="col s9 ">';

                                     $data.= "<span>Name : <b> $monsters[monster_name] </b></span> <br> <span>Map : $data[map_name]<br></span>";

                                     $data.= "</div>
                                         </div>
                                     </div>
                                 </div>
                                 ";

                                     }


         $output['data']="";                  */
        $this->response($monster_list);
    }
    function item_post()
    {



        $name=$this->post('name',true);
        
        $name = clean_input("/[^a-zA-Z0-9\(\)\-\s]/", "", $name);
        
        $monster_list = $this->crafting_model->get_item_details_with_name($name);

         $data= '<div class="row"  >';
                                    $i=1;
                                foreach ($monster_list as $item)
                                {

                                     $data.= '<a href="'.site_url('guides/items').'?item='.$item['link'].'"><div class="col s12 l4 m6 black-text"  >
                                            <div class="card-panel grey lighten-2 " style="cursor:pointer" id="'.$item['item_code'].'" data-href="'.site_url('guides/items').'?item='.$item['link'].'">
                                                <div class="row valign-wrapper" >
                                                    <div class="col s3">';

                                    $data.= '<img src="'.$item['image'].'" alt="" class=" responsive-img"> ';

                                    $data.= '</div><div class="col s9 ">';

                                    $data.= "<span>Name : <b> $item[item_name] </b></span> <br> <span>Type : $item[item_type]<br></span><span>Class : $item[item_class]<br></span>";
                                    if($this->session->userdata('grade')=='BAN')
                                    {
                                        $data.= "Code : <b>$item[item_code]</b>";
                                    }
                                    $data.= "</div>
                                        </div>
                                    </div>
                                </div></a>
                                ";
                                    if($i%3==0) $data.= '</div><div class="row">';
                                    $i++;
                                }
                                    $data.= "</div>";

        $output['data']=$data;
        $this->response($output);
    }
    function itemMonster_post()
    {



        $name=$this->post('code',true);
        $name = clean_input("/[^0-9]/", "", $name);
        
        $monster_list = $this->crafting_model->item_details($name,'code',TRUE);
        $output=array();
        $output['item_code']=$name;
        $data="";
        $count_monsters=count($monster_list[0]['monsters']);

        if($count_monsters!=0)
        {
            foreach($monster_list[0]['monsters'] as $monsters)
            {

                $data.='<a href="'.site_url('guides/maps').'?monster='.$monsters['link'].'"><div class="col s12 m4" >
                                            <div class="card-panel grey lighten-2 black-text" style="cursor:pointer" id="'.$monsters['monster_code'].'" data-href="'.site_url('guides/maps').'?monster='.$monsters['link'].'">
                                                <div class="row valign-wrapper" >
                                                    <div class="col s3">';
                $data.= "<img src='/allitems/monsters/$monsters[monster_code].jpg'  class='responsive-img'> ";

                $data.= '</div><div class="col s9 " style="min-height:70px;font-size:14px">';

                $data.= "<span>Name : <b>". rtrim($monsters['monster_name'])." </b></span> <br> <span>Map : $monsters[map_name]</span>";

                $data.= "</div>
                                                </div>
                                            </div>
                                        </div></a>
                                        ";


                $output['data']=$data;
            }
        }
        else
        {
            $output['data']="<h5>".$monster_list[0]['item_name']." is not droped by any monster.!!</h5>";
        }
        $this->response($output);

    }
    function itemCrafting_post()
    {



        $name=$this->post('code',true);
        $name = clean_input("/[^0-9]/", "", $name);
        
        $monster_list = $this->crafting_model->item_details($name,'code',false,true);
        $output=array();
        $output['item_code']=$name;
        $data="";
        $count_monsters=count($monster_list[0]['crafting']);

        if($count_monsters>0)
        {
            $i=1;
            $data.= '<div class="row" >';
            foreach($monster_list[0]['crafting'] as $crafting)
            {

                $first=item_info($crafting['firstrune']);
                $second=item_info($crafting['secondrune']);
                $third=item_info($crafting['thirdrune']);
                $fourth=item_info($crafting['first']);
                $fifth=item_info($crafting['second']);
                $sixth=item_info($crafting['thrid']);
                $seventh=item_info($crafting['fourth']);
                $eighth=item_info($crafting['fifth']);
                $ninth=item_info($crafting['sixth']);
                $final=item_info($crafting['final']);

               
                $data.= '<div class="col s12 m6"  >';
                $data.= '<div class="card-panel grey lighten-2" >';

                //Crafting  Name
                $data.= '<div class="row" >';

                $data.= '<div class="col s12" >';

                $data.= "<b style='font-size:12px'>Crafting Info for $crafting[waste3] ".$monster_list[0]['item_name'].":</b>";

                $data.= "</div>";

                $data.= "</div>";

                // First Row
                $data.= '<div class="row" >';

                $data.= '<div class="col s2" >';

                $data.= "<img src='".$first[0]['image']."' class='tooltipped items' style='cursor:pointer;' data-position='bottom' data-tooltip='".$first[0]['item_name']."' data-href='".site_url('guides/items')."?item=".$first[0]['link']."'>";

                $data.= "</div>";
                $data.= '<div class="col s2" >';

                $data.= "<img src='".$second[0]['image']."' class='tooltipped items' data-position='bottom' data-tooltip='".$second[0]['item_name']."' data-href='".site_url('guides/items')."?item=".$second[0]['link']."'>";

                $data.= "</div>";
                $data.= '<div class="col s2" >';

                $data.= "<img src='".$third[0]['image']."' class='tooltipped items' data-position='bottom' data-tooltip='".$third[0]['item_name']."'data-href='".site_url('guides/items')."?item=".$third[0]['link']."'>";

                $data.= "</div>";
                $data.= '<div class="col s6" ></div>';

                $data.= "</div>";

                //Second Row
                $data.= '<div class="row" >';

                $data.= '<div class="col s2" >';

                $data.= "<img src='".$fourth[0]['image']."' class='tooltipped items' style='cursor:pointer;'  data-position='bottom' data-tooltip='".$fourth[0]['item_name']."'data-href='".site_url('guides/items')."?item=".$fourth[0]['link']."'>";

                $data.= "</div>";
                $data.= '<div class="col s2" >';

                $data.= "<img src='".$fifth[0]['image']."' class='tooltipped items' style='cursor:pointer;'  data-position='bottom' data-tooltip='".$fifth[0]['item_name']."'data-href='".site_url('guides/items')."?item=".$fifth[0]['link']."'>";

                $data.= "</div>";
                $data.= '<div class="col s2" >';

                $data.= "<img src='".$sixth[0]['image']."' class='tooltipped items' style='cursor:pointer;'  data-position='bottom' data-tooltip='".$sixth[0]['item_name']."'data-href='".site_url('guides/items')."?item=".$sixth[0]['link']."'>";

                $data.= "</div>";
                $data.= '<div class="col s6" ></div>';

                $data.= "</div>";

                //Third row
                $data.= '<div class="row" >';

                $data.= '<div class="col s2" >';

                $data.= "<img src='".$seventh[0]['image']."' class='tooltipped items' style='cursor:pointer;'  data-position='bottom' data-tooltip='".$seventh[0]['item_name']."'data-href='".site_url('guides/items')."?item=".$seventh[0]['link']."'>";

                $data.= "</div>";
                $data.= '<div class="col s2" >';

                $data.= "<img src='".$eighth[0]['image']."' class='tooltipped items' style='cursor:pointer;'  data-position='bottom' data-tooltip='".$eighth[0]['item_name']."'data-href='".site_url('guides/items')."?item=".$eighth[0]['link']."'>";

                $data.= "</div>";
                $data.= '<div class="col s2" >';

                $data.= "<img src='".$ninth[0]['image']."' class='tooltipped items' style='cursor:pointer;'  data-position='bottom' data-tooltip='".$ninth[0]['item_name']."'data-href='".site_url('guides/items')."?item=".$ninth[0]['link']."'>";

                $data.= "</div>";
                $data.= '<div class="col s6" ></div>';

                $data.= "</div>";
                //Forth row
                $data.= '<div class="row" >';

                $data.= '<div class="col s4 offset-s2" >';

                $data.= "<img src='".$final[0]['image']."' class='tooltipped items' style='cursor:pointer;' data-position='bottom' data-tooltip='".$final[0]['item_name']."' data-href='".site_url('guides/items')."?item=".$final[0]['link']."'>";


                $data.= "</div>";
                $data.= '<div class="col s6" ></div>';

                $data.= "</div>";
                //Crafting  Details
                $data.= '<div class="row " >';

                $data.= '<div class="col s12" >';

                $data.= '<div class="row valign-wrapper" >';

                $data.= '<div class="col s12 valign" >';

                $data.= "Final Result : <img src='".$monster_list[0]['image']."' class='tooltipped items' style='cursor:pointer;' data-position='bottom' data-tooltip='".$monster_list[0]['item_name']."'data-href='".site_url('guides/items')."?item='".$monster_list[0]['link']."'>";


                $data.= "</div>";

                $data.= "</div>";

                $data.= "<span> Success Rate : <span class='light-green-text text-accent-4'>$crafting[sucess] % </span></span>";

                if($crafting['waste1']==1){$data.= "<br>If Failed : <span class='red-text'> Item will destroy !!</span> ";}

                $data.= "</div>";

                $data.= "</div>";


                $data.= "</div>";

                $data.= "</div>";


                //$data=$first[0]['item_name'];
                if($i%2==0) $data.= '</div ><div class"row">';
                $i++;
            }
            $data.= '</div >';
            $output['data']=$data;
        }
        else
        {
            $output['data']="<h5>".$monster_list[0]['item_name']." cannot be crafted.!!</h5>";
        }
        $this->response($output);
    }
    function itemOptions_post()
    {

        $name=$this->post('code',true);
        $name = clean_input("/[^0-9]/", "", $name);
        
        $monster_list = $this->crafting_model->item_details($name,'code',false,false,true);
        $this->response($monster_list);
    }
    function items_get()
    {

        $name=$this->get('code',true);
        $name = clean_input("/[^0-9]/", "", $name);
        
        $monster_list = $this->crafting_model->item_details($name,'code');
        $this->response($monster_list);
    }
    


}