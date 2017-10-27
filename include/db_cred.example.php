<?php
if($_SERVER['PHP_SELF'] != "/include/db_cred.php")
{
	$db_cred = array(
		'host' => 'mysqlserver.example',
		'database' => 'exampleDB',
		'username' => 'exampleUser',
		'password' => 'examplePassword',
        
        
        'c_username' => 'exampleUser',
        'c_password' => 'examplePassword'
	);
}
else
{
	header('location:../index');
}
?>