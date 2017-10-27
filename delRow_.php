<?php
session_start();

include 'db_cred.php';

include 'include/isAdmin.php';

include 'include/logVars.php';

try
{
    include 'include/openConn.php';
}
catch(PDOException $err)
{
    $block = "Establishing Connection";
    include 'include/logError.php';
}

try
{
    $query = "DELETE FROM Keywords WHERE Word_ID = $_GET[id]";
    include 'include/logQuery.php';
    
    $runQ = $conn->prepare($query);
    $runQ->execute();
}
catch(PDOException $err)
{
    $block = "Deleting Row";
    include 'include/logQuery.php';
}

header('location:edit_.php');

?>