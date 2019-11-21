<?PHP
/* Person Table
Nick Smith & Kyle Wyse
12/5/2018
http://jcsites.juniata.edu/students/smithnm16/person.php
*/echo "<span>
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
echo "<h1>Person</h1>";
// login to database
$link = pg_connect("host=itcsdbms user=rhodes password=guest dbname=univdonations")
  or die ("Could not connect to database");

// shows data entries if user enters report button
if($_GET['report'])
{
$query = "SELECT * FROM person ";
$result = pg_query ($query)
    or die ("Query failed");

// printing HTML result
print "<table border=1>\n";
print "<td>ID</td><td>First Name</td> <td>Last Name</td> <td>Phone</td> <td>Address</td> <td>Graduation Year</td> <td>Category</td> <td>ZIP</td> <td>Corporation Name</td>\n";
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
  $fName = $_GET['fName'];
  $lName = $_GET['lName'];
  $phone = $_GET['phone'];
  $address = $_GET['address'];
  $zip = $_GET['zip'];
  $gradYear = $_GET['gradYear'];
  $corpName = $_GET['corpName'];
  $query = "INSERT INTO class (gradYear) SELECT '$gradYear' WHERE NOT EXISTS (SELECT gradYear FROM class WHERE gradYear='$gradYear')";
  pg_query($query);
  $query = "INSERT INTO person (fName, lName, phone, address, zip, gradYear, corpName) VALUES('$fName', '$lName', $phone, '$address', $zip, $gradYear, '$corpName')";
  pg_query ($query);
}
// deletes entries from the database by donorid
if($_GET['delete'])
{
  $id = $_GET['id'];
  $query = "DELETE FROM person WHERE donorid='$id'";
  pg_query ($query);
}


if($_GET['edit'])
{
  $id = $_GET['id'];
  $query = "SELECT fName, lName, phone, address, zip, gradYear, corpName FROM person WHERE donorid='$id'";
  $result = pg_query($query);
  $editData = pg_fetch_array($result);

  $fName = $editData[0];
  $lName = $editData[1];
  $phone = $editData[2];
  $address = $editData[3];
  $zip = $editData[4];
  $gradYear = $editData[5];
  $corpName = $editData[6];

// action=\"http://jcsites.juniata.edu/students/smithnm16/database/person.php\"
  echo "<form action=\"http://jcsites.juniata.edu/students/smithnm16/database/person.php\" method=\"get\" >
    <div>
      <div>
        <label for=\"fName\">First Name:</label>
        <input type=\"text\" name=\"fName\" value='$fName' required/>
      </div>

      <div>
        <label for=\"lName\">Last Name:</label>
        <input type=\"text\" name=\"lName\" value='$lName' required/>
      </div>

      <div>
        <label for=\"phone\">Phone:</label>
        <input type=\"text\" name=\"phone\" value='$phone' required/>
      </div>

      <div>
        <label for=\"address\">Address:</label>
        <input type=\"text\" name=\"address\" value='$address' required/>
      </div>

      <div>
        <label for=\"zip\">ZIP:</label>
        <input type=\"text\" name=\"zip\" value='$zip' />
      </div>

      <div>
        <label for=\"gradYear\">Graduation Year:</label>
        <input type=\"text\" name=\"gradYear\" value='$gradYear' />
      </div>

      <div>
        <label for=\"corpName\">Corporation Name:</label>
        <input type=\"text\" name=\"corpName\" value='$corpName' />
      </div>

      <div>
      <input type=\"hidden\" name=\"id\" value=$id />
      </div>

      <div>
        <input type=\"submit\" name=\"save\" value=\"Save\" />
        <input type=\"submit\" name=\"cancel\" value=\"Cancel\" />
      </div>
    </div>
  </form>";
}

if($_GET['save'])
{
  $id = $_GET['id'];
  $fName = $_GET['fName'];
  $lName = $_GET['lName'];
  $phone = $_GET['phone'];
  $address = $_GET['address'];
  $zip = $_GET['zip'];
  $gradYear = $_GET['gradYear'];
  $corpName = $_GET['corpName'];

  $query = "UPDATE person SET fName='$fName', lName='$lName', phone=$phone, address='$address', zip=$zip, gradYear=$gradYear, corpName='$corpName' WHERE donorid='$id'";
  pg_query($query);
}

if($_GET['cancel'])
{
  header("location: http://jcsites.juniata.edu/students/smithnm16/database/person.php");
}

pg_close($link);
?>
<html>
  <head>
      <title>Person</title>
  </head>
  <body>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/person.php" method="get" >
      <div>
        <div>
          <label for="fName">First Name:</label>
          <input type="text" name="fName" required/>
        </div>

        <div>
          <label for="lName">Last Name:</label>
          <input type="text" name="lName" required/>
        </div>

        <div>
          <label for="phone">Phone:</label>
          <input type="text" name="phone" required/>
        </div>

        <div>
          <label for="address">Address:</label>
          <input type="text" name="address" required/>
        </div>

        <div>
          <label for="zip">ZIP:</label>
          <input type="text" name="zip" />
        </div>

        <div>
          <label for="gradYear">Graduation Year:</label>
          <input type="text" name="gradYear" />
        </div>

        <div>
          <label for="corpName">Corporation Name:</label>
          <input type="text" name="corpName" />
        </div>

        <div>
          <input type="submit" name="add" value="Add" />
        </div>
      </div>
      </form>
      <form action="http://jcsites.juniata.edu/students/smithnm16/database/person.php" method="get">
        <div>
        <input type="submit" name="report" value="Report"/>
      </div>
    </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/person.php" method="get">
      <div>
        <label for="id">ID</label>
        <input type="text" name="id" required/>
        <input type="submit" name="edit" value="Edit" />
        <input type="submit" name="delete" value="Delete" />
      </div>
    </form>
  </body>
</html>
