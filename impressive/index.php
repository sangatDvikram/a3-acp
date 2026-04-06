<?php
$db_host = 'localhost'; // Server Name
$db_user = 'root'; // Username
$db_pass = ''; // Password
$db_name = 'a3acp'; // Database Name

$account = $_GET['user'];

foreach($_GET as $key => $value) {
	$get[$key] = antisql($value); //get variables are filtered.
}

$GLOBALS[account] = $account;
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());	
}

$sql = "SELECT * FROM expenses where name = '$account' order by datecreated desc";

		
$query = mysqli_query($conn, $sql);


$err = array();

if (!$query) {
	die ('SQL Error: ' . mysqli_error($conn));
}
?>
<?php 
	$sql2 = "SELECT sum(amount) AS amount_sum FROM expenses where name ='$account' and detail !='--Cash--'";
	$query2 = mysqli_query($conn,$sql2);
	$tot = mysqli_fetch_assoc($query2);
	$total = $tot['amount_sum'];

	$sql3 = "SELECT sum(amount) AS amount_sum FROM expenses where optdesc ='$account'";
	$query3 = mysqli_query($conn,$sql3);
	$tot3 = mysqli_fetch_assoc($query3);
	$credit = $tot3['amount_sum'];

	$sql4 = "SELECT sum(amount) AS amount_sum FROM expenses where name ='$account' and detail ='--Cash--'";
	$query4 = mysqli_query($conn,$sql4);
	$tot4 = mysqli_fetch_assoc($query4);
	$given = $tot4['amount_sum'];
	$amtleft = $credit-$total-$given;
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		$amt = $_POST['amount'];
		$det = $_POST['details'];
		$comp = $_POST['company'];
		$givecash_name = $_POST['givecash_names'];
		$cashdesc = $_POST['cashdesc'];
		$comm = $_POST['newcomment'];
		$comm = ucfirst ($comm);
		$comm = str_replace(' ', '_', $comm);
		$user = $_POST['user'];
		$optdesc = $_POST['optdesc'];

		if($amt < 0 || $amt == "")
		{
			$err[] = "Please Enter Valid Amount";
		}
		if(($det=="" && $comm==""))
		{
			$err[] = "Please Select Proper description";
		}

		if($det == "--Cash--")
		{
			$comp = $cashdesc;
			$optdesc = $givecash_name;
		}

		//echo 'OPTDESC: ' . $optdesc;
		if(empty($err))
		{

			if($comm == "")
			{
				if($optdesc!="")	
					$quer = "INSERT into expenses (name,detail,amount,company,optdesc) VALUES ('$user','$det','$amt','$comp','$optdesc')";
				else
					$quer = "INSERT into expenses (name,detail,company,amount) VALUES ('$user','$det','$comp','$amt')";		
			}
			else
			{
				if($optdesc!="")	
					$quer = "INSERT into expenses (name,detail,amount,company,optdesc) VALUES ('$user','$comm','$amt','$comp','$optdesc')";
				else
					$quer = "INSERT into expenses (name,detail,company,amount) VALUES ('$user','$comm','$comp','$amt')";		
			}
			$quer1 = mysqli_query($conn,$quer);

			if($quer1)
			{
				header("LOCATION: /impressive/?user=". $user);
			}
		}

		if(!empty($err))
		{
			echo '<div style="margin-bottom: 20px;"></div>';
			echo '<span class="error">'; 
			foreach($err as $e) 
			{
				echo $e. '<br>';
			} 
			echo '</span>';
		}
	}

	?>
<!DOCTYPE html>
<html>
<head>
	<title>Detailed View of Expenses</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="style.css"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript">
		$(document).ready(function(){

			$("#refbtn").click(function(){
				location.reload(true);
				function clearjQueryCache(){
    				for (var x in jQuery.cache){
        				delete jQuery.cache[x];
    			}
			}
			});

			$("#addnewcomment").hide();
			$("#optdesc").hide();
			$("#givecash_names").hide();
			$("#cash_rec_table").hide();
			$("#cash_given_table").hide();
			$("#cashdesc").hide();

			$("#exp_btn").click(function(){
				$("#cash_rec_table").fadeOut();
				$("#cash_given_table").fadeOut();
				$("#expense_table").fadeIn();
			});

			$("#cash_recieved_btn").click(function(){
				$("#expense_table").fadeOut();				
				$("#cash_given_table").fadeOut();
				$("#cash_rec_table").fadeIn();				
			});

			$("#cash_given_btn").click(function(){
				$("#expense_table").fadeOut();
				$("#cash_rec_table").fadeOut();
				$("#cash_given_table").fadeIn();				
				
			});


			//var x = document.getElementById("amounttext").setCustomValidity("Please Enter a Valid Amount.");
			$('#details').change(function () {
     			var optionSelected = $(this).find("option:selected");
     			var valueSelected  = optionSelected.val();
     			var textSelected   = optionSelected.text();
     			

     			if(valueSelected == "--Cash--")
     			{
     				$("#givecash_names").fadeIn();
     				$("#cashdesc").fadeIn();
     				$(this).fadeOut();
     				$("#optdesc").fadeOut();
     				$("#rad_buttons").fadeOut();
     			}
     			else
     			{
     				$("#rad_buttons").fadeIn();
     				$("#optdesc").fadeIn();	
     				$("#givecash_names").hide();
     			}

     			if(valueSelected == "newitem")
     			{
     				$("#addnewcomment").fadeIn();
     				$(this).fadeOut();	
     				//$("#addnewcomment").css('display','block');     				
     				$("#optdesc").fadeIn();
     			}
     			else
     			{
     				$("#addnewcomment").hide();
     			}
 			});		
		});
	</script>
</head>
<body>
<div class="container" unselectable="on">
	<h1>Add new</h1>
	<button class="refbtn" id="refbtn">Refresh</button>
	<form class="addnewform" method="POST">
		<input type="tel" name="amount" id="amounttext" autocomplete="off" placeholder="Enter Amount" /><br>
		<?php 
			$myquer = "SELECT DISTINCT detail from expenses ORDER BY detail ASC";
			$myquer1 = mysqli_query($conn, $myquer);

			if (!$myquer1) {
				die ('SQL Error: ' . mysqli_error($conn));
			}
			echo '<select id="details" name="details">';
			echo '<option value="" disabled selected>Select</option>';
			echo 
			'<option id="newcommentoption" value="newitem"><b>--New Item--</b></option>
			<option id="givecash" value="--Cash--"><b>--Cash--</b></option>';
			while($row1 = mysqli_fetch_array($myquer1))
			{
				if($row1['detail']!="--Cash--")
					echo '<option value='. $row1['detail'] .'>'. $row1['detail'] .'</option>';
			} 
			echo'</select><br>';

			
		?>	
		<select id="givecash_names" name="givecash_names">
			<option value="sandeep">Sandeep</option>
			<option value="pritam">Pritam</option>
			<option value="sharma">Sharma</option>
			<option value="yadav">Yadav</option>
			<option value="dinesh">Dinesh</option>
			<option value="vinod">Vinod</option>
			<option value="pappu">Pappu</option>
			<option value="sarafat">Sarafat</option>
			<option value="kripashankar">Kripashankar</option>
			<option value="naresh">Naresh</option>
			<option value="pandit">Pandit</option>
			<option value="umesh">Umesh</option>
			<option value="sitaram">Sitaram</option>
			<option value="samim_Line">Samim Line</option>
			<option value="parwez">Parwez</option>
		</select>
		<input id="addnewcomment" type="text" name="newcomment" placeholder="Add new description" autocomplete="off"/><br>
		<input id="cashdesc" type="text" name="cashdesc" placeholder="Cash description" autocomplete="off"/><br>
		<input id="optdesc" type="text" name="optdesc" placeholder="Add Optional Description" autocomplete="off"><br>
		<center id="rad_buttons">
		<input type="radio" name="company" value="TA" checked>1 Number<br><br>
		<label><input type="radio" name="company" id="BK" value="BK">
		<label for="BK">BK House</label><br><br>
  		<input type="radio" name="company" value="35">35 Number<br><br>
  		<input type="radio" name="company" value="Combined">Combined</center><br><br>
		<input type="submit" id="insertnew" name="addnew" value="Submit" />	
		<input type="text" style="display:none;" value="<?php echo $account; ?>" name="user">
	</form>

	
	<br><br>
	<center><h5><?php echo 'Cash Recieved = ' . $credit; ?></h5>
	<h5><?php echo 'Amount Spent = ' . $total; ?></h5>
	<h5><?php echo 'Amount given to others = ' . $given; ?></h5>
	<h1><?php echo 'Amount Left with you = ' . $amtleft; ?></h1>
	<input type="button" name="exp_btn" id="exp_btn" value="Expense"></input>
	<input type="button" name="cash_given_btn" id="cash_given_btn" value="Cash Given"></input>
	<input type="button" name="cash_recieved_btn" id="cash_recieved_btn" value="Cash recieved"></input></center>
	<table class="data-table" id="expense_table">
		<caption class="title">Expenses for Impressive Style</caption>
		<thead>
			<tr>
				<!-- <th>Sr No.</th> -->
				<th>Company</th>
				<th>Detail</th>
				<th>AMOUNT</th>
				<th>DATE</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no 	= 1;
		$total 	= 0;
		while ($row = mysqli_fetch_array($query))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			if($row['detail']!="--Cash--")
			{
				if($row['optdesc']!="")
					echo '<tr title="'.$row['optdesc'].'">';
				else
					echo '<tr>';
				echo '
						<td>'.$row['company'].'</td>
						<td>'.$row['detail'].'</td>
						<td>'.$amount.'</td>
						<td>'. date('jS F, h:iA', strtotime($row['datecreated'])) . '</td>
						<td>'.$row['optdesc'].'</td>
					</tr>';
				$total += $row['amount'];
				$no++;
			}
		}?>
		<!-- <td>'.$no.'</td>
		<td>'.$row['name'].'</td> -->
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2">TOTAL<php? $account ?></th>
				<th><?=number_format($total)?></th>
			</tr>
		</tfoot>
	</table>

	<table class="data-table" id="cash_rec_table">
		<caption class="title"><h2>Cash Recieved by You</h2></caption>
		<thead>
			<tr>
				<!-- <th>Sr No.</th> -->
				<th>Received From</th>
				<th>AMOUNT</th>
				<th>DATE</th>
				<th>Description</th>

			</tr>
		</thead>
		<tbody>
		<?php
		$total=0;

		$sql1 = "SELECT * FROM expenses where optdesc = '$account' order by datecreated desc";		
		$query2 = mysqli_query($conn, $sql1);

		while ($row = mysqli_fetch_array($query2))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			if($row['optdesc']!="")
				echo '<tr title="'.$row['optdesc'].'">';
			else
				echo '<tr>';
			echo '
					<td>'.$row['name'].'</td>
					<td>'.$amount.'</td>
					<td>'. date('jS F, h:iA', strtotime($row['datecreated'])) . '</td>
					<td>'.$row['company'].'</td>

				</tr>';
		$total += $row['amount'];
		}?>
		<!-- <td>'.$no.'</td>
		<td>'.$row['name'].'</td> -->
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2">TOTAL<php? $account ?></th>
				<th><?=number_format($total)?></th>
			</tr>
		</tfoot>
	</table>

	<table class="data-table" id="cash_given_table">
		<caption class="title"><h2>Cash Given by You</h2></caption>
		<thead>
			<tr>
				<!-- <th>Sr No.</th> -->
				<th>Given To</th>
				<th>AMOUNT</th>
				<th>DATE</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$total=0;

		$sql1 = "SELECT * FROM expenses where detail = '--Cash--' and name='$account' order by datecreated desc";		
		$query2 = mysqli_query($conn, $sql1);

		while ($row = mysqli_fetch_array($query2))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			if($row['optdesc']!="")
				echo '<tr title="'.$row['optdesc'].'">';
			else
				echo '<tr>';
			echo '
					<td>'.$row['optdesc'].'</td>
					<td>'.$amount.'</td>
					<td>'. date('jS F, h:iA', strtotime($row['datecreated'])) . '</td>
					<td>'.$row['company'].'</td>

				</tr>';
		$total += $row['amount'];
		}?>
		<!-- <td>'.$no.'</td>
		<td>'.$row['name'].'</td> -->
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2">TOTAL<php? $account ?></th>
				<th><?=number_format($total)?></th>
			</tr>
		</tfoot>
	</table>
</div>
</body>

</html>