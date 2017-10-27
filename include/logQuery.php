<?php

$queryFile = "sql_logs/query_log.txt";
$queryLog = fopen($queryFile, "a+") or die ("Cannot open query log");
$read_queryLog = fread($queryLog,filesize($queryFile));
ftruncate($queryLog,0);
$log_entry = "CLIENT: $client_ip | Query: #$query# | Time: $date" . PHP_EOL . $read_queryLog;
fwrite($queryLog,$log_entry);
fclose($queryLog);

?>