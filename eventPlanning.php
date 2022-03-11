<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="event.css">
    <title>Input for Eventplanning</title>
</head>
<body>
    <div class="parent">
        <h1>Eventplanning, Input</h1>
        <p>Enter your names, select the number you bring and send the entry.<br>
            Each participant is aware that this data is transmitted unencrypted.
        </p>
        <table>
            <tr>
                <td><b>Desired</b></td><td><b>Brought</b></td><td><b>Name</b></td><td><b>Quantity</b></td><td><b>action</b></td>
            </tr>
            <tr>
                <form action="eventPlanningInput.php" method="post">
                </form>
            </tr>
<?php
//DB Connect
$servername = "localhost";
$username = "root";
$pw = "";
$dbname= "event";

$con = @new mysqli($servername, $username, $pw, $dbname);
if(!$con){ die("Databaseconnection Error occured"); }


// 
$sql = "SELECT * FROM eventplanning";
$res = $con->query($sql);

$row = 0;
while ($dset = $res->fetch_assoc()){
    $row++;
    $item = $dset["item"];
    echo "<tr><td>" . $item . " (" . $dset["quantity"] . " or more " . $dset["unit"] . " )</td>

        <td>" . listData($row, $item, $con) . "</td>

        <form action='eventPlanning.php' method='post'>" . compareWish($item, $con, $row);

        $maximum = $dset["quantity"];
        echo "Maximum: " . $maximum;
        for($i = 1; $i <= $maximum; $i++){
            echo "<option value = $i>$i</option>";
        }
        echo "</select></td>

        <td><input type='submit' name='send$row'></td>
        </form>
        <tr>";
 }


// Mitgebrachtes Listen von anderere Tabelle Input (Zeilennummer, item, Rferenz auf DB-Verbindung)
function listData($position, $item, &$con){
    $answer = "";

    if (isset($_POST["send$position"])){  //send1
        $sql = "INSERT INTO eventInput (forename, quantity, item) VALUES (?, ?, ?)";
        $ps = $con->prepare($sql);

        if(!$ps) {
            echo "<script>alert('Error in Prepared Statement occured!')</script>";
            exit;
        }

        $bind = $ps->bind_param("sis", $_POST["forename$position"], $_POST[$position], $item); //name und quantity und item (fleisch)
        if(!$bind){
            echo "Error on bind!";
        }
        $ps->execute();  
        $ps->close();
    }

        $sql = "SELECT forename, quantity FROM eventInput WHERE item='$item'";
        $result = $con->query($sql);
        while($dset = $result->fetch_assoc()){
            $answer .= $dset["forename"] . " , " . $dset["quantity"] . " ";
        }
    return $answer;
}


// Vergleich zwischen mitgebrachten und gewünschter Anzahl an item von beiden Tabellen. Input(item, Referenz auf DB-Verbindung, Zeilennummer)
function compareWish($item, &$con, $row){
    $sql = "SELECT SUM(quantity) AS value_sum FROM eventinput WHERE item='$item'";
    $res = $con->query($sql);
    $dset = $res->fetch_assoc();
    $mitgebracht = $dset["value_sum"]; // mitgebrachtes 

    echo $mitgebracht . "<br>";

    $sql2 = "SELECT SUM(quantity) AS value_sum2 FROM eventplanning WHERE item='$item'";
    $res2 = $con->query($sql2);
    $dset2 = $res2->fetch_assoc();
    $gewuenscht = $dset2["value_sum2"]; // gewünschtes

    echo $gewuenscht . "<br>";

    if($gewuenscht <= $mitgebracht){
        $ret = "<td><input type='text' name='forename$row' required hidden></td><td><select required name=$row disabled>"; 
    }
    else{
        $ret = "<td><input type='text' name='forename$row' required></td><td><select required name=$row>";
    }
    
    return $ret;
}
echo "</table></div><a href='eventPlanningInput.php'>Enter more items</a>"
?>

</body>
</html>