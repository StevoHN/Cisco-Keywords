<?php
session_start();

include 'include/isAdmin.php';

include 'include/db_cred.php';

include 'include/logVars.php';
$date = date('dmY_H-i-s');

if($_GET['log'] == "statLog")
{  
    try 
    {
        include 'include/openConn.php';
        //echo "Connection Established...";
    }
    catch(PDOException $err)
    {
        $block = "Establishing Connection";
        include 'include/logError.php';
    }
                    
    try
    {
        $query = "SELECT * FROM statLog ORDER BY Count DESC";
        include 'include/logQuery.php';
        
        $runQ = $conn->prepare($query);
        $runQ->execute();

        $r = $runQ->fetchAll();
        $rows = $runQ->rowCount();
        $resultTable = "<table><tr><td>Entry_ID</td><td>Word</td><td>Count</td></tr>";
        for($i = 0;$i<$rows;$i++)
        {
            $id = $r[$i][0];
            $word = $r[$i][1];
            $count = $r[$i][2];
            
            $resultTable = $resultTable . "<tr><td>$id</td><td>$word</td><td>$count</td></tr>";
        }
        $resultTable = $resultTable . "</table>";
        
        $exportF = fopen("sql_logs/old_logs/stat_logs/stat_log_$date.html","x+") or die ("Cannot create/open stat log");
        fwrite($exportF,$resultTable);
        fclose($exportF);
    }
    catch(PDOException $err)
    {
        $block = "Fetching Statistics";
        include 'include/logError.php';
    }
    
    try
    {
        $query = "Truncate TABLE statLog";
        include 'include/logQuery.php';
        $runQ = $conn->exec($query);
    }
    catch(PDOException $err)
    {
        $block = "Truncating Table";
        include 'include/logError.php';
    }
    header('location:logs_.php?show=statLog');
}

$file = $_GET['log'];

$log = fopen($file,"a+") or die("Cannot open log");
$read_log = fread($log, filesize($file));

ftruncate($log,0);
$dir = str_replace(".txt","s",$file);
$dir = str_replace("/","/old_logs/",$dir);
if(!file_exists($dir))
{
    //echo "Directory doesn't exist";
    mkdir($dir) or die("$dir <br><a href='logs_.php'>Go back</a>");
}
else if(file_exists($dir))
{
    //echo "Directory exists";
}
$newFile = str_replace(".txt","_$date.txt",$file);
$newFile = str_replace("sql_logs","",$newFile);
$newFile = $dir . $newFile;
$backup_log = fopen($newFile,"w+") or die("File: " . $newFile . "<br>Cannot create new log - <a href='logs_.php'>Go back</a>");
fwrite($backup_log,$read_log);


fclose($log);
fclose($backup_log);


$file = str_replace("sql_logs/","",$file);
$redirectToLog = str_replace("_log.txt","Log",$file);


header('location:logs_.php?show=' . $redirectToLog . '&file=' . $newFile);

?>