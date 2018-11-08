
<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


if(isset($_POST['submit']))
{
	$query = mysqli_query($con, "SELECT * FROM contracts where organisation='$_POST[organisation]' && audit_firm='$_POST[audit_firm]'");
	$_SESSION['msg']="Query Complete";

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>OUT-SOURCED AUDITS PORTAL</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>

    
</head>
<body>
<?php include('include/header.php');?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
			
			<div class="span9">
					<div class="content">

						<div class="module">
                        <p><a  href="contracts.php" class="btn btn-primary btn-medium">View All Contracts</a></>
							
							<div class="module-body">

									

									<br />

			<form class="form-horizontal row-fluid" name="Category" method="post" >
									
<fieldset>
<legend>Querry for Number of Years on the Job</legend>

<div class="control-group">
<label class="control-label" for="basicinput">Select Organisation</label>
<div class="controls">
<select name="organisation" id="organisation" class="span8 tip" onChange="getCat(this.value);">
<option value="">Select Organisation</option>
<?php $sql=mysqli_query($con,"select organisation_name from organisations ");
	while ($rw=mysqli_fetch_array($sql)) {
?>
  <option value="<?php echo htmlentities($rw['organisation_name']);?>"><?php echo htmlentities($rw['organisation_name']);?></option>
<?php
}
?>
</select>
</div>
</div>

 
<div class="control-group">
<label class="control-label" for="basicinput">Select Audit Firm</label>
<div class="controls">
<select name="audit_firm" id="audit_firm" class="span8 tip">
<option value="" name="audit_firm">Select Audit Firm</option>
<?php $sql=mysqli_query($con,"select audit_firm_name from audit_firms ");
while ($rw=mysqli_fetch_array($sql)) {
  ?>
  <option value="<?php echo htmlentities($rw['audit_firm_name']);?>"><?php echo htmlentities($rw['audit_firm_name']);?></option>
<?php
}
?>
</select>
</div>
</div>

	<div class="control-group">
											<div class="controls">
												<button type="submit" name="submit" class="btn btn-primary btn-medium">Check Occurance</button> 
											</div>
										</div>
									</form>
							</div>
						</div>

		<div class="container">
			<div class="row">
		
			<div class="span9">
							
							<div class="module-body table">
	
									<br />
							
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-2 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											
											<th>Organisation</th>
											<th>Audit Firm</th>											
                                            <th>Occurance</th>
                                            <th>Audit Period</th>
										
										</tr>
									</thead>
									<tbody>
<!--Calculate Count for same Audit firm & Organization-->

<?php 

	// $audit_form = $_POST['audit_fitm'];
	// $organisation = $_POST['organisation'];
	// $result = mysqli_query($con, "SELECT * FROM contracts where organisation='$_POST[organisation]' && audit_firm='$_POST[audit_firm]'");
	$result ='select t.* from contracts t';

	<?php if(isset($_POST['submit']))
									{
									
	if ($_POST['audit_firm'] != '' && empty($_POST['organisation'])) {
		$result = mysqli_query($con, "SELECT * FROM contracts where audit_firm='$_POST[audit_firm]'");
	}elseif ($_POST['organisation'] != '' && empty($_POST['audit_firm'])) {
		$result = mysqli_query($con, "SELECT * FROM contracts where organisation='$_POST[organisation]'");
	}elseif (!empty($_POST['audit_firm']) && !empty($_POST['organisation'])) {
		$result = mysqli_query($con, "SELECT * FROM contracts where organisation='$_POST[organisation]' && audit_firm='$_POST[audit_firm]'");
	}
	elseif(empty($_POST['audit_firm']) && empty($_POST['organisation'])) {
		$result = mysqli_query($con, "select t.* from contracts t");
	}
	if ($result->num_rows == 0) {?>
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>No Records Found!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
		</div>
	<?php die();} ?>
	<?php
	$list = [];
	//Process Result
	while( $i = mysqli_fetch_array($result)){
		$list[] = $i;
	}
	$_keys = array_map(function($i) {
		return str_replace(' ', '', $i['organisation'] . $i['audit_firm']);
	}, $list);

	$_keys = array_unique($_keys);
	$keys = [];
	foreach ($_keys as $i) {
		$keys[$i] = 0;
	}

	for ($d = 0; $d < count($list); $d++) {
		$i = &$list[$d];
		$count = $keys[str_replace(' ', '', $i['organisation'] . $i['audit_firm'])];
		$count += 1;
		$i['occurance'] = $count;
		$keys[str_replace(' ', '', $i['organisation'] . $i['audit_firm'])] = $count;
	} ?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
		</div>

	 <!--End Calculate Count for same Audit firm & Organization-->
<?php
	foreach ($list as $row) {


?>									
							<tr>
								 
							<td ><a href="contract_details.php?organisation=<?php echo urlencode($row['organisation'])?>"><?php echo htmlentities($row['organisation']);?></td>  

							<td ><a href="contract_details.php?audit_firm=<?php echo urlencode($row['audit_firm'])?>"><?php echo htmlentities($row['audit_firm']);?></td> 

							<td style="text-align:center;"><?php echo $row['occurance']?>
							</td>
							<td><a href="contract_details.php?audit_period=<?php echo $row['audit_period']?>"><?php echo htmlentities($row['audit_period']);?></td></a>
                                 
                                 
										<?php  } ?>
										
								</table>
                               
							</div>
                            
						</div>						

						

						
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

<?php include('include/footer.php');?>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>
<?php } ?>