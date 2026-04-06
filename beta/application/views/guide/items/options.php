<h4 id='items' style='cursor:pointer;' data-toggle='options-info' data-state='show' class='hidder' >Item Options <i class='mdi-hardware-keyboard-arrow-down arrowoptions right' style='cursor:pointer;margin-bottom:-1%' data-toggle='options-info' data-state='show'></i>
</h4>
<div class='divider'></div>
<div class='section col s12 m12' id='options-info' data-item='' data-type='options'>

      <table class="responsive-table hoverable">
        <thead>
          <tr>
              <th data-field="id">Name</th>
              <th data-field="name">Cost</th>
              <th data-field="price">Item Level</th>
              <th data-field="price">Range</th>
              <th data-field="price">Damage/Defense</th>
              <th data-field="price">Peridot/Sapphire(Blue)
 </th>
              <th data-field="price">Garnet/Ruby(Red)
 </th>
              <th data-field="price">Opal/Topaz(Yellow)
 </th>
             
          </tr>
        </thead>

        <tbody>
         <tr>
            <td>
        <?php 

        $total=count($item['options']);
        echo $total;


        ?>
        </td>
         
            <td>Eclair</td>
            <td>$0.87</td>
            <td>$0.87</td>
            <td>$0.87</td>
            <td>$0.87</td>
            <td>$0.87</td>
            <td>$0.87</td>
          </tr>
          
        </tbody>
      </table>


</div>