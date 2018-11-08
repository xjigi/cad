<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:index.php');
}
else{

 ?>
<script language="javascript" type="text/javascript">
function f2()
{
window.close();
}ser
function f3()
{
window.print(); 
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Applicant Profile</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="anuj.css" rel="stylesheet" type="text/css">
</head>
<body>

<div style="margin-left:50px;">
 <form name="updateticket" id="updateticket" method="post"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php 

$ret1=mysqli_query($con,"select * FROM applicant_details where userid='".$_GET['uid']."'");
while($row=mysqli_fetch_array($ret1))
{
?>

    
  
		
    <tr>
      <td colspan="2"><b><?php echo $row['fullname'];?>'s detailed profile</b></td>
      
    </tr>
    
    
    <tr>
      <td  >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr height="50">
      <td><b>Contact Number:</b></td>
      <td><?php echo htmlentities($row['cnumber']); ?></td>
    </tr>
    <tr height="50">
      <td><b>Mobile Number:</b></td>
      <td><?php echo htmlentities($row['mnumber']); ?></td>
    </tr>


      <tr height="50">
      <td><b>Email:</b></td>
      <td><?php echo htmlentities($row['email']); ?></td>
    </tr>
    


        <tr height="50">
      <td><b>Gender:</b></td>
      <td><?php echo htmlentities($row['gender']); ?></td>
    </tr>



        <tr height="50">
      <td><b>Age:</b></td>
      <td><?php echo htmlentities($row['age']); ?></td>
    </tr>


        <tr height="50">
      <td><b>Position:</b></td>
      <td><?php echo htmlentities($row['position']); ?></td>
    </tr>


        <tr height="50">
      <td><b>First Choice Region:</b></td>
      <td><?php echo htmlentities($row['region1']); ?></td>
    </tr>  
    
    
    <tr height="50">
      <td><b>Second Choice Region:</b></td>
      <td><?php echo htmlentities($row['region2']); ?></td>
    </tr>  


        <tr height="50">
      <td><b>First Degree:</b></td>
      
      
      <tr>
											
											<td><b>Degree Name/Type</b></td>
											<td><b>Status</b></td>
											<td><b>Year of Completeion</b></td>
											
										</tr>
      <td><?php echo htmlentities($row['fdegree']); ?></td>
      <td><?php echo htmlentities($row['fdegree_status']); ?></td>
      <td><?php echo htmlentities($row['fdegree_year']); ?></td>
    </tr>
    
    <tr height="50">
      <td><b>Second Degree:</b></td>
      <tr>
											
											<td><b>Degree Name/Type</b></td>
											<td><b>Status</b></td>
											<td><b>Year of Completeion</b></td>
											
										</tr>
      <td><?php echo htmlentities($row['sdegree']); ?></td>
      <td><?php echo htmlentities($row['sdegree_status']); ?></td>
      <td><?php echo htmlentities($row['sdegree_year']); ?></td>
    </tr>
    
    <tr height="50">
      <td><b>Professonal:</b></td>
      <tr>
											
											<td><b>Certification</b></td>
											<td><b>Level</b></td>
											<td><b>Status</b></td>
                                            <td><b>Year of Completion</b></td>
											
										</tr>
      <td><?php echo htmlentities($row['profdegree']); ?></td>
      <td><?php echo htmlentities($row['profdegree_level']); ?></td>
      <td><?php echo htmlentities($row['profdegree_status']); ?></td>
      <td><?php echo htmlentities($row['profdegree_year']); ?></td>
    </tr>
    
    <tr height="50">
      <td><b>Other Qualification:</b></td>
      <td><?php echo htmlentities($row['other_qualifications']); ?></td>      
    </tr>
    
    <tr height="50">
      <td><b>National Service:</b></td>
      <tr>
											
											<td><b>Place of Service</b></td>											
											<td><b>Status</b></td>
                                            <td><b>Year of Completion</b></td>
											
										</tr>
      <td><?php echo htmlentities($row['nss']); ?></td>
      <td><?php echo htmlentities($row['nss_status']); ?></td>
      <td><?php echo htmlentities($row['nss_year']); ?></td>
    </tr>
    
    

    <?php 

$ret1=mysqli_query($con,"select * FROM working_exp where userid='".$_GET['uid']."'");
while($row=mysqli_fetch_array($ret1))
{
?>
    <tr height="50">
    
      <td><b>Working Experience:</b></td>
      
      
      <tr>
											
											<td><b>Organisation Name</b></td>
											<td><b>Position</b></td>
											<td><b>Period</b></td>
											<td><b>Total No. of Years</b></td>
											
										</tr>
                               
      <tr>
      <td><?php echo htmlentities($row['org_name']); ?></td>
      <td><?php echo htmlentities($row['org_position']); ?></td>
      <td><?php echo htmlentities($row['org_period']); ?></td>
      <td><?php echo htmlentities($row['org_total']); ?></td>
    </tr>
    </tr>
<?php } ?> 




<div>  
 <tr height="50">
      <td><b>Working Experience:</b></td>   
<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">

<thead>
<tr align=left>
											
											<th><b>Organisation Name</b></th>
											<th><b>Position</b></th>											
											<th><b>Period</b></th>
                                            <th><b>Total No. of Years</b></th>
											
										</tr>
</thead>
<tbody>    
 <?php 

$ret1=mysqli_query($con,"select * FROM working_exp where userid='".$_GET['uid']."'");
while($row=mysqli_fetch_array($ret1))
{
?>     
      
      
      
                               
      <tr>
      <td><?php echo htmlentities($row['org_name']); ?></td>
      <td><?php echo htmlentities($row['org_position']); ?></td>
      <td><?php echo htmlentities($row['org_period']); ?></td>
      <td><?php echo htmlentities($row['org_period']); ?></td>
    </tr>
    

    
<?php } ?> 

</tbody>
</table>
</div>




<div>  
 <tr height="50">
      <td><b>Post Qualification Experience:</b></td>   
<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">

<thead>
<tr align=left>
											
											<th><b>Organisation Name</b></th>
											<th><b>Subject Area</b></th>											
											<th><b>Total No. of Years</b></th>
											
										</tr>
</thead>
<tbody>    
 <?php 

$ret1=mysqli_query($con,"select * FROM post_qual where userid='".$_GET['uid']."'");
while($row=mysqli_fetch_array($ret1))
{
?>     
      
      
      
                               
      <tr>
      <td><?php echo htmlentities($row['org_name']); ?></td>
      <td><?php echo htmlentities($row['subject']); ?></td>
      <td><?php echo htmlentities($row['num_years']); ?></td>
      
    </tr>
    

    
<?php } ?> 

</tbody>
</table>
</div>



<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">

<?php 

$ret1=mysqli_query($con,"select * FROM cv_files where userid='".$_GET['uid']."'");
while($row=mysqli_fetch_array($ret1))
{
?>
<tr height="50">  

  <tr>
											<td><b>Applicant's Documents</b></td>
											
											<td colspan="5"> <?php $cfile=$row['cv_name'];
if($cfile=="" || $cfile=="NULL")
{
  echo "File NA";
}
else{?>
<a href="../users/cv/<?php echo htmlentities($row['cv_name']);?>" target="_blank"/> Click to view CV</a>
<?php } ?></td>
</tr>
</tr>

<?php } ?> 

</table>
    
    <tr>
  
      <td colspan="2">   
      <input name="Submit2" type="submit" class="txtbox4" value="Close this window " onClick="return f2();" style="cursor: pointer;"  /></td>
    </tr>
   
    <?php } 

 
    ?>
 

 </form>
</div>

</body>
</html>

     <?php } ?>