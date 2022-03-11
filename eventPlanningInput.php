<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="event.css">
    <title>eventPlanning</title>
</head>
<body>
    <div class="parent">
    <h1>Eventplanning, Input</h1>
    <table>
        <tr>
            <td>item</td><td>Desired whole quantity</td><td>unit</td>
        </tr>
        <tr>
        <form action="eventPlanningInput.php" method="post">
            <td><input type="text" name="item" required></td><td><input type="text" name="quantity" required></td>
            <td><input type="text" name="unit"></td><td><input type="submit" name="send" required></td>
        </form>
        </tr>
<?php
//Connect to DB
$servername = "localhost";
$username = "root";
$pw = "";
$dbname= "event";

$con = @new mysqli($servername, $username, $pw, $dbname);

if(!$con){ die("Databaseconnection Error occured"); }


// Datensätze lesen und als Tabelle auflisten
function listData($con){
    $sql = "SELECT * FROM eventPlanning";
    $ps = $con->prepare($sql);
    
    if(!$ps) {
        echo "<script>alert('Error on Prepare Statement!')</script>";
        exit;
    }
    
    $ps->execute();
    
    $bind = $ps->bind_result($item, $quantity, $unit);
    if(!$bind){ 
        echo "Error on Bind!"; 
        exit;
    }

    $ps->store_result();
    if($ps->num_rows != 0){
        while($ps->fetch()){
            echo "<tr><td>" . $item . "</td>" . "<td>" . $quantity . "</td>" . "<td>" . $unit . "</td></tr>";
        }
    }
    $ps->close();
}

listData($con);


// Enter Data
if(isset($_POST["send"])){

    $quantity = intval(htmlentities($_POST["quantity"]));
    if($quantity == 0){ 
        echo "<script>alert('Error! No quantity!')</script>"; 
        exit;
    }

    $sql = "INSERT INTO eventPlanning (item, quantity, unit) VALUES (?, ?, ?)";
    $ps = $con->prepare($sql);

    if(!$ps) {
        echo "<script>alert('Error on Prepare Statement!')</script>";
        exit;
    }

    $bind = $ps->bind_param("sis", $_POST["item"], $_POST["quantity"], $_POST["unit"]);
     
    if(!$bind){ 
        echo "Error on Parameterbind!"; 
        exit;
    }

    echo "<tr><td>" . htmlentities($_POST["item"]) . "</td>" . "<td>" . htmlentities($_POST["quantity"]) . "</td>" . "<td>" . htmlentities($_POST["unit"]) . "</td></tr>";

    $ps->execute();
    $ps->close();
}
echo "</table></div><br><button><a href='eventPlanning.php'>To division</a></button>";

$con->close();
?>
    </table>
    </div>
</body>
</html>
