<?php
session_start();
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Cisco Keywords</title>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
	<?php include 'buttons/navbar.php'; ?>
		<div id="wrapper">
        <div id="index_cisco">
            
            <h1 id="cisco_title">Cisco Keywords</h1>
            <form id="searchForm" action="search.php" method="get">
                <input id="keyword_search" name="cisco_search" type="text" placeholder="..." autofocus/>
                <input id="keyword_submit" type="submit" value="Go"/>
            </form>
        </div>
		</div>
    </body>

</html>