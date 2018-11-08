<?php 
require_once("include/config.php");
if(!empty($_POST["submit"])) {
	$organisation= $_POST["organisation"];
    $audit_firm= $_POST["audit_firm"];
	
		$result =mysqli_query($con,"SELECT organisation, audit_firm FROM contracts WHERE organisation='$organisation' and audit_firm='$audit_firm'");
		$count=mysqli_num_rows($result);
if($count>0)
    {
    echo "<span style='color:red'> Email already exists .</span>";
     echo "<script>$('#submit').prop('disabled',true);</script>";
    } else{
        
        echo "<span style='color:green'> Email available for Registration .</span>";
     echo "<script>$('#submit').prop('disabled',false);</script>";
    }
}


?>
