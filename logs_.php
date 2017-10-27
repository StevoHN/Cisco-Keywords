<?php
session_start();
include 'include/db_cred.php';

include 'include/isAdmin.php';

include 'include/logVars.php';

$showLog = $_GET['show'];
$showLog = str_replace("Log","Div",$showLog);
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Cisco Keywords</title>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <link rel="stylesheet" href="style/style.css">
        
        <script>
        function clearLog(log)
        {
            if (confirm("Are you sure you want to clear the log?") == true) {
                window.location = "http://www.thrysoe.net/clearLog_.php?log=" + log;
            }
        }
        </script>
    </head>
    <body>
		<?php include 'buttons/navbar.php'; ?>
		
		<div id="wrapper">
		
        <div id="logView">
        
            <!-- <button onclick="showLogView('statDiv')">Statistic</button>
            <button onclick="showLogView('searchDiv')">Search</button>
            <button onclick="showLogView('queryDiv')">Query</button>
            <button onclick="showLogView('errorDiv')">Error</button> -->
            <a href="logs_.php?show=statLog">Statistic</a>
            <a href="logs_.php?show=searchLog">Search</a>
            <a href="logs_.php?show=queryLog">Query</a>
            <a href="logs_.php?show=errorLog">Error</a>
            <div id="logDiv">
                <?php
                if($showLog == "statDiv" || $showLog == "")
                {
                    echo "<button onclick='clearLog(\"statLog\")'>Clear Log</button><br><br>";
                    echo '<div id="statDiv"><table><tr><td>Entry_ID</td><td>Word</td><td>Count</td></tr>';

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
                        $query = "SELECT * FROM statLog ORDER BY Count DESC";
                        include 'include/logQuery.php';
                        
                        $runQ = $conn->prepare($query);
                        $runQ->execute();

                        $r = $runQ->fetchAll();
                        $rows = $runQ->rowCount();

                        echo $query;
                        echo " - " . $rows . " entries";

                        for($i = 0;$i<$rows;$i++)
                        {
                            $id = $r[$i][0];
                            $word = $r[$i][1];
                            $count = $r[$i][2];

                            echo <<<SQL_STATISTICS
<tr>
<td>$id</td>
<td>$word</td>
<td>$count</td>
</tr>

SQL_STATISTICS;
                        }
                    }
                    catch(PDOException $err)
                    {
                        $block = "Fetching Statistics";
                        include 'include/logError.php';
                    }
                        
                    echo '</table></div>';
                }
                else if($showLog == "searchDiv")
                {
                    $s_file = "sql_logs/search_log.txt";
                    echo "<button onclick='clearLog(\"$s_file\")'>Clear Log</button><br><br>";
                    echo "<div id='searchDiv'>";
                    $s_log = fopen($s_file,r) or die("Cannot open search log");
                    $read_s_log = fread($s_log, filesize($s_file));
                    $read_s_log = nl2br($read_s_log);
                    echo $read_s_log;
                    echo "</div>";
                }
                else if($showLog == "queryDiv")
                {
                    $q_file = "sql_logs/query_log.txt";
                    echo "<button onclick='clearLog(\"$q_file\")'>Clear Log</button><br><br>";
                    echo '<div id="queryDiv">';
                    $q_log = fopen($q_file,r) or die("Cannot open query log");
                    $read_q_log = fread($q_log, filesize($q_file));
                    $read_q_log = nl2br($read_q_log);
                    echo $read_q_log;
                    echo '</div>';
                }
                else if($showLog == "errorDiv")
                {
                    $e_file = "sql_logs/error_log.txt";
                    echo "<button onclick='clearLog(\"$e_file\")'>Clear Log</button><br><br>";
                    echo '<div id="errorDiv">';
                    $e_log = fopen($e_file,r) or die("Cannot open error log");
                    $read_e_log = fread($e_log, filesize($e_file));
                    $read_e_log = nl2br($read_e_log);
                    echo $read_e_log;
                    echo '</div>';
                    fclose($e_log);
                }
                
                ?>
            </div>
        </div>
		</div>
    </body>
</html>