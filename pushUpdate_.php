<?php
session_start();
include 'include/db_cred.php';

include 'include/isAdmin.php';

include 'include/logVars';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    try 
    {
        include 'include/openConn.php';
    }
    catch(PDOException $err) {
        $block = "Establishing Connection";
        include 'include/logError.php';
    }
    
    $id = $_POST['id'];
    $field = $_POST['field'];
    
    $input = $_POST['input'];
    $input = strip_tags($input);
    $input = nl2br($input, false);
    $input = str_replace("'","&#39;",$input);
    $input = str_replace('"','&#34;',$input);
    
    try
    {
        $query = "UPDATE Keywords SET $field = '$input' WHERE Word_ID = $id";
        include 'include/logQuery.php';
        
        $runQ = $conn->prepare($query);
        $runQ->execute();
    }
    catch(PDOException $err)
    {
        $block = "Pushing Update";
        include 'include/logError.php';
    }
}

header('location:edit_.php');

?>