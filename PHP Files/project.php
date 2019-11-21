<?PHP
/* Project Table
Nick Smith & Kyle Wyse
12/5/2018
http://jcsites.juniata.edu/students/smithnm16/projName.php
*/
echo "<span>
  <a href=\"http://jcsites.juniata.edu/students/smithnm16/database/csz\">CSZ</a>
  <a href=\"http://jcsites.juniata.edu/students/smithnm16/database/matchingCorp\">Corporation</a>
  <a href=\"http://jcsites.juniata.edu/students/smithnm16/database/project\">Project</a>
  <a href=\"http://jcsites.juniata.edu/students/smithnm16/database/person\">Person</a>
  <a href=\"http://jcsites.juniata.edu/students/smithnm16/database/pledge\">Pledge</a>
  <a href=\"http://jcsites.juniata.edu/students/smithnm16/database/donation\">Donation</a>
</span>
<div>
  <p>The order of the links, is the order for the data to be entered.</p>
</div>";
echo "<h1>Project</h1>";
// login to database
$link = pg_connect("host=itcsdbms user=rhodes password=guest dbname=univdonations")
  or die ("Could not connect to database");

// shows data entries if user enters report button
if($_GET['report'])
{
$query = "SELECT * FROM project ";
$result = pg_query ($query)
    or die ("Query failed");

// printing HTML result
print "<table border=1>\n";
print "<td>Project Name</td><td>Start Date</td> <td>Budget</td>\n";
while($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
print "\t<tr>\n";
while(list($col_name, $col_value) = each($line)){
  print "\t\t<td>$col_value</td>\n";
}
print "\t</tr>\n";
}
print "</table>\n";
}

// adds data to the database
if($_GET['add'])
{
  $projName = $_GET['projName'];
  $startDate = $_GET['startDate'];
  $budget = $_GET['budget'];
  $query = "INSERT INTO project (projName, startDate, budget) VALUES('$projName', '$startDate', '$budget')";
  pg_query ($query);
}

if($_GET['edit'])
{
  $projName = $_GET['projName'];
  $query = "SELECT projName, startDate, budget FROM project WHERE projName='$projName'";
  $result = pg_query($query);
  $editData = pg_fetch_array($result);

  $projName = $editData[0];
  $startDate = $editData[1];
  $budget = $editData[2];

  echo "<form action=\"http://jcsites.juniata.edu/students/smithnm16/database/project.php\" method=\"get\" >
    <div>
      <div>
        <label for=\"projName\">Project Name:</label>
        <input type=\"text\" name=\"projName\" value='$projName' required/>
      </div>

      <div>
        <label for=\"startDate\">startDate:</label>
        <input type=\"date\" name=\"startDate\" value='$startDate' required/>
      </div>

      <div>
        <label for=\"budget\">Budget:</label>
        <input type=\"text\" name=\"budget\" value='$budget' required/>
      </div>

      <div>
        <input type=\"submit\" name=\"save\" value=\"Save\" />
        <input type=\"submit\" name=\"cancel\" value=\"Cancel\" />
  </form>";
}

if($_GET['save'])
{
  $projName = $_GET['projName'];
  $startDate = $_GET['startDate'];
  $budget = $_GET['budget'];
echo "$projName";
  $query = "UPDATE project SET projName='$projName', startDate='$startDate', budget=$budget WHERE projName='$projName'";
  pg_query($query);
}

if($_GET['cancel'])
{
  header("location: http://jcsites.juniata.edu/students/smithnm16/database/project.php");
}

// deletes entries from the database, ordered to delete by projName
if($_GET['delete'])
{
$projName=$_GET['projName'];
$query = "DELETE FROM project WHERE projName='$projName'";
pg_query ($query);
}

pg_close($link);
?>
<html>
  <head>
      <title>Project</title>
  </head>
  <body>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/project.php" method="get" >
      <div>
        <div>
          <label for="projName">Project Name:</label>
          <input type="text" name="projName" required/>
        </div>
        <div>
          <label for="startDate">Start Date:</label>
          <input type="date" name="startDate" required/>
        </div>
        <div>
          <label for="budget">Budget:</label>
          <input type="text" name="budget" required/>
        </div>

        <div>
          <input type="submit" name="add" value="Add" />
      </div>
    </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/project.php" method="get">
      <div>
      <input type="submit" name="report" value="Report"/>
    </div>
  </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/project.php" method="get">
      <div>
        <label for="projName">Corporation Name</label>
        <input type="text" name="projName" required/>
        <input type="submit" name="edit" value="Edit" />
        <input type="submit" name="delete" value="Delete" />
      </div>
    </form>
  </body>
</html>
