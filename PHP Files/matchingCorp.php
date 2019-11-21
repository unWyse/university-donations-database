<?PHP
/* Mathing Corporation Table
Nick Smith & Kyle Wyse
12/5/2018
http://jcsites.juniata.edu/students/smithnm16/matchingCorp.php
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
echo "<h1>Matching Corporation</h1>";
// login to database
$link = pg_connect("host=itcsdbms user=rhodes password=guest dbname=univdonations")
  or die ("Could not connect to database");

// shows data entries if user enters report button
if($_GET['report'])
{
$query = "SELECT * FROM matching_Corp ";
$result = pg_query ($query)
    or die ("Query failed");

// printing HTML result
print "<table border=1>\n";
print "<td>Corporation Name</td><td>Address</td> <td>Percent Match</td> <td>Match Limit</td> <td>ZIP</td>\n";
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
  $corpName = $_GET['corpName'];
  $address = $_GET['address'];
  $percentMatch = $_GET['percentMatch'];
  $percentLim = $_GET['percentLim'];
  $zip = $_GET['zip'];
  $query = "INSERT INTO matching_corp (corpName, address, percentMatch, percentLim, zip) VALUES('$corpName', '$address', '$percentMatch', '$percentLim', $zip)";
  pg_query ($query);
}

if($_GET['edit'])
{
  $corpName = $_GET['corpName'];
  //$percentMatch = $_GET['percentMatch'];
  $query = "SELECT corpName, address, percentMatch, percentLim, zip FROM matching_corp WHERE corpName='$corpName'";
  $result = pg_query($query);
  $editData = pg_fetch_array($result);

  $corpName = $editData[0];
  $address = $editData[1];
  $percentMatch = $editData[2];
  $percentLim = $editData[3];
  $zip = $editData[4];


  //echo "$corpName";

  echo "<form action=\"http://jcsites.juniata.edu/students/smithnm16/database/matchingCorp.php\" method=\"get\" >
    <div>
      <div>
        <label for=\"corpName\">Corporation Name:</label>
        <input type=\"text\" name=\"corpName\" value='$corpName' required/>
      </div>

      <div>
        <label for=\"address\">Address:</label>
        <input type=\"text\" name=\"address\" value='$address' required/>
      </div>

      <div>
        <label for=\"percentMatch\">Percent Match:</label>
        <input type=\"text\" name=\"percentMatch\" value='$percentMatch' />
      </div>

      <div>
        <label for=\"percentLim\">Match Limit:</label>
        <input type=\"text\" name=\"percentLim\" value='$percentLim' />
      </div>

      <div>
        <label for=\"zip\">ZIP:</label>
        <input type=\"text\" name=\"zip\" value='$zip' />
      </div>

      <div>
        <input type=\"submit\" name=\"save\" value=\"Save\" />
        <input type=\"submit\" name=\"cancel\" value=\"Cancel\" />
  </form>";
}

if($_GET['save'])
{
  $corpName = $_GET['corpName'];
  $address = $_GET['address'];
  $percentMatch = $_GET['percentMatch'];
  $percentLim = $_GET['percentLim'];
  $zip = $_GET['zip'];

  $query = "UPDATE matching_corp SET corpName='$corpName', address='$address', percentMatch='$percentMatch', percentLim='$percentLim', zip=$zip  WHERE corpName='$corpName'";
  pg_query($query);
}

if($_GET['cancel'])
{
  header("location: http://jcsites.juniata.edu/students/smithnm16/database/matchingCorp.php");
}

// deletes entries from the database by corpName
if($_GET['delete'])
{
$corpName=$_GET['corpName'];
$query = "DELETE FROM matching_corp WHERE corpName='$corpName'";
pg_query ($query);
}

pg_close($link);
?>
<html>
  <head>
      <title>Matching Corporation</title>
  </head>
  <body>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/matchingCorp.php" method="get" >
      <div>
        <div>
          <label for="corpName">corpName:</label>
          <input type="text" name="corpName" required/>
        </div>

        <div>
          <label for="address">address:</label>
          <input type="text" name="address" required/>
        </div>

        <div>
          <label for="percentMatch">Percent Match:</label>
          <input type="text" name="percentMatch" />
        </div>

        <div>
          <label for="percentLim">Match Limit:</label>
          <input type="text" name="percentLim" />
        </div>

        <div>
          <label for="zip">ZIP:</label>
          <input type="text" name="zip" />
        </div>

        <div>
          <input type="submit" name="add" value="Add" />
      </div>
    </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/matchingCorp.php" method="get">
      <div>
      <input type="submit" name="report" value="Report"/>
    </div>
  </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/matchingCorp.php" method="get">
      <div>
        <label for="corpName">Corporation Name</label>
        <input type="text" name="corpName" required/>
        <input type="submit" name="edit" value="Edit" />
        <input type="submit" name="delete" value="Delete" />
      </div>
    </form>
  </body>
</html>
