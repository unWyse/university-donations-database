<?PHP
/* donation Table
Nick Smith & Kyle Wyse
12/5/2018
http://jcsites.juniata.edu/students/smithnm16/creditCardNo.php
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
echo "<h1>Donation</h1>";
// login to database
$link = pg_connect("host=itcsdbms user=rhodes password=guest dbname=univdonations")
  or die ("Could not connect to database");

// shows data entries if user enters report button
if($_GET['report'])
{
$query = "SELECT * FROM donation ";
$result = pg_query ($query)
    or die ("Query failed");

// printing HTML result
print "<table border=1>\n";
print "<td>Credit Card Number</td><td>Date Paid</td> <td>Check Number</td> <td>Amount Paid</td> <td>Payment Method</td><td>Pledge Number</td>\n";
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
  $creditCardNo = $_GET['creditCardNo'];
  $datePaid = $_GET['datePaid'];
  $checkNo = $_GET['checkNo'];
  $amountPaid = $_GET['amountPaid'];
  $paymentMethod = $_GET['paymentMethod'];
  $pledgeNo = $_GET['pledgeNo'];
  $query = "INSERT INTO donation (creditCardNo, datePaid, checkNo, amountPaid, paymentMethod, pledgeNo) VALUES('$creditCardNo', '$datePaid', '$checkNo', '$amountPaid', '$paymentMethod', '$pledgeNo')";
  pg_query ($query);
}

if($_GET['edit'])
{
  $datePaid = $_GET['datePaid'];
  $query = "SELECT creditCardNo, datePaid, checkNo, amountPaid, paymentMethod, pledgeNo FROM donation WHERE datePaid='$datePaid'";
  $result = pg_query($query);
  $editData = pg_fetch_array($result);

  $creditCardNo = $editData[0];
  $datePaid = $editData[1];
  $checkNo = $editData[2];
  $amountPaid = $editData[3];
  $paymentMethod = $editData[4];
  $pledgeNo = $editData[5];

  echo "<form action=\"http://jcsites.juniata.edu/students/smithnm16/database/donation.php\" method=\"get\" >
    <div>
      <div>
        <label for=\"creditCardNo\">donation Name:</label>
        <input type=\"text\" maxlength=\"16\" name=\"creditCardNo\" value='$creditCardNo' />
      </div>

      <div>
        <label for=\"datePaid\">datePaid:</label>
        <input type=\"date\" name=\"datePaid\" value='$datePaid' required/>
      </div>

      <div>
        <label for=\"checkNo\">Check Number:</label>
        <input type=\"text\" maxlength=\"9\" name=\"checkNo\" value='$checkNo' />
      </div>

      <div>
        <label for=\"amountPaid\">Amount Paid:</label>
        <input type=\"text\" name=\"amountPaid\" value='$amountPaid' required/>
      </div>

      <div>
        <label for=\"paymentMethod\">Payment Method:</label>
        <input type=\"text\" name=\"paymentMethod\" value='$paymentMethod' required/>
      </div>

      <div>
        <label for=\"pledgeNo\">Pledge Number:</label>
        <input type=\"text\" name=\"pledgeNo\" value='$pledgeNo' />
      </div>

      <div>
        <input type=\"submit\" name=\"save\" value=\"Save\" />
        <input type=\"submit\" name=\"cancel\" value=\"Cancel\" />
  </form>";
}

if($_GET['save'])
{
  $creditCardNo = $_GET['creditCardNo'];
  $datePaid = $_GET['datePaid'];
  $checkNo = $_GET['checkNo'];
  $amountPaid = $_GET['amountPaid'];
  $paymentMethod = $_GET['paymentMethod'];
  $pledgeNo = $_GET['pledgeNo'];

  $query = "UPDATE donation SET creditCardNo=$creditCardNo, datePaid='$datePaid', checkNo='$checkNo', amountPaid=$amountPaid, paymentMethod='$paymentMethod', pledgeNo=$pledgeNo WHERE datePaid='$datePaid'";
  pg_query($query);
}

if($_GET['cancel'])
{
  header("location: http://jcsites.juniata.edu/students/smithnm16/database/donation.php");
}

// deletes entries from the database, ordered to delete by datePaid
if($_GET['delete'])
{
$datePaid=$_GET['datePaid'];
$query = "DELETE FROM donation WHERE datePaid='$datePaid'";
pg_query ($query);
}

pg_close($link);
?>
<html>
  <head>
      <title>Donation</title>
  </head>
  <body>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/donation.php" method="get" >
      <div>
        <div>
          <label for="creditCardNo">Credit Card Number:</label>
          <input type="text" minlength="16" maxlength="16" name="creditCardNo" />
        </div>
        <div>
          <label for="datePaid">Date Paid:</label>
          <input type="date" name="datePaid" required/>
        </div>
        <div>
          <label for="checkNo">Check Number:</label>
          <input type="text" minlength="9" maxlength="9"name="checkNo" />
        </div>

        <div>
          <label for="amountPaid">Amount Paid:</label>
          <input type="text" name="amountPaid" required/>
        </div>

        <div>
          <label for="paymentMethod">Payment Method:</label>
          <input type="text" name="paymentMethod" required/>
        </div>

        <div>
          <label for="pledgeNo">Pledge Number:</label>
          <input type="text" name="pledgeNo" />
        </div>

        <div>
          <input type="submit" name="add" value="Add" />
      </div>
    </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/donation.php" method="get">
      <div>
      <input type="submit" name="report" value="Report"/>
    </div>
  </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/donation.php" method="get">
      <div>
        <label for="datePaid">Date Paid</label>
        <input type="date" name="datePaid" required/>
        <input type="submit" name="edit" value="Edit" />
        <input type="submit" name="delete" value="Delete" />
      </div>
    </form>
  </body>
</html>
