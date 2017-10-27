<?php
session_start();
include 'include/db_cred.php';

include 'include/logVars.php';
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
			<div id="cisco_results">
				<h1 id="cisco_title"><a href="index.php" style="color:cornflowerblue">←</a> Results</h1>
				<form id="searchForm" action="search.php" method="get">
					<input id="keyword_search" name="cisco_search" type="text" placeholder="..." autofocus/>
					<input id="keyword_submit" type="submit" value="Go"/>
				</form>
				<br>
				<div id="results_div">
				<?php   
				try 
				{
					include 'include/openConn.php';
				}
				catch(PDOException $err)
				{
					$block = "Establishing Connection";
					include 'include/logError.php';
				}

				$searchfor = $_GET['cisco_search'];
				$searchfor = strip_tags($searchfor);
				echo "Searching for: $searchfor";

				$searchFile = "sql_logs/search_log.txt";
				$searchLog = fopen($searchFile, "a+") or die ("Cannot open search log");
				$read_searchLog = fread($searchLog,filesize($searchFile));
				ftruncate($searchLog,0);

				$log_entry = "CLIENT: $client_ip | Searched for: #$searchfor# | Time: $date" . PHP_EOL . $read_searchLog;
				fwrite($searchLog,$log_entry);
				fclose($searchLog);

				try
				{
					$query = "SELECT Count FROM statLog WHERE Word = '$searchfor'";
					include 'include/logQuery.php';

					$runQ = $conn->prepare($query);
					$runQ->execute();
					$r = $runQ->fetchAll();
					$rows = $runQ->rowCount();

					$wordCount = $r[0][0];
					if($rows >= 1)
					{
						$query = "UPDATE statLog SET Count = " . ($wordCount + 1) . " WHERE Word = '$searchfor'";
						include 'include/logQuery.php';

						$runQ = $conn->prepare($query);
						$runQ->execute();
					}
					else
					{
						$query = "INSERT INTO statLog(Word, Count) VALUES('$searchfor',1)";
						include 'include/logQuery.php';

						$runQ = $conn->prepare($query);
						$runQ->execute();
					}
				}
				catch(PDOException $err)
				{
					$block = "Updating Word Hitcount";
					include 'include/logError.php';
				}

				try
				{
					$query = "SELECT Word,Explanation,Tags FROM Keywords WHERE Word LIKE '%$searchfor%' OR 
					Explanation LIKE '%$searchfor%' OR Tags LIKE '%$searchfor%' ORDER BY CASE WHEN Word LIKE 
					'$searchfor%' THEN 1 WHEN Word LIKE '%$searchfor%' THEN 2 WHEN Word LIKE '%$searchfor' THEN 3 ELSE 4 END, Word";
					include 'include/logQuery.php';

					$runQ = $conn->prepare($query);
					$runQ->execute();

					$r = $runQ->fetchAll();
					$rows = $runQ->rowCount();

					if($rows>1)
					{
						$dbResults = "<br>" . $rows . " results<br><br>";
					}
					else if($rows==1)
					{
						$dbResults = "<br>" . $rows . " result<br><br>";
					}
					else if($rows==0)
					{
						$dbResults = "<br>No results<br><br>";
					}
					else
					{
						$dbResults = "An error occurred";
					}

					echo $dbResults;

					for($i = 0;$i<$rows;$i++)
					{
						$word = $r[$i][0];
						$explanation = $r[$i][1];
						$tags = $r[$i][2];
						$topic = $r[$i][3];

						$tags = explode(",",$tags);
						$tagLink = "<a href='http://www.thrysoe.net/search?cisco_search=$tags[0]'>$tags[0]</a>";
						$tagLinkString = $tagLink;
						for($j = 1;$j<count($tags);$j++)
						{
							$tagLinkString = $tagLinkString . ", <a href='http://www.thrysoe.net/search?cisco_search=$tags[$j]'>$tags[$j]</a>";
						}

						echo <<<SEARCHRESULT
<div class="result_box">
<h2>$word</h2>
<p>$explanation</p>
<p>Tags: $tagLinkString</p>
</div>
SEARCHRESULT;
					}
				}
				catch(PDOException $err)
				{
					$block = "Fetching Keywords";
					include 'include/logError.php';
				}
				?>
				</div>
			</div>
		</div>
    </body>

</html>