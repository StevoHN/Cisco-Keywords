<?php
session_start();
include 'include/db_cred.php';

include 'include/isAdmin.php';

// Get info about the event for logging purposes
$page = $_SERVER['PHP_SELF'];
$client_ip = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set('Europe/Copenhagen');
$date = date('d/m/Y - H:i:s');

// Establish conncetion to the MySQL server
try
{
	include 'include/openConn.php';
}
catch(PDOException $err)
{
    $block = "Establishing Connection";
    include 'include/logError.php';
}

// Add new entry to the keyword database
try
{
	$newEntry = array();
    $newEntry[0] = $_POST['newWord'];
    $newEntry[1] = nl2br($_POST['newExplanation']);
    $newEntry[2] $_POST['newTags'];
    
	// Removing special characters and replacing line breaks with <br> elements
    foreach($newEntry as $input)
    {
        $input = strip_tags($input);
        $input = str_replace("'","&#39;",$input);
        $input = str_replace('"','&#34;',$input);
        $input = nl2br($input);
    }
    
    $word = $newEntry[0];
    $explanation = $newEntry[1];
    $tags = $newEntry[2];
	
	// Query for insertion of the new keyword
    $query = "INSERT INTO Keywords (Word,Explanation,Tags) VALUES('$word','$explanation','$tags')";
	
	// Log the event
    include 'include/logQuery.php';
    
	// Prepare & run the query
    $runQ = $conn->prepare($query);
    $runQ->execute();
}
catch(PDOException $err)
{
    $block = "Inserting New Row";
    include 'include/logError.php';
}

header('location:edit_.php');

?>