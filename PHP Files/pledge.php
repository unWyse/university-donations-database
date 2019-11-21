<?PHP
/* Pledge Table
Nick Smith & Kyle Wyse
12/5/2018
http://jcsites.juniata.edu/students/smithnm16/pledge.php
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
echo "<h1>Pledge</h1>";
// login to database
$link = pg_connect("host=itcsdbms user=rhodes password=guest dbname=univdonations")
  or die ("Could not connect to database");

// shows data entries if user enters report button
if($_GET['report'])
{
$query = "SELECT * FROM pledge ";
$result = pg_query ($query)
    or die ("Query failed");

// printing HTML result
print "<table border=1>\n";
print "<td>Pledge Number</td><td>Date Pledged</td><td>Amount Pledged</td> <td>Number of Payments</td> <td>Donor ID</td> <td>Project Name</td>\n";
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
  $datePledged = $_GET['datePledged'];
  $amountPledged = $_GET['amountPledged'];
  $numPayments = $_GET['numPayments'];
  $donorID = $_GET['donorID'];
  $projName = $_GET['projName'];
  $query = "INSERT INTO pledge (datePledged, amountPledged, numPayments, donorID, projName) VALUES('$datePledged', '$amountPledged', '$numPayments', '$donorID', '$projName')";
  pg_query ($query);
}

if($_GET['edit'])
{
  $pledgeNo = $_GET['pledgeNo'];
  $query = "SELECT datePledged, amountPledged, numPayments, donorID, projName FROM pledge WHERE pledgeNo=$pledgeNo";
  $result = pg_query($query);
  $editData = pg_fetch_array($result);

  $datePledged = $editData[0];
  $amountPledged = $editData[1];
  $numPayments = $editData[2];
  $donorID = $editData[3];
  $projName = $editData[4];

  echo "<form action=\"http://jcsites.juniata.edu/students/smithnm16/database/pledge.php\" method=\"get\" >
    <div>
      <div>
        <label for=\"datePledged\">Date Pleged:</label>
        <input type=\"date\" name=\"datePledged\" value='$datePledged' required/>
      </div>

      <div>
        <label for=\"amountPledged\">amountPledged:</label>
        <input type=\"text\" name=\"amountPledged\" value='$amountPledged' required/>
      </div>

      <div>
        <label for=\"numPayments\">numPayments:</label>
        <input type=\"text\" name=\"numPayments\" value='$numPayments' />
      </div>

      <div>
        <label for=\"donorID\">Donor ID:</label>
        <input type=\"text\" name=\"donorID\" value='$donorID' />
      </div>

      <div>
        <label for=\"projName\">Project Name:</label>
        <input type=\"text\" name=\"projName\" value='$projName' />
      </div>

      <div>
      <input type=\"hidden\" name=\"pledgeNo\" value=$pledgeNo />
      </div>

      <div>
        <input type=\"submit\" name=\"save\" value=\"Save\" />
        <input type=\"submit\" name=\"cancel\" value=\"Cancel\" />
  </form>";
}

if($_GET['save'])
{
  $pledgeNo = $_GET['pledgeNo'];
  $datePledged = $_GET['datePledged'];
  $amountPledged = $_GET['amountPledged'];
  $numPayments = $_GET['numPayments'];
  $donorID = $_GET['donorID'];
  $projName = $_GET['projName'];

  $query = "UPDATE pledge SET datePledged='$datePledged', amountPledged=$amountPledged, numPayments='$numPayments', donorID='$donorID', projName='$projName' WHERE pledgeNo=$pledgeNo";
  pg_query($query);
}

if($_GET['cancel'])
{
  header("location: http://jcsites.juniata.edu/students/smithnm16/database/pledge.php");
}

// deletes entries from the database, ordered to delete by pledgeNo
if($_GET['delete'])
{
$pledgeNo=$_GET['pledgeNo'];
$query = "DELETE FROM pledge WHERE pledgeNo='$pledgeNo'";
pg_query ($query);
}

pg_close($link);
?>
<html>
  <head>
      <title>Pledge</title>
  </head>
  <body>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/pledge.php" method="get" >
      <div>
        <div>
          <label for="datePledged">Date Pledged:</label>
          <input type="date" name="datePledged" required/>
        </div>
        <div>
          <label for="amountPledged">Amount Pledged:</label>
          <input type="text" name="amountPledged" required/>
        </div>
        <div>
          <label for="numPayments">Number of Payments:</label>
          <input type="text" name="numPayments" />
        </div>

        <div>
          <label for="donorID">Donor ID:</label>
          <input type="text" name="donorID" />
        </div>

        <div>
          <label for="projName">Project Name:</label>
          <input type="text" name="projName" />
        </div>

        <div>
          <input type="submit" name="add" value="Add" />
      </div>
    </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/pledge.php" method="get">
      <div>
      <input type="submit" name="report" value="Report"/>
    </div>
  </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/pledge.php" method="get">
      <div>
        <label for="pledgeNo">Pledge No:</label>
        <input type="text" name="pledgeNo" required/>
        <input type="submit" name="edit" value="Edit" />
        <input type="submit" name="delete" value="Delete" />
      </div>
    </form>
  </body>
</html>
