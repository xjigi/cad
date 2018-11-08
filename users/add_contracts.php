
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

session_start();
include('include/config.php');
include('include/mail_controller.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


if(isset($_POST['submit']))
{
	$_SESSION['msg']="Save not allowed for more than 5 Occurances ";

		$reference_number=$_POST['reference_number'];
		$organisation=$_POST['organisation'];
		$audit_firm=$_POST['audit_firm'];
		$audit_period=$_POST['audit_period'];
		$report_status=$_POST['report_status'];
		$remarks=$_POST['remarks'];
		$appraisal=$_POST['appraisal'];

		$result = mysqli_query($con, "select * from contracts WHERE organisation ='$organisation' && audit_firm='$audit_firm'");
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
		}
	// var_dump($count); die();
		// <!--End Calculate Count for same Audit firm & Organization-->
	

//Save New Contract

if ($count == 3) {

	$query=mysqli_query($con,"insert into contracts(reference_number, organisation, audit_firm, audit_period, report_status, remarks, appraisal) values('$reference_number', '$organisation', '$audit_firm', '$audit_period', '$report_status', '$remarks', '$appraisal')");

	$_SESSION['msg']="Contract created successfully";
	#send mail
	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	
	//Load Composer's autoloader
	// require 'vendor/autoload.php';
	
	// require('./PHPMailer/class.phpmailer.php');
	$mail=new PHPMailer(true);
	try{
	set_time_limit(0);
	// $mail->CharSet = 'UTF-8';

	$body = "This is the 4th Occurance for  $organisation  &  $audit_firm  Thank you";
	$name = 'AGD Ghana';

	$mail->IsSMTP();
	// $mail->Host       = 'smtp.gmail.com';

	// $mail->SMTPSecure = 'tls';
	// $mail->Port       = 587;
	$mail->Host = 'ssl://smtp.gmail.com:465';
	// $mail->SMTPDebug  = 2;
	$mail->SMTPAuth   = true;

	$mail->Username   = 'traderkojo@gmail.com';
	$mail->Password   = 'quadwontow_55443121';

	$mail->SetFrom('traderkojo@gmail.com', $name);
	$mail->AddReplyTo('traderkojo@gmail.com','no-reply');
	$mail->Subject    = 'Audit Portal Occurances Limit';
	$mail->MsgHTML($body);

	// $mail->AddAddress('niiamoo2006@gmail.com', $name);
	$mail->AddAddress('traderkojo@gmail.com', 'title2'); /* ... */

	// $mail->AddAttachment($fileName);
	$mail->send();
	echo 'Mail Sent';
	} catch (Exception $e) {
		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
	#send mail
	
}elseif ($count == 4) {	# 5th Occurance
	$query=mysqli_query($con,"insert into contracts(reference_number, organisation, audit_firm, audit_period, report_status, remarks, appraisal) values('$reference_number', '$organisation', '$audit_firm', '$audit_period', '$report_status', '$remarks', '$appraisal')");

	$_SESSION['msg']="Contract created successfully";
	#send mail
	$mail=new PHPMailer(true);
	try{
	set_time_limit(0);
	$mail->CharSet = 'UTF-8';

	$body = "This is the 5th and final Occurance for  $organisation  &  $audit_firm  Thank you";
	$name = 'CAD Ghana';

	$mail->IsSMTP();
	// $mail->Host       = 'smtp.gmail.com';

	// $mail->SMTPSecure = 'tls';
	// $mail->Port       = 587;
	$mail->Host = 'ssl://smtp.gmail.com:465';
	// $mail->SMTPDebug  = 2;
	$mail->SMTPAuth   = true;

	$mail->Username   = 'traderkojo@gmail.com';
	$mail->Password   = 'quadwontow_55443121';

	$mail->SetFrom('traderkojo@gmail.com', $name);
	$mail->AddReplyTo('traderkojo@gmail.com','no-reply');
	$mail->Subject    = 'Audit Portal Occurances Limit';
	$mail->MsgHTML($body);

	// $mail->AddAddress('niiamoo2006@gmail.com', $name);
	$mail->AddAddress('traderkojo@gmail.com', 'title2'); /* ... */

	// $mail->AddAttachment($fileName);
	$mail->send();
	echo 'Mail Sent';
	} catch (Exception $e) {
		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
	#send mail
}elseif ($count > 4) { ?>
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>Sorry!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
		</div>
<?php } else { 
	

$query=mysqli_query($con,"insert into contracts(reference_number, organisation, audit_firm, audit_period, report_status, remarks, appraisal) values('$reference_number', '$organisation', '$audit_firm', '$audit_period', '$report_status', '$remarks', '$appraisal')");

$_SESSION['msg']="Contract created successfully";

	}
}

if(isset($_GET['del']))
		  {
		          mysqli_query($con,"delete from contracts where contract_id = '".$_GET['contract_id']."'");
                  $_SESSION['delmsg']="Category deleted !!";
		  } ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>OUT-SOURCED AUDITS PORTAL</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="css/app.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>

    <!--App JS-->
	<script src="scripts/app.js" type="text/javascript"></script>
</head>
<body>
<?php include('include/header.php');?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
			
			<div class="span9">
					<div class="content">

						<div class="module">
                        <p><a  href="contracts.php" class="btn btn-primary btn-large">All Contracts</a></>
							
							<div class="module-body">

									<?php if(isset($_POST['submit']))
{?>
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">x</button>
									<strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
									</div>
<?php } ?>


									<?php if(isset($_GET['del']))
{?>
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">�</button>
									<strong>Oh snap!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
									</div>
<?php } ?>

									<br />

			<form class="form-horizontal row-fluid" name="Category" method="post" >
									
<fieldset>
<legend>New Contract</legend>
<div class="control-group">
<label class="control-label" for="basicinput">Reference Number</label>
<div class="controls">
<input type="text" name="reference_number" required="" value="" required="" class="span8 tip">
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Organisation</label>
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
<label class="control-label" for="basicinput">Audit Firm</label>
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
<label class="control-label" for="basicinput">Auditing Period</label>
<div class="controls">
<input type="text" name="audit_period" required="" value="" required="" class="span8 tip">
</div>
</div>



<div class="control-group">
<label class="control-label" for="basicinput">Report Status</label>
<div class="controls">
<select name="report_status" id="report_status" class="span8 tip" onChange="getCat(this.value);" required="">
<option value="">Select Status</option>
<?php $sql=mysqli_query($con,"select status from report_status ");
while ($rw=mysqli_fetch_array($sql)) {
  ?>
  <option value="<?php echo htmlentities($rw['status']);?>"><?php echo htmlentities($rw['status']);?></option>
<?php
}
?>
</select>
</div>
</div>


<div class="control-group">
<label class="control-label" for="basicinput">Remarks</label>
<div class="controls">
<input type="text" name="remarks" required="" value="" required="" class="span8 tip">
</div>
</div>


<div class="control-group">
<label class="control-label" for="basicinput">Performance Appraisal </label>
<div class="controls">
<select name="appraisal" id="appraisal" class="span8 tip" onChange="getCat(this.value);" required="">
<option value="">Select Status</option>
<?php $sql=mysqli_query($con,"select appraisal_name from appraisal ");
while ($rw=mysqli_fetch_array($sql)) {
  ?>
  <option value="<?php echo htmlentities($rw['appraisal_name']);?>"><?php echo htmlentities($rw['appraisal_name']);?></option>
<?php
}
?>
</select>
</div>
</div>



	<div class="control-group">
											<div class="controls">
												<button type="submit" name="submit" class="btn">Create</button> 
											</div>
										</div>
									</form>
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