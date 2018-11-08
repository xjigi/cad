<?php 
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:index.php');
}
else{date_default_timezone_set('Africa/Accra');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );
    
    
    
if(isset($_POST['submit']))
{
$cid=$_GET['contract_id'];
$reference_number=$_POST['reference_number'];
$organisation=$_POST['organisation'];
$audit_firm=$_POST['audit_firm'];
$audit_period=$_POST['audit_period'];
$report_status=$_POST['report_status'];
// $number_of_years=$_POST['number_of_years'];
$remarks=$_POST['remarks'];
$appraisal=$_POST['appraisal'];


$sql=mysqli_query($con,"update contracts set reference_number='$reference_number', organisation='$organisation',audit_firm='$audit_firm', audit_period='$audit_period', report_status='$report_status', number_of_years='$number_of_years', remarks='$remarks', appraisal='$appraisal' where contract_id=$cid");
$_SESSION['msg']="contract updated successfully";
header('location:contracts.php');
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
  <link type="text/css" href="css/app.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
  
  <script>
    import * as $ from 'jquery';
    function Confirm(title, msg, $true, $false, $link) { /*change*/
    var $content =  "<div class='dialog-ovelay'>" +
                    "<div class='dialog'><header>" +
                     " <h3> " + title + " </h3> " +
                     "<i class='fa fa-close'></i>" +
                 "</header>" +
                 "<div class='dialog-msg'>" +
                     " <p> " + msg + " </p> " +
                 "</div>" +
                 "<footer>" +
                     "<div class='controls'>" +
                         " <button class='button button-danger doAction'>" + $true + "</button> " +
                         " <button class='button button-default cancelAction'>" + $false + "</button> " +
                     "</div>" +
                 "</footer>" +
              "</div>" +
            "</div>";
     $('body').prepend($content);
  $('.doAction').click(function () {
    window.open($link, "_blank"); /*new*/
    $(this).parents('.dialog-ovelay').fadeOut(500, function () {
      $(this).remove();
    });
  });
$('.cancelAction, .fa-close').click(function () {
    $(this).parents('.dialog-ovelay').fadeOut(500, function () {
      $(this).remove();
    });
  });
  
}
$('#submit').click(function () {
    Confirm('Go to Google', 'Are you sure you want to visit Google', 'Yes', 'Cancel', "https://www.google.com.eg"); /*change*/
});
  </script>
  </head>

  <body>

  <section id="container" >
     <?php include("include/header.php");?>
      
      <div class="wrapper">
		<div class="container">
			<div class="row">
			
			<div class="span9">
					<div class="content">

						<div class="module">
                        <p><a  href="contracts.php" class="btn btn-primary btn-large">ALL CONTRACTS</a></>
							
							<div class="module-body">
          	
          	<?php if(isset($_POST['submit']))
{?>
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">�</button>
									<strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
									</div>
<?php } ?>


									<br />

                     <form class="form-horizontal row-fluid" name="Category" method="post" >
                      <?php
$cid=intval($_GET['contract_id']);
$query=mysqli_query($con,"select * from contracts where contract_id='$cid'");
while($row=mysqli_fetch_array($query))
{
?>

<fieldset>
  <legend>Update Contract</legend>
  <div class="control-group">
    <label class="control-label" for="basicinput">Reference Number</label>
    <div class="controls">
      <input type="text" name="reference_number" required="" value="<?php echo  htmlentities($row['reference_number']);?>" required="" class="form-control">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="basicinput">Organisation</label>
    <div class="controls">
      <select name="organisation" id="organisation" class="span8 tip" onChange="getCat(this.value);" required="">
        <option value=" <?php echo htmlentities($row['organisation']);?>"><?php echo htmlentities($st=$row['organisation']);?></option>
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
        <option value="<?php echo htmlentities($row['audit_firm']);?>"><?php echo htmlentities($st=$row['audit_firm']);?></option>
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
      <input type="text" name="audit_period" value="<?php echo  htmlentities($row['audit_period']);?>" class="form-control">
    </div>
  </div>


  <div class="control-group">
    <label class="control-label" for="basicinput">Report Status</label>
    <div class="controls">
      <select name="report_status" id="report_status" class="span8 tip" onChange="getCat(this.value);" required="">
        <option value="<?php echo htmlentities($row['report_status']);?>"><?php echo htmlentities($st=$row['report_status']);?></option>
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
      <input type="text" name="remarks" value="<?php echo  htmlentities($row['remarks']);?>" class="form-control">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="basicinput">Performnce Appraisal </label>
    <div class="controls">
      <select name="appraisal" id="appraisal" class="span8 tip" onChange="getCat(this.value);" required="">
        <option value="<?php echo htmlentities($row['appraisal']);?>"><?php echo htmlentities($st=$row['appraisal']);?></option>
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
  



  
  <?php } ?>	
  <div class="control-group">
  <div class="controls" style="padding-left:25% ">
  <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
  </div>
  </div>

                            </form>
                            </div>
                            </div>
                            </div>
                            
              
              
      </section>
        </section>
      <?php include("include/footer.php");?>
    </section>

      <!-- js placed at the end of the document so the pages load faster -->
      <script src="assets/js/jquery.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
      <script src="assets/js/jquery.scrollTo.min.js"></script>
      <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


      <!--common script for all pages-->
      <script src="assets/js/common-scripts.js"></script>

      <!--script for this page-->
      <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>

    <!--custom switch-->
    <script src="assets/js/bootstrap-switch.js"></script>
    
    <!--custom tagsinput-->
    <script src="assets/js/jquery.tagsinput.js"></script>
    
    <!--custom checkbox & radio-->
    
    <script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap-daterangepicker/date.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
    
    <script type="text/javascript" src="assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    
    
    <script src="assets/js/form-component.js"></script>    
      
      
    <script>
        //custom select box

        $(function(){
            $('select.styled').customSelect();
        });
        

    </script>

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
  </fieldset>
</html>
<?php } ?>
