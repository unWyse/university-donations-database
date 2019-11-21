<?PHP
/* CSZ Table
Nick Smith & Kyle Wyse
12/5/2018
http://jcsites.juniata.edu/students/smithnm16/csz.php
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
echo "<h1>City, State, Zip</h1>";
// login to database
$link = pg_connect("host=itcsdbms user=rhodes password=guest dbname=univdonations")
  or die ("Could not connect to database");

// shows data entries if user enters report button
if($_GET['report'])
{
$query = "SELECT * FROM csz ";
$result = pg_query ($query)
    or die ("Query failed");

// printing HTML result
print "<table border=1>\n";
print "<td>ZIP</td> <td>State</td> <td>City</td>\n";
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
  $city = $_GET['city'];
  $state = $_GET['state'];
  $zip = $_GET['zip'];
  $query = "INSERT INTO csz (zip, state, city) VALUES($zip, '$state', '$city')";
  pg_query ($query);
}

if($_GET['edit'])
{
  $zip = $_GET['zip'];
  $query = "SELECT zip, state, city FROM csz WHERE zip='$zip'";
  $result = pg_query($query);
  $editData = pg_fetch_array($result);

  $zip = $editData[0];
  $state = $editData[1];
  $city = $editData[2];

  echo "$city";

  echo "<form action=\"http://jcsites.juniata.edu/students/smithnm16/database/csz.php\" method=\"get\" >
    <div>
      <div>
        <label for=\"city\">City:</label>
        <input type=\"text\" name=\"city\" value='$city' required/>
      </div>

      <div>
        <label for=\"state\">State:</label>
        <input type=\"text\" maxlength=\"2\" name=\"state\" value='$state' required/>
      </div>

      <div>
        <label for=\"zip\">ZIP:</label>
        <input type=\"text\" name=\"zip\" value='$zip' required/>
      </div>

      <div>
        <input type=\"submit\" name=\"save\" value=\"Save\" />
        <input type=\"submit\" name=\"cancel\" value=\"Cancel\" />
  </form>";
}

if($_GET['save'])
{
  $city = $_GET['city'];
  $state = $_GET['state'];
  $zip = $_GET['zip'];

  $query = "UPDATE csz SET zip=$zip, state='$state', city='$city' WHERE zip='$zip'";
  pg_query($query);
}

if($_GET['cancel'])
{
  header("location: http://jcsites.juniata.edu/students/smithnm16/database/csz.php");
}

// deletes entries from the database by zip
if($_GET['delete'])
{
$zip=$_GET['zip'];
$query = "DELETE FROM csz WHERE zip='$zip'";
pg_query ($query);
}



pg_close($link);
?>
<html>
  <head>
      <title>CSZ</title>
  </head>
  <body>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/csz.php" method="get" >
      <div>
        <div>
          <label for="city">City:</label>
          <input type="text" name="city" required/>
        </div>

        <div>
          <label for="state">State:</label>
          <input type="text" minlength="2" maxlength="2" name="state" required/>
        </div>

        <div>
          <label for="zip">ZIP:</label>
          <input type="text" name="zip" required/>
        </div>

        <div>
          <input type="submit" name="add" value="Add" />
      </div>
    </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/csz.php" method="get">
      <div>
      <input type="submit" name="report" value="Report"/>
    </div>
  </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/csz.php" method="get">
      <div>
        <label for="zip">ZIP</label>
        <input type="text" name="zip" required/>
        <input type="submit" name="edit" value="Edit" />
        <input type="submit" name="delete" value="Delete" />
      </div>
    </form>
  </body>
</html>
