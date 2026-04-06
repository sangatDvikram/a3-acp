<html>
<head>
	
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
<h1> Session Calculator</h1>
<?php 

$min_runs = 200;

$min_loops = floor($min_runs/20)-1;

//echo $min_loops;

$i=1;
$j=1;
echo "<table class='table  table-bordered' id='runs_table'>
  <thead>
  <tr>";
//for($i=0;$i<=$min_loops;$i++){

echo "<th>Runs</th>";
echo "<th>Win/Loss</th>";

//}


echo "</tr></thead>";
echo "<tbody id='runs_table_body'>";

/*for ($j=1; $j <=20 ; $j++) { 
	echo "<tr>";
	for($i = 0;$i <= $min_loops;$i++){
		$calculated_value = ($i*20)+$j;
		echo "<td id='$calculated_value-run'>";
			echo $calculated_value;
		echo "</td>";
		echo "<td id='$calculated_value-run-win'>";
			echo 0;
		echo "</td>";
	}
	echo "</tr>";
}*/

echo "</tbody>";
echo "</table>";


?>

<h3>Entries</h3>
<h5>Refresh the page to reset to 0 (P.S. you will lose all the data after refreshing. </h5>

<form class="form-inline" id="betting_form">
	<div class="form-group">
		<label for="runs">Runs</label>
		<input type="number" class="form-control" id="runs" placeholder="Runs" required>
	</div>
	<div class="form-group">
		<label for="amount">Amount</label>
		<input type="number" class="form-control" id="amount" placeholder="Amount" required>
	</div>

	<label class="radio-inline">
		<input type="radio" name="inlineRadioOptions" id="type_yes" value="Yes" checked=""> Yes
	</label>
	<label class="radio-inline">
		<input type="radio" name="inlineRadioOptions" id="type_no" value="No" > No
	</label>
	<button type="submit" class="btn btn-default" return="false">Subimt</button>
</form>

<table class="table" id='betting_table'>
	<thead>
		<tr>
			<th>#</th>
			<th>Runs</th>
			<th>Amount</th>
			<th>Yes/No</th>	
		</tr>	
	</thead>
	<tbody id='betting_table_body'>
		
	</tbody>
	
</table>

<script type="text/javascript">

var min_runs = <?php echo $min_runs; ?>;
var min_loops = <?php echo $min_loops; ?>;

var betting_array ={};

function processForm(betting_run,betting_array) {
    	
    	/*for (var j=1; j <=20 ; j++) { 
	    		for(var k = 0;k <= min_loops;k++){
	    			var calculated_value = (k*20)+j;
	    			var won_temp=0;
	    			var won = 0;
	    			for(property in betting_array) {
	    				if(calculated_value>=betting_array[property]['value'])
	    				{
	    					won_temp = parseInt(betting_array[property]['yes']) - parseInt(betting_array[property]['no']);
	    				}	
	    				else
	    				{
	    					won_temp = parseInt(betting_array[property]['no']) - parseInt(betting_array[property]['yes']);
	    				}
	    				won = parseInt(won) + parseInt(won_temp);
	    			}
	    				
	    			var win_value = document.getElementById(calculated_value+'-run-win');
	    			if(parseInt(won)>0){
	    				win_value.className += " success";
	    			}
	    			else{
	    				win_value.className += " danger";
	    			}
	    			win_value.innerHTML = won;
	    		}
	    		
	    	}

		*/
		var sorted_array = sortObject(betting_array);
		var values = getMaxandMin(sorted_array);

		var deleteNodes = document.getElementById("runs_table_body");
		while (deleteNodes.firstChild) {
			deleteNodes.removeChild(deleteNodes.firstChild);
		}

		var min_value = values['min'];
		var max_value = values['max']; 
		console.log("Min: "+min_value);
		console.log("Max: "+max_value);
		var min_minus_five = ((parseInt(min_value)-5 > 0) ? parseInt(min_value)- 5 : 0);
		var min_plus_five = (parseInt(min_value) + 5);

		var max_plus_five =(parseInt(max_value) + 5); 
		var max_minus_five = ((parseInt(max_value) - 5 > 0) ? parseInt(max_value) - 5 : 0);
		
		if(min_value == max_value) {
			addToTableBody(min_minus_five,min_plus_five);
		}
		else
		{
			addToTableBody(min_minus_five,max_plus_five);
		}
		
		var get_all_runs = document.getElementById("runs_table_body").getElementsByTagName("tr");

		for (var i = 0; i < get_all_runs.length; i++) {
			var won_temp = 0;
			var won = 0;
			for(property in betting_array) {
				console.log('Working With : ' + get_all_runs[i].id);
				
				if(parseInt(get_all_runs[i].id)>=betting_array[property]['value'])
				{
					won_temp = parseInt(betting_array[property]['yes']) - parseInt(betting_array[property]['no']);
				}	
				else
				{
					won_temp = parseInt(betting_array[property]['no']) - parseInt(betting_array[property]['yes']);
				}
				won = parseInt(won) + parseInt(won_temp);
			}
			var win_value = document.getElementById(get_all_runs[i].id+'-run-win');
			if(parseInt(won)>0){
				win_value.className += " success";
			}
			else{
				win_value.className += " danger";
			}
			win_value.innerHTML = won;
		}
		return false;
}
function addToTableBody(min,max)
{
	for(var itarator=min;itarator<max;itarator++){
		addSingleToTableBody(itarator)
	}
}
function addSingleToTableBody(itarator)
{
	    var has_id = 0; 
		var all_runs = document.getElementById("runs_table_body").getElementsByTagName("tr");
		var run = itarator;
		for (var i = 0; i < all_runs.length; i++) {
			if(all_runs[i].id == run){ has_id = 1; }
		}
		if(has_id == 0)
		{
			var increment = 1;		
			var table = document.getElementById("runs_table_body");
			var tr = document.createElement('tr');
			tr.setAttribute('id',run);
			var inc = tr.appendChild(document.createElement('td'));
			inc.innerHTML = run;
			inc.setAttribute("id", run+"-run");
			var runs = tr.appendChild(document.createElement('td'));
			runs.innerHTML = 0;
			runs.setAttribute("id", run+"-run-win");
			table.appendChild(tr);
		}
}
function getMaxandMin(sorted_array)
{
	// There's no real number bigger than plus Infinity
var lowest = 0;
var highest = 0;
var tmp;
lowest = sorted_array[0].key;
highest = sorted_array[sorted_array.length - 1].key;

return {min:lowest,max:highest};
}
function sortObject(obj) {
    var arr = [];
    var prop;
    for (prop in obj) {
        if (obj.hasOwnProperty(prop)) {
            arr.push({
                'key': prop,
                'value': obj[prop]['value']
            });
        }
    }
    arr.sort(function(a, b) {
        return a.value - b.value;
    });
    console.log(arr);
    return arr; // returns array
}
var increment = 1;
var won_value = 0;
var form = document.getElementById('betting_form').addEventListener("submit", function(event){
    event.preventDefault()

    	// Should be triggered on form submit
		//alert('hi');
		// You must return false to prevent the default form behavior
		
		var betting_run = document.getElementById('runs').value;
		var betting_amount = document.getElementById('amount').value;
		var yes_or_no = 0;
		var table = document.getElementById("betting_table_body");
		var tr = document.createElement('tr');
		var inc = tr.appendChild(document.createElement('td'));
	    inc.innerHTML = increment;
	    var runs = tr.appendChild(document.createElement('td'));
	    runs.innerHTML = betting_run;
	    var amount = tr.appendChild(document.createElement('td'));
	    amount.innerHTML = betting_amount;
	    var options = tr.appendChild(document.createElement('td'));
	    var rate_value = "";

	    if(!(betting_run in betting_array)){
	    	betting_array[betting_run] = {value:betting_run,yes:0,no:0};
	    }

	    if (document.getElementById('type_yes').checked) {
  			options.innerHTML = document.getElementById('type_yes').value;
  			yes_or_no = 1;
  			betting_array[betting_run]["yes"] = betting_amount;
		}
		else{
			options.innerHTML = document.getElementById('type_no').value;
			yes_or_no = 0;
			betting_array[betting_run]['no'] = betting_amount;
		}
	    table.appendChild(tr);
	    document.getElementById("betting_form").reset();
	    //project.push([betting_run,betting_amount,yes_or_no]);

	    
	    processForm(betting_run,betting_array);
	    
	    	
	    
	    increment++;
});

</script>
</body>
</html>