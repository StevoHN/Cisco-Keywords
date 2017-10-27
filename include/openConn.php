<?php

$conn = new PDO("mysql:host=$db_cred[host];dbname=$db_cred[database]",$db_cred[username],$db_cred[password]);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$connStatus = $conn->getAttribute(PDO::ATTR_CONNECTION_STATUS);
//$connInfo = $conn->getAttribute(PDO::ATTR_SERVER_INFO);

?>