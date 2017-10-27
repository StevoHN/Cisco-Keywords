<!--
	Logout button is rather misleading. This file is representing the panel which can be toggled in the upper right corner of the page.
-->
<div id="adminButton" class="floatRight">
	<script src="scripts/jquery.js"></script>
	<script type="text/javascript">

		var mVisible = false;
		function toggleMenu() {
			if(mVisible)
			{
				$("body").css("width","100%");
				$("#navbar").css("width","100%");
				$("#navMenu").css("marginRight","-25%");
				document.getElementById("navButton").innerHTML = "&#8801";
				mVisible = false;
				
				if(window.innerWidth < 1200)
				{
					$("#navMenu").css("marginRight","-100%");
				}
			}
			else if(!mVisible)
			{
				$("body").css("width","75%");
				$("#navbar").css("width","75%");
				$("#navMenu").css("marginRight","0%");
				document.getElementById("navButton").innerHTML = "&#x2716";
				mVisible = true;
				
				if(window.innerWidth < 1200)
				{
					$("body").css("width","100%");
					$("#navbar").css("width","100%");
				}
			}
		}
		
		var below1k = (window.innerWidth < 1200);
		$(window).resize(function(){
			
			if(window.innerWidth < 1200 && !below1k)
			{
				toggleMenu();
				toggleMenu();
				below1k = true;;
			}
			else if(window.innerWidth > 1200 && below1k)
			{
				toggleMenu();
				toggleMenu();
				below1k = false;
			}
		})
	</script>
	<div class="buttonDiv"><button id="navButton" onclick="toggleMenu();">&#8801</button></div>
	<div id="navMenu">

		<?php
		// Currently all useres have admin permissions, so if admin permissions for the current session is set, a user must be logged in.
		// If a user is logged in, insert a logout button among administrative tools. Otherwise insert a login button.
		if($_SESSION['admin_permissions'] == true)
		{
			echo
				'<a href="edit_"><div class="buttonDiv"><b>Edit</b></div></a>
				<a href="logs_"><div class="buttonDiv"><b>Logs</b></div></a>
				<a href="logout_"><div class="buttonDiv"><b>Logout</b></div></a>
				<a href="ideas_"><div class="buttonDiv"><b>Ideas</b></div></a>';
		}
		else
		{
			echo '<div class="buttonDiv"><b><a href="login_.php">Login</a></b></div>';
		}
		?>
	</div>
</div>