<?php
//include database configuration file
include 'include/config.php';

//get records from database
$query=mysqli_query($con,"select applicant_details.*,post_qual.* from applicant_details left join post_qual on applicant_details.userid=post_qual.userid");

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "applicants_" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('Full Name', 'Contact Number', 'Mobile', 'Email', 'Gender', 'Age', 'Position', '1st Region', '2nd Region', '1st Degree', 'Status', 'Year','2nd Degree', 'Status', 'Year', 'Prof Cert', 'Level', 'Status','Year', 'Other Certs', 'NSS', 'Status', 'Year', 'org_name', 'subject', 'num_years' );
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        
        $lineData = array($row['fullname'], $row['cnumber'], $row['mnumber'], $row['email'], $row['gender'], $row['age'],$row['position'], $row['region1'], $row['region2'], $row['fdegree'],$row['fdegree_status'], $row['fdegree_year'],$row['sdegree'],$row['sdegree_status'], $row['sdegree_year'],$row['profdegree'],$row['profdegree_level'], $row['profdegree_status'],$row['profdegree_year'],$row['other_qualifications'],$row['nss'],$row['nss_status'], $row['nss_year'], $row['org_name'] ,$row['subject'],$row['num_years']);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;

?>