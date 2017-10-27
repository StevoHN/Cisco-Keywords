<?php
session_start();
include 'include/db_cred.php';

include 'include/isAdmin.php';

include 'include/logVars.php';
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Cisco Keywords</title>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <link rel="stylesheet" href="style/style.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script>
            function editDB(value, field, id)
            {
                var editWindow = "" +
                    "<div id='editDbWindow'>" +
                        "<form method='post' action='pushUpdate_.php' id='editDbForm'>" +
                            "<textarea name='input'>" + value + "</textarea>" +
                            "<button onclick=" + '"' + "$('#editDbWindow').remove()" + '"' + ">Cancel</button>" +
                            "<input type='text' value='" + field + "' name='field' hidden/>" +
                            "<input type='text' value='" + id + "' name='id' hidden/>" +
                            "<input type='submit'/>" +
                        "</form>" +
                    "</div>";
                $('body').append(editWindow);
            };
            function addEntry()
            {
                var addWindow = ""+
                    "<div id='addEntryWindow'>" +
                        "<form method='post' action='addEntry_.php' id='addEntryForm'>" +
                            "<label for='addNewWord'>Word:</label><input type='text' name='newWord' id='addNewWord'/><br><br>" +
                            "<label for='addNewExplanation'>Explanation:</label><textarea name='newExplanation' id='addNewExplanation' rows='8'/></textarea><br><br>" +
                            "<label for='addNewTags'>Tags: (Seperate with comma)</label><input type='text' name='newTags' id='addNewTags'/><br><br>" +
                            "<button onclick=" + '"' + "$('#addEntryWindow').remove()" + '"' + ">Cancel</button>" +
                            "<input type='submit' value='Submit'/>" +
                        "</form>" +
                    "</div>";
                
                $('body').append(addWindow);
            };
            function delRow(id)
            {
                if (confirm("Are you sure you want delete this entry?") == true) {
                    window.location = "http://www.thrysoe.net/delRow_.php?id=" + id;
                }
            }
        
        </script>
    </head>

    <body>

		<?php include 'buttons/navbar.php';?>
		
		<div id="wrapper">
		
        <div id="word_database">
            <button onclick="addEntry();">New Entry</button>
            <table>
                <!--<tr>
                    <td>Id</td>
                    <form>
                        <td><input type="text" name="word"/></td>
                        <td><input type="text" name="explanation"/></td>
                        <td><input type="text" name="tags"/></td>
                        <td><input type="text" name="topic"/></td>
                        <td><input type="text" name="hits"/></td>
                    </form>
                </tr>-->
                <?php
                    try 
                    {
                        include 'include/openConn.php';
                    }
                    catch(PDOException $err) {
                        $block = "Establishing Connection";
                        include 'include/logError.php';
                    }
                
                    //echo $query;
                    try
                    {   
                        $query = "SELECT * FROM Keywords ORDER BY Word_ID";
                        include 'include/logQuery.php';
                        
                        $runQ = $conn->prepare($query);
                        $runQ->execute();
                        
                        $r = $runQ->fetchAll();
                        $rows = $runQ->rowCount();
                        $columns = $runQ->columnCount();
                        echo "<tr>";
                        for($j = 0;$j<$columns;$j++)
                        {
                            $field = $runQ->getColumnMeta($j);
                            echo "<td>" . $field['name'] . "</td>";
                        }
                        echo "</tr>";
                        echo "<br>" . $rows . " results.<br><br>";
                        
                        for($i = 0;$i<$rows;$i++)
                        {
                            $id = $r[$i][0];
                            $word = $r[$i][1];
                            $explanation = $r[$i][2];
                            $explanationS = $explanation;
                            $tags = $r[$i][3];
                            $tagsS = $tags;
                            
                            if(strlen($explanationS) > 100)
                            {
                                $explanationS = substr($explanationS,0,100) . '...';
                                $explanationS = strip_tags($explanationS);
                            };
                            if(strlen($tags) > 30)
                            {
                                $tagsS = substr($tagsS,0,30) . '...';
                                $tagsS = strip_tags($tagsS);
                            };
                            $x = $id;
                            echo <<<SEARCHRESULT

<tr>
    <td>$id</td>
    <td id="word_$x" onclick="editDB(document.getElementById('word_$x').innerHTML,'Word',$x)">$word</td>
    <td id="explanation_$x" onclick="editDB(document.getElementById('explanation_$x').title,'Explanation',$x)" title="$explanation">$explanationS</td>
    <td id="tags_$x" onclick="editDB(document.getElementById('tags_$x').title,'Tags',$x)" title="$tags">$tagsS</td>
    <td>
        <button onclick='delRow($x)'>X</button>
    </td>
</tr>

SEARCHRESULT;
                        }
                    }
                    catch(PDOException $err)
                    {
                        $block = "Fetching Database";
                        include 'include/logError.php';
                    }
                ?>
            </table>
        </div>
		</div>
    </body>

</html>