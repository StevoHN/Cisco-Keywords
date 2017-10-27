<div id="navbar">
	
	<?php
	
	if($_SERVER['PHP_SELF'] != "/index.php")
	{
		// If not the front page, add a button to return to it
		echo '<a href="index"><div id="homeButton" class="floatLeft"><b>&#x1f3e0</b></div></a>';
	}
	
	if($_SERVER['PHP_SELF'] != "/login_.php")
	{
		include 'buttons/logout_button.php';
	}
	
	?>
</div>