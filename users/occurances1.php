
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


$organisation=$_POST['organisation'];
$audit_firm=$_POST['audit_firm'];
$audit_period=$_POST['audit_period'];
$report_status=$_POST['report_status'];
$remarks=$_POST['remarks'];
$appraisal=$_POST['appraisal'];


$query=mysqli_query($con,"insert into contracts(organisation, audit_firm, audit_period, report_status, remarks, appraisal) values('$organisation', '$audit_firm', '$audit_period', '$report_status', '$remarks', '$appraisal')");

$_SESSION['msg']="Contract created successfully";

}

if(isset($_GET['del']))
		  {
		          mysqli_query($con,"delete from contracts where contract_id = '".$_GET['contract_id']."'");
                  $_SESSION['delmsg']="Category deleted !!";
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

									<?php if(isset($_POST['submit']))
{?>
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
									</div>
<?php } ?>


									<?php if(isset($_GET['del']))
{?>
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Oh snap!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
									</div>
<?php } ?>

									<br />

			<form class="form-horizontal row-fluid" name="Category" method="post" >
									
<fieldset>
<legend>Querry for Number of Years on the Job</legend>

<div class="control-group">
<label class="control-label" for="basicinput">Select Organisation</label>
<div class="controls">
<select name="organisation" id="organisation" class="span8 tip" onChange="getCat(this.value);" required="">
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
<select name="audit_firm" id="audit_firm" class="span8 tip"  required="">
<option value="">Select Audit Firm</option>
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
                                            
										
										</tr>
									</thead>
									<tbody>
<!--Calculate Count for same Audit firm & Organization-->

<?php 
	$result = mysqli_query($con, "select t.* from contracts t");
	// var_dump($result);
	//$list = mysqli_fetch_all($result, MYSQLI_ASSOC);
	// $list = mysqli_fetch_all(mysqli_query($con,"select *, 0 [occurance] from contracts ") ,MYSQLI_ASSOC);
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
	//var_dump($keys);die();

	for ($d = 0; $d < count($list); $d++) {
		$i = &$list[$d];
		$count = $keys[str_replace(' ', '', $i['organisation'] . $i['audit_firm'])];
		$count += 1;
		// var_dump($count);
		// var_dump($i['occurance']);
		$i['occurance'] = $count;
		//var_dump($i['occurance']);
		//break;
		$keys[str_replace(' ', '', $i['organisation'] . $i['audit_firm'])] = $count;
	}
	// var_dump($list[0]['occurance']);die();

	// <!--End Calculate Count for same Audit firm & Organization-->

	foreach ($list as $row) {


?>									
							<tr>
								 
                                 <td ><?php echo htmlentities($row['organisation']);?></td>
                                 <td ><?php echo htmlentities($row['audit_firm']);?></td>                                 
                                 <td style="text-align:center;"><?php echo $row['occurance']?></td>
                                 
                                 
                                 
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