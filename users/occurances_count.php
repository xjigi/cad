<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
date_default_timezone_set('Africa/Accra');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


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
		<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=yes,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

</script>
</head>
<body>
<?php include('include/header.php');?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
		
			<div class="span12">
					<div class="content">

	<div class="module">
    <p><a  href="add_contracts.php" class="btn btn-primary btn-medium">Add New Contract</a></>
							
							<div class="module-body table">
	<?php if(isset($_GET['del']))
{?>
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Oh snap!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
									</div>
<?php } ?>

									<br />

							
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											<th>Reference #</th>
											<th>Organisation</th>
											<th>Audit Firm</th>
											<th>Audit Period</th>
											<th>Report Status</th>
                                            <th>Occurance</th>
                                            <th>Remarks</th>
                                            <th>Appraisal</th>                                            
											<th>Action</th>
										
										</tr>
									</thead>
									<tbody>
<!--Calculate Count for same Audit firm & Organization-->

<?php 
	
	// $audit_period = $_GET['audit_period'];
	// $audit_firm = str_replace('+', ' ',$_GET['audit_firm']);
	// $organisation = str_replace('+', ' ',$_GET['organisation']);

	if (isset($_GET['occurance'])) {
		$results = mysqli_query($con,'SELECT MAX(contract_id), reference_number, audit_period, organisation, audit_firm, report_status, remarks, appraisal FROM contracts GROUP by contract_id');	
	
		$list = [];
		//Process Result
		while( $i = mysqli_fetch_array($results)){
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

		$list = array_filter($list, function ($item) use($keys) {
			$maxOccurance = $keys[str_replace(' ', '', $item['organisation'] . $item['audit_firm'])];
			return $item['occurance'] === (int)$_GET['occurance'];
		});
	}

	// <!--End Calculate Count for same Audit firm & Organization-->
	// $occCount = $list['occurance'];

	// if (isset($_GET['occurance'])) {
	// 	$z = 0;
	// 	for($i = 0; $i <= $_GET['occurance']; $i++) {
	// 		while( $i['occurance'][$i]-- > 0 ) {
	// 		  $list[$z++] = $i;
	// 		}
	// 	  }
	// 	  return $list;
	// }
	// var_dump ($list);
	foreach ($list as $row) {


?>									
							<tr>
								 <td ><?php echo htmlentities($row['reference_number']);?></td>
                                 <td ><?php echo htmlentities($row['organisation']);?></td>
                                 <td ><?php echo htmlentities($row['audit_firm']);?></td>
                                 <td ><?php echo htmlentities($row['audit_period']);?></td>
                                 <td ><?php echo htmlentities($row['report_status']);?></td>
                                 <td style="text-align:center;"><?php echo $row['occurance']?></td>
                                 <td ><?php echo htmlentities($row['remarks']);?></td>
                                 <td ><?php echo htmlentities($row['appraisal']);?></td>
                                 
                                 <td><a href="edit-contract.php?contract_id=<?php echo $row['contract_id']?>" ><class="btn btn-primary btn-large">Edit </a> | <a href="delete.php?contract_id=<?php echo $row['contract_id']?>" ><class="btn btn-primary btn-large">Delete </a></td>
										<?php  } ?>
										
								</table>
                               
							</div>
                            <p><a  href="occurances.php" class="btn btn-primary btn-medium">View Occurances</a></>
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