<?php

$errorFile = "sql_logs/error_log.txt";
$errorLog = fopen($errorFile, "a+") or die ("Cannot open error log");
$read_errorLog = fread($erroLog,filesize($errorFile));
ftruncate($error_log,0);
$log_entry = "CLIENT: $client_ip | Page: $page | Time: $date | Block: $block <br>Error: <br>$err<br>_End_<br>" . PHP_EOL . $read_errorLog;
fwrite($errorLog,$log_entry);
fclose($errorLog);
header('location:errors/error.php')

?>